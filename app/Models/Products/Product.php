<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo('App\Models\Categories\Category', 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brands\Brand', 'brand_id', 'id');
    }

    public function order_detail()
    {
        return $this->hasMany('App\Models\Orders\Order_detail', 'product_id');
    }

    public function serial_numbers()
    {
        return $this->hasMany('App\Models\Products\Serial_number', 'product_id');
    }

    public function warranty_exchange_detail()
    {
        return $this->hasMany('App\Models\Warranties\Warranty_exchange_detail', 'product_id');
    }

    public function warranty_detail()
    {
        return $this->hasMany('App\Models\Warranties\Warranty_detail', 'product_id');
    }

}
