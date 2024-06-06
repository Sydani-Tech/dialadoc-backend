<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthMetricResource extends JsonResource
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
            'metric_id' => $this->metric_id,
            'patient_id' => $this->patient_id,
            'metric_type' => $this->metric_type,
            'value' => $this->value,
            'measurement_date' => $this->measurement_date,
            'created_by' => $this->created_by
        ];
    }
}
