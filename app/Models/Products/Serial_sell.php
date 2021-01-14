<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Serial_sell extends Model
{
    //
    protected $guarded = ['id'];

    protected $table = 'serial_sell';

    //this relation should be manyThrough
    public function product()
    {
        return $this->belongsTo('App\Models\Products\Product', 'product_id', 'id');
    }

    public function order_detail()
    {
        return $this->belongsTo('App\Models\Orders\Order_detail', 'order_detail_id', 'id');
    } 
}
