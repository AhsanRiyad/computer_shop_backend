<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders\Order', 'order_id', 'id');
    }
}
