<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\User\LoginUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
}
