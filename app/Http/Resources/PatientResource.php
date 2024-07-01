<?php

namespace App\Http\Resources;

use App\Http\Resources\DoctorResource;
use App\Http\Resources\FacilityResource;
use App\Http\Resources\AppointmentResource;
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
            'doctor_id' => $this->doctor_id,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'blood_group' => $this->blood_group,
            'genotype' => $this->genotype,
            'location_id' => $this->location_id,
            'image' => $this->image,
            'country' => $this->country,
            'state' => $this->state,
            'lga' => $this->lga,
            'phone_number' => $this->phone_number,
            'weight' => $this->weight,
            'height' => $this->height,
            'surgical_history' => $this->surgical_history,
            'average_heart_rate' => $this->average_heart_rate,
            'allergies_1' => $this->allergies_1,
            'allergies_2' => $this->allergies_2,
            'other_allergies' => $this->other_allergies,
            'condition_1' => $this->condition_1,
            'condition_2' => $this->condition_2,
            'other_conditions' => $this->other_conditions,
            'doctor' => new DoctorResource($this->doctor),
            'appointment' => new AppointmentResource($this->appointment),
            'recommended_facility' => new FacilityResource($this->facility),
        ];
    }
}
