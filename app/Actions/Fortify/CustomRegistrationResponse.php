<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomRegistrationResponse implements RegisterResponse
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Get the authenticated user (Fortify automatically logs them in)
        $user = auth()->user();

        // Determine role-based message and redirect
        $roleConfig = [
            'creator' => [
                'message' => 'Creator account created successfully! Welcome to Curaçao Talents. Start showcasing your talents.',
                'redirect' => '/creator/dashboard'
            ],
            'member' => [
                'message' => 'Client account created successfully! Welcome to Curaçao Talents. Discover talented creators.',
                'redirect' => '/member/dashboard'
            ],
            'admin' => [
                'message' => 'Admin account created successfully! Welcome to Curaçao Talents.',
                'redirect' => '/admin/dashboard'
            ]
        ];

        $userRole = $user ? $user->role : 'member';
        $config = $roleConfig[$userRole] ?? $roleConfig['member'];

        // Handle JSON requests
        if ($request->wantsJson()) {
            return new JsonResponse([
                'success' => true,
                'message' => $config['message'],
                'redirect' => $config['redirect']
            ], 201);
        }

        // For web requests, redirect to appropriate dashboard with success message
        return redirect($config['redirect'])->with('status', $config['message']);
    }
}
