<?php

namespace App\Orders;

use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    //
    public function order()
    {
        return $this->belongsTo('App\Orders\Orders', 'order_id' , 'id');
    }

    public function products()
    {
        return $this->belongsTo('App\Products\Products', 'proudct_id' , 'id');
    }

}
