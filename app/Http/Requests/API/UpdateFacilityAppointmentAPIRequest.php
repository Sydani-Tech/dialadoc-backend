<?php

namespace App\Http\Requests\API;

use App\Models\FacilityAppointment;
use InfyOm\Generator\Request\APIRequest;

class UpdateFacilityAppointmentAPIRequest extends APIRequest
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
        $rules = FacilityAppointment::$rules;
        
        return $rules;
    }
}
