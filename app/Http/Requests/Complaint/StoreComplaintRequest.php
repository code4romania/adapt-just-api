<?php

namespace App\Http\Requests\Complaint;

use App\Constants\ComplaintConstant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreComplaintRequest extends FormRequest
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
        $victim = $this->get('victim', null);
        $type   = $this->get('type', null);

        if ($victim == ComplaintConstant::VICTIM_ME) {
            switch ($type) {
                case ComplaintConstant::TYPE_HURT:
                    return $this->meHurtRules();
                case ComplaintConstant::TYPE_MOVE:
                    return $this->meMoveRules();
                case ComplaintConstant::TYPE_EVALUATION:
                    return  $this->meEvaluationRules();
            }
        }
        return $this->otherRules();

    }

    protected function meHurtRules()
    {
        return [
            'victim' => [
                'required',
                Rule::in(ComplaintConstant::victims())
            ],
            'type' => [
                'required',
                Rule::in(ComplaintConstant::types())
            ],
            'name' => [
                'required',
                'max:255'
            ],
            'location_id' => [
                'sometimes'
            ],
            'location_name' => [
                'sometimes'
            ],
            'details' => [
                'required',
                'array'
            ],
            'reason' => [
                Rule::requiredIf(in_array(ComplaintConstant::DETAIL_OTHER, $this->get('details', [])))
            ],
            'proof_type' => [
                'required',
                Rule::in(ComplaintConstant::proofTypes())
            ],
            'uploads' => [
                Rule::requiredIf($this->get('proof_type') == ComplaintConstant::PROOF_TYPE_YES),
                'array'
            ],
            'cnp' => [
                'sometimes'
            ],
            'id_card_upload' => [
                'sometimes'
            ],
            'signature' => [
                'sometimes'
            ]
        ];
    }

    protected function meMoveRules()
    {
        return [
            'victim' => [
                'required',
                Rule::in(ComplaintConstant::victims())
            ],
            'type' => [
                'required',
                Rule::in(ComplaintConstant::types())
            ],
            'name' => [
                'required',
                'max:255'
            ],
            'location_id' => [
                'sometimes',
                'integer'
            ],
            'location_name' => [
                'sometimes'
            ],
            'location_to_id' => [
                'sometimes',
            ],
            'location_to_name' => [
                'sometimes',
            ],
            'location_to_type' => [
                'sometimes'
            ],
            'reason' => [
                'required'
            ],
            'cnp' => [
                'sometimes'
            ],
            'id_card_upload' => [
                'sometimes'
            ],
            'signature' => [
                'sometimes'
            ]
        ];
    }

    protected function meEvaluationRules()
    {
        return [
            'victim' => [
                'required',
                Rule::in(ComplaintConstant::victims())
            ],
            'type' => [
                'required',
                Rule::in(ComplaintConstant::types())
            ],
            'name' => [
                'required',
                'max:255'
            ],
            'location_id' => [
                'sometimes'
            ],
            'location_name' => [
                'sometimes'
            ],
            'cnp' => [
                'sometimes'
            ],
            'id_card_upload' => [
                'sometimes'
            ],
            'signature' => [
                'sometimes'
            ]
        ];
    }

    protected function otherRules()
    {
        return [
            'victim' => [
                'required',
                Rule::in(ComplaintConstant::victims())
            ],
            'name' => [
                'required',
                'max:255'
            ],
            'location_id' => [
                Rule::requiredIf(!$this->get('location_name'))
            ],
            'location_name' => [
                Rule::requiredIf(!$this->get('location_id'))
            ],
            'reason' => [
                'required'
            ],
            'proof_type' => [
                'required',
                Rule::in(ComplaintConstant::proofTypes())
            ],
            'uploads' => [
                Rule::requiredIf($this->get('proof_type') == ComplaintConstant::PROOF_TYPE_YES),
                'array'
            ],
            'cnp' => [
                'sometimes'
            ],
            'id_card_upload' => [
                'sometimes'
            ],
            'signature' => [
                'sometimes'
            ]
        ];
    }
}
