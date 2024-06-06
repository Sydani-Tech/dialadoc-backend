<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResultResource extends JsonResource
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
            'test_result_id' => $this->test_result_id,
            'record_id' => $this->record_id,
            'test_name' => $this->test_name,
            'result' => $this->result,
            'date_performed' => $this->date_performed,
            'created_by' => $this->created_by
        ];
    }
}
