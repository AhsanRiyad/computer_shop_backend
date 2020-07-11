<?php

namespace App\Models\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    //
    public function order()
    {
        return $this->belongsTo('App\Models\Orders\Orders', 'order_id' , 'id');
    }

    public function products()
    {
        return $this->belongsTo('App\Models\Products\Products', 'proudct_id' , 'id');
    }

}
