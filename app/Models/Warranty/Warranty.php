<?php

namespace App\Models\Warranty;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    //
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders\Order', 'order_id', 'id');
    }

    public function warranty_exchange()
    {
        return $this->hasMany('App\Models\Warranty\Warranty_exchange', 'warranty_exchange_id');
    }

    public function warranty_detail()
    {
        return $this->hasMany('App\Models\Warranty\Warranty_detail', 'warranty_detail_id');
    }
    
}