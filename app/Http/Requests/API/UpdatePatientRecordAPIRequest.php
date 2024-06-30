<?php

namespace App\Http\Requests\API;

use App\Models\PatientRecord;
use InfyOm\Generator\Request\APIRequest;

class UpdatePatientRecordAPIRequest extends APIRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = PatientRecord::$rules;
        
        return $rules;
    }
}
