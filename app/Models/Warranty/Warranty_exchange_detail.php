<?php

namespace App\Models\Warranty;

use Illuminate\Database\Eloquent\Model;

class Warranty_exchange_detail extends Model
{
    //
    protected $guarded = ['id'];


    public function warranty_exchange()
    {
        return $this->belongsTo('App\Models\Warranty\Warranty_exchange', 'warranty_exchange_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products\Product', 'product_id', 'id');
    }

    public function serial_numbers()
    {
        return $this->hasMany('App\Models\Products\Serial_number', 'warranty_exchange_detail_id');
    }
}
