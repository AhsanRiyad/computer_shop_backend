<?php

namespace App\Products;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    // either fillable or guarded can stay
    // protected $fillable = ['name', 'price'];

    protected $guarded = ['id'];
    //
    public function brand()
    {
        return $this->belongsTo('App\Products\Brands', 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Products\Categories', 'category_id', 'id');
    }

    public function order_details()
    {
        return $this->hasMany('App\Orders\Order_details', 'product_id');
    }

    public function serials()
    {
        return $this->hasMany('App\Products\Serials', 'product_id');
    }
}
