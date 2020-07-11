<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    //

    protected $fillable = ['name', 'details'];

    public function products()
    {
        return $this->hasMany('App\Models\Products\Products', 'brand_id');
    }
}
