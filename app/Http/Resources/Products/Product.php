<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [

            'id' => $this->id,
            'price' => $this->price,
            'cost' => $this->cost,
            'name' => $this->name,
            'quantity' => "1",
            'having_serial' => $this->having_serial
 
        ];
    }
}
