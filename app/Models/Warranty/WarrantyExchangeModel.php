<?php

namespace App\Models\Warranty;

use Illuminate\Database\Eloquent\Model;

class WarrantyExchangeModel extends Model
{
    //
    protected $guarded = ['id'];

    public function warranty()
    {
        return $this->belongsTo('App\Models\Warranties\Warranty', 'warranty_id', 'id');
    }

    public function warranty_exchange_detail()
    {
        return $this->hasMany('App\Models\Warranties\Warranty_exchange_detail', 'warranty_exchange_id');
    }
}
