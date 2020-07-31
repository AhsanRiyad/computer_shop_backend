<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Serials_sell extends Model
{
    //
    protected $guarded = ['id'];

    protected $table = 'serials_sell';

    public function product()
    {
        return $this->belongsTo('App\Models\Products\Product', 'product_id', 'id');
    }

    public function order_detail_purchase()
    {
        return $this->belongsTo('App\Models\Orders\Order_detail', 'order_detail_id', 'id');
    }
}
