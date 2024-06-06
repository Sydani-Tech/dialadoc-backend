<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InsuranceResource extends JsonResource
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
            'insurance_id' => $this->insurance_id,
            'patient_id' => $this->patient_id,
            'provider_name' => $this->provider_name,
            'policy_number' => $this->policy_number,
            'coverage_details' => $this->coverage_details
        ];
    }
}
