<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'doctor_id' => $this->doctor_id,
            'user_id' => $this->user_id,
            'specialization_id' => $this->specialization_id,
            'location_id' => $this->location_id,
            'experience_years' => $this->experience_years,
            'mdcn_license' => $this->mdcn_license,
            'cpd_annual_license' => $this->cpd_annual_license,
            'bank_details' => $this->bank_details
        ];
    }
}
