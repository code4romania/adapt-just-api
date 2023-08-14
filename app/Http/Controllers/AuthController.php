<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetLinkControllerRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Resources\User\LoginUserResource;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function currentUser(Request $request): LoginUserResource
    {
        return new LoginUserResource($request->user());
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ( RateLimiter::tooManyAttempts($this->throttleKey(), 5) ) {
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again later.'
            ]);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials, $request->boolean('remember')))
        {
            RateLimiter::hit($this->throttleKey(), $seconds = 1800);
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => __('auth.failed'),
            ]);
        }
        RateLimiter::clear($this->throttleKey());

        $token = $user->createToken($user->email);

        return ['token' => $token->plainTextToken];
    }

    /**
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::lower(request('email')) . '|' . request()->ip();
    }

    /**
     * @throws \Throwable
     */
    protected function authenticated(Request $request, $user)
    {
        try {
            return response()->json([], \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            $this->logout($request);

            throw $e;
        }
    }

    public function logout(Request $request): Response
    {
        Auth::guard('api')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->noContent();
    }


    public function forgotPassword(PasswordResetLinkControllerRequest $request)
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['message' => __($status)]);
    }

    public function resetPassword(PasswordResetRequest $request)
    {
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['message' => __($status)]);
    }
}
