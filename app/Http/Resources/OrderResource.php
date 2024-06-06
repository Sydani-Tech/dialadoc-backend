<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_id' => $this->order_id,
            'prescription_id' => $this->prescription_id,
            'pharmacy_id' => $this->pharmacy_id,
            'consultation_id' => $this->consultation_id,
            'user_id' => $this->user_id,
            'order_date' => $this->order_date,
            'order_type' => $this->order_type,
            'status' => $this->status
        ];
    }
}
