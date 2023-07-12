<?php

namespace App\Http\Requests\Complaint;

use App\Constants\ComplaintConstant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetInstitutionsRequest extends FormRequest
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
            'victim' => [
                'required',
                Rule::in(ComplaintConstant::victims())
            ],
            'type' => [
                Rule::requiredIf($this->get('victim') == ComplaintConstant::VICTIM_ME)
            ]

        ];
    }
}
