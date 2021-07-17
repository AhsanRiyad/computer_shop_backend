<?php

namespace App\Models\Warranty;

use Illuminate\Database\Eloquent\Model;

class WarrantyModel extends Model
{
    //
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders\Order', 'order_id', 'id');
    }

    public function warranty_exchange()
    {
        return $this->hasMany('App\Models\Warranties\Warranty_exchange', 'warranty_exchange_id');
    }

    public function warranty_detail()
    {
        return $this->hasMany('App\Models\Warranties\Warranty_detail', 'warranty_detail_id');
    }
    
}
