<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityAppointmentResource extends JsonResource
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
            'patient_record' => $this->patient_record,
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->appointment_time,
            'facility_id' => $this->facility_id,
            'appointment_status' => $this->appointment_status,
            'results' => $this->results,
            'documents_url' => $this->documents_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
