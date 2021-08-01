<?php

namespace App\Http\Resources\Microcredit\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $all =  parent::toArray($request);
        // $all['purchased'] = $this->purchased();
        // $all['sold'] = $this->sold();
        // $all['inStock'] = $this->inStock();
        // $all['quantity'] = 1;
        // return $all;
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'type' => $this->transactionable_type == 'App\Models\Microcredit\Dps\Dps' ? 'dps' : 'loan',
            'date' => $this->date,
            'employee_name' =>  isset($this->employee->user) ? $this->employee->user->name : ''
        ];

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
