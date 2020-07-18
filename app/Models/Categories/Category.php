<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = ['id'];
    
    public function porducts()
    {
        return $this->hasMany('App\Models\Products\Product', 'category_id');
    }
}
