<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
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
            'id' => $this->id,
            'logo_url' => $this->logo_url,
            'facility_name' => $this->facility_name,
            'role_in_facility' => $this->role_in_facility,
            'country' => $this->country,
            'state' => $this->state,
            'lga' => $this->lga,
            'working_hours' => $this->working_hours,
            'helpdesk_email' => $this->helpdesk_email,
            'helpdesk_number' => $this->helpdesk_number,
            'number_of_staff' => $this->number_of_staff,
            'year_of_inception' => $this->year_of_inception,
            'facility_type' => $this->facility_type,
            'cac_number' => $this->cac_number,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
