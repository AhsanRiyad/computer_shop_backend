<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded = ['id'];

    public function address()
    {
        return $this->hasOne('App\Models\Addresses\Address', 'order_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Clients\Client', 'client_id');
    }

    public function warranty()
    {
        return $this->hasMany('App\Models\Warranty\Warranty', 'client_id');
    }


    public function order_detail()
    {
        return $this->hasMany('App\Models\Orders\Order_detail', 'client_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transaction', 'client_id');
    }
	
    public function order_return()
    {
        return $this->hasMany('App\Models\Orders\Order_return', 'client_id');
    }

}
