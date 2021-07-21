<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
/**
* Transform the resource into an array.
*
* @param \Illuminate\Http\Request $request
* @return array
*/
public function toArray($request)
{
        // $client = parent::toArray($request);
        return [
        'id' => $this->id,
        'name' => $this->name,
        'cost' => $this->cost,
        'price' => $this->price,
        'inStock' => $this->inStock(),
        'branch_id' => $this->branch_id,
        'quantity' => 1,
        'having_serial' => $this->having_serial,
        ];
    }
}
