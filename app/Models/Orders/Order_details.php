<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    protected $guarded = ['id'];
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
