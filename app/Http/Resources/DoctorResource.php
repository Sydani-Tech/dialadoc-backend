<?php

namespace App\Http\Resources;

use App\Http\Resources\ConsultationResource;
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
            'years_practising' => $this->years_practising,
            'mdcn_license' => $this->mdcn_license,
            'cpd_annual_license' => $this->cpd_annual_license,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'healthcare_practitioner_type' => $this->healthcare_practitioner_type,
            'role_in_facility' => $this->role_in_facility,
            'country' => $this->country,
            'state' => $this->state,
            'lga' => $this->lga,
            'bio' => $this->bio,
            // 'consultations' => ConsultationResource::collection($this->consultations)
        ];
    }
}
