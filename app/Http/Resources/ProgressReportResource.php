<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgressReportResource extends JsonResource
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
            'report_id' => $this->report_id,
            'plan_id' => $this->plan_id,
            'created_by' => $this->created_by,
            'report_date' => $this->report_date,
            'progress_description' => $this->progress_description
        ];
    }
}
