<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class Serial_number extends JsonResource
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
            'isNew' => false,
            'number' => $this->number,
            'product_id' => $this->product_id,
            'status' => 'Purchase'
        ];
    }
}
