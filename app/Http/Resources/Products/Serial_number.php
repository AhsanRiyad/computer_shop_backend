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

        $serials =  parent::toArray($request);
        // $serials['product'] = $this->product;
        $serials['product_id'] = $this->order_detail_purchase->product_id;
        $serials['order_detail_purchase'] = $this->order_detail_purchase;

        return $serials;

        // return response( $serials  , 200);

       /* return [
            'isNew' => false,
            'number' => $this->number,
            'product_id' => $this->product_id,
            'status' => 'Purchase'
        ];*/
    }
}
