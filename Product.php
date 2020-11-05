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
        return parent::toArray($request);


        /*$all =  parent::toArray($request);
        $all['purchased'] = $this->purchased();
        $all['sold'] = $this->sold();
        $all['inStock'] = $this->inStock();
        $all['quantity'] = 1;
        return $all;*/

        /*return [

            'id' => $this->id,
            'price' => $this->price,
            'cost' => $this->cost,
            'name' => $this->name,
            'quantity' => 1,
            'having_serial' => $this->having_serial,
            'description' => $this->description,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'warranty' => $this->warranty,
            'alert_quantity' => $this->alert_quantity,
            'created_by' => $this->created_by,

 
        ];*/
    }
}
