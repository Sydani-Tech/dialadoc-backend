<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'blood_group' => $this->blood_group,
            'genotype' => $this->genotype,
            'location_id' => $this->location_id,
            'vital_signs' => $this->vitalSigns(),
            'allergies' => $this->allergies()
        ];
    }
}
