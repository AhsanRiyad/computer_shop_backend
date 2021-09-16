<?php

namespace App\Models\Brands;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function branch()
    {
        return $this->belongsToMany('App\Models\Branches\Branch');
    }

    public function porducts()
    {
        return $this->hasMany('App\Models\Products\Product', 'brand_id');
    }
}
