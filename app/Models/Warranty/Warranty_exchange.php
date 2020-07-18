<?php

namespace App\Models\Warranty;

use Illuminate\Database\Eloquent\Model;

class Warranty_exchange extends Model
{
    //
    protected $guarded = ['id'];

    public function warranty()
    {
        return $this->belongsTo('App\Models\Warranty\Warranty', 'warranty_id', 'id');
    }

    public function warranty_exchange_detail()
    {
        return $this->hasMany('App\Models\Warranty\Warranty_exchange_detail', 'warranty_exchange_id');
    }

    


}
