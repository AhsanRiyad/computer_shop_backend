<?php

namespace App\Models\Brands;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $guarded = ['id'];
    public function porducts()
    {
        return $this->hasMany('App\Models\Products\Product', 'category_id');
    }
}
