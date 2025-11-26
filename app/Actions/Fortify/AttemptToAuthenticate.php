<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\LoginRateLimiter;

class AttemptToAuthenticate
{
    /**
     * The guard implementation.
     */
    protected StatefulGuard $guard;

    /**
     * The login rate limiter instance.
     */
    protected LoginRateLimiter $limiter;

    /**
     * Create a new controller instance.
     */
    public function __construct(StatefulGuard $guard, LoginRateLimiter $limiter)
    {
        $this->guard = $guard;
        $this->limiter = $limiter;
    }

    /**
     * Handle the incoming request.
     */
    public function handle(Request $request, callable $next)
    {
        if (Fortify::$authenticateUsingCallback) {
            return $this->handleUsingCustomCallback($request, $next);
        }

        if ($this->guard->attempt(
            $request->only(Fortify::username(), 'password'),
            $request->boolean('remember')
        )) {
            $user = $this->guard->user();

            // Check if user account is active
            if ($user->status !== 'active') {
                $this->guard->logout();

                $message = match ($user->status) {
                    'pending' => 'Your account is pending approval. Please contact an administrator.',
                    'banned' => 'Your account has been banned. Please contact an administrator.',
                    default => 'Your account is not active. Please contact an administrator.',
                };

                throw ValidationException::withMessages([
                    Fortify::username() => [$message],
                ]);
            }

            // Check if user has a valid role
            if (!in_array($user->role, ['creator', 'member', 'admin'])) {
                $this->guard->logout();

                throw ValidationException::withMessages([
                    Fortify::username() => ['Invalid account type. Please contact an administrator.'],
                ]);
            }

            // Update last login timestamp
            User::where('id', $user->id)->update(['last_login_at' => now()]);

            return $next($request);
        }

        throw ValidationException::withMessages([
            Fortify::username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Attempt to authenticate using a custom callback.
     */
    protected function handleUsingCustomCallback(Request $request, callable $next)
    {
        if (! call_user_func(Fortify::$authenticateUsingCallback, $request, $this->guard)) {
            throw ValidationException::withMessages([
                Fortify::username() => [trans('auth.failed')],
            ]);
        }

        return $next($request);
    }
}
