<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Serial_number extends Model
{
    //
    protected $guarded = ['id'];
    

    public function product()
    {
        return $this->belongsTo('App\Models\Products\Product', 'product_id', 'id');
    }
    
    public function order_detail()
    {
        return $this->belongsTo('App\Models\Orders\Order_detail', 'order_detail_id', 'id');
    }

    public function order_return_detail()
    {
        return $this->belongsTo('App\Models\Orders\Order_return_detail', 'order_return_detail_id', 'id');
    }

    public function warranty_detail()
    {
        return $this->belongsTo('App\Models\Warranty\Warranty_detail', 'warranty_detail_id', 'id');
    }

    public function warranty_exchange_detail()
    {
        return $this->belongsTo('App\Models\Warranty\Warranty_exchange_detail', 'warranty_exchange_detail_id', 'id');
    }

    



}