<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PolicyResource extends JsonResource
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
            "type" => "ShuangSeQiu",
            "id" => $this->insurable->id,
            "period" => $this->period,
            "created_at" => $this->created_at,
            "number" => $this->insurable->number,
            "recommended_number" => $this->insurable->recommended_number
          ];
    }
}
