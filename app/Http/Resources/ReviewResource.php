<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'review_id' => $this->review_id,
            'doctor_id' => $this->doctor_id,
            'patient_id' => $this->patient_id,
            'rating' => $this->rating,
            'review_text' => $this->review_text,
            'review_date' => $this->review_date
        ];
    }
}
