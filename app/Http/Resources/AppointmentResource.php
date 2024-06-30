<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'appointment_id' => $this->appointment_id,
            'consultation_id' => $this->consultation_id,
            'appointment_time' => $this->appointment_time,
            'appointment_date' => $this->appointment_date,
            'status' => $this->status,
            'consultation' => new ConsultationResource($this->consultation)
        ];
    }
}
