<?php

namespace App\Http\Resources;

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
            'appointment_id' => $this->appointment_id,
            'notes' => $this->notes,
            'created_by' => $this->created_by,
            'consultation_date' => $this->consultation_date
        ];
    }
}
