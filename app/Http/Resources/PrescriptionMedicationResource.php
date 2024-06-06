<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionMedicationResource extends JsonResource
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
            'prescription_medication_id' => $this->prescription_medication_id,
            'prescription_id' => $this->prescription_id,
            'medication_id' => $this->medication_id,
            'dosage' => $this->dosage,
            'frequency' => $this->frequency
        ];
    }
}
