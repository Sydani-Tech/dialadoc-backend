<?php

namespace App\Http\Resources;

use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
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
            'consultation_id' => $this->consultation_id,
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'affected_body_part' => $this->affected_body_part,
            'nature_of_illness' => $this->nature_of_illness,
            'type_of_appointment' => $this->type_of_appointment,
            'description' => $this->description,
            'status' => $this->status,
            'appointment' => new AppointmentResource($this->appointment)
        ];
    }
}
