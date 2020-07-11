<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Serials extends Model
{
    //
    public function product()
    {
        return $this->belongsTo('App\Models\Products\Products', 'product_id', 'id');
    }

    public function purchase()
    {
        return $this->belongsTo('App\Models\Order\Orders', 'order_id_p', 'id');
    }

    public function sell()
    {
        return $this->belongsTo('App\Models\Order\Orders', 'order_id_s', 'id');
    }
}
