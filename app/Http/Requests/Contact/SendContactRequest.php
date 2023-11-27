<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class SendContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'max:50'
            ],
            'last_name' => [
                'required',
                'max:50'
            ],
            'email' => [
                'required',
                'email'
            ],
            'message' => [
                'required',
                'max:600'
            ],
            'g-recaptcha-response' => [
                'required',
                'recaptchav3:contactForm,0.5'
            ]
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'prenume',
            'last_name' => 'nume',
            'email' => 'email',
            'message' => 'mesaj'
        ];
    }

    public function messages()
    {
       return [
           'g-recaptcha-response.recaptchav3' => 'Validarea Captcha a esuat'
       ];
    }

}
