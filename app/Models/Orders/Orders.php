<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $guarded = ['id'];
    //
    public function order_details()
    {
        return $this->hasMany('App\Models\Orders\Order_details', 'order_id');
    }

    public function serials_p()
    {
        return $this->hasMany('App\Models\Products\Serials', 'order_id_p');
    }

    public function serials_s()
    {
        return $this->hasMany('App\Models\Products\Serials', 'order_id_s');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transactions', 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Orders\Order_details')->withPivot('product_id');
    }
}
