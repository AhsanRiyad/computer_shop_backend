<?php

namespace App\Products;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //

    // protected $table = 'categories';
    protected $fillable = ['name', 'details'];

    public function products()
    {
        return $this->hasMany('App\Products\Products', 'category_id');
    }
}
