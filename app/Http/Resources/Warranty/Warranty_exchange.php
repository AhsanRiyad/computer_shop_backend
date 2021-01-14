<?php

namespace App\Http\Resources\Warranty;

use Illuminate\Http\Resources\Json\JsonResource;

class Warranty_exchange extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
