<?php

namespace App\Http\Requests;

use App\Rules\ConsecutiveCharactersRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as ValidationPassword;
use Infinitypaul\LaravelPasswordHistoryValidation\Rules\NotFromPasswordHistory;

class PasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>|RedirectResponse
     */
    public function rules()
    {
        $user = Password::getUser($this->all());
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                Rule::unique('users', 'email')->where(function ($query) use ($user) {
                    return $query->where('email', $user->email);
                }),
                ValidationPassword::min(8)
                    ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }
}
