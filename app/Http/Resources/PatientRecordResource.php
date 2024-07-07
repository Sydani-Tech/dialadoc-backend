<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientRecordResource extends JsonResource
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
            'update_type' => $this->update_type,
            'suspected_illness' => $this->suspected_illness,
            'findings' => $this->findings,
            'recommended_tests' => $this->recommended_tests,
            'prescriptions' => $this->prescriptions,
            'appointment' => new AppointmentResource($this->appointments),
            'recommended_facility' => new FacilityResource($this->facility),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
