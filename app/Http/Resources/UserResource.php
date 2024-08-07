<?php

namespace App\Http\Resources;

use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\ConsultationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'remember_token' => $this->remember_token,
            'created_at' => $this->created_at,
            'role' => $this->roles()->first(),
            'permissions' => $this->getAllPermissions(),
            'is_profile_updated' => $this->is_profile_updated,
            'patient_profile' => new PatientResource($this->patientProfile),
            'doctor_profile' => new DoctorResource($this->doctorProfile),
            'facility_profile' => new FacilityResource($this->facilityProfile),
        ];
    }
}
