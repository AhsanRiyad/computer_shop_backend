<?php

namespace App\Http\Resources\Microcredit\Nominee;

use Illuminate\Http\Resources\Json\JsonResource;

class Nominee extends JsonResource
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
