<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    //
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders\order', 'order_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo('App\Models\Products\Product', 'product_id', 'id');
    }
    
    public function serial_numbers()
    {
        return $this->hasMany('App\Models\Products\Serial_number', 'order_detail_id');
    }

}
