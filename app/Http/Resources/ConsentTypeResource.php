<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsentTypeResource extends JsonResource
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
            'consent_id' => $this->consent_id,
            'user_id' => $this->user_id,
            'doctor_id' => $this->doctor_id,
            'consent_type' => $this->consent_type,
            'granted' => $this->granted,
            'consent_date' => $this->consent_date
        ];
    }
}
