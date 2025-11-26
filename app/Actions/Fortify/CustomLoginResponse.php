<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;

class CustomLoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request)
    {
        $user = auth()->user();

        // Check if user is active
        if (!$user->isActive()) {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is not active. Please contact an administrator.',
            ]);
        }

        // Redirect based on user role
        switch ($user->role) {
            case 'admin':
                return redirect()->intended('/admin/dashboard');
            case 'creator':
                return redirect()->intended('/creator/dashboard');
            case 'member':
                return redirect()->intended('/member/dashboard');
            default:
                return redirect()->intended(Fortify::redirects('login', '/dashboard'));
        }
    }
}
