<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
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
            'prescription_id' => $this->prescription_id,
            'doctor_id' => $this->doctor_id,
            'patient_id' => $this->patient_id,
            'date_issued' => $this->date_issued,
            'created_by' => $this->created_by
        ];
    }
}
