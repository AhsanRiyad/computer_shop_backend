<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    //
    protected $guarded = ['id'];
    protected $casts = [ "having_serial" => 'boolean', 'brand_id' => 'integer' , 'category_id' => 'integer' ];

    public function category()
    {
        return $this->belongsTo('App\Models\Categories\Category', 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brands\Brand', 'brand_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
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


    public function purchased()
    {
        // return $this->order_detail->sum(DB::raw( 'quantity' ));

        $orders = [];

        foreach ( $this->order_detail as $order) {
            # code...
            $order['type'] = $order->order->type; 
            $orders[] = $order;
        }

        return collect($orders)->where('type' , 'purchase')->sum( DB::raw('quantity') );
    }

    public function sold()
    {
        $orders = [];

        foreach ( $this->order_detail as $order) {
            # code...
            $order['type'] = $order->order->type; 
            $orders[] = $order;
    }

        return collect($orders)->where('type' , 'sell')->sum( DB::raw('quantity') );
    }


    public function inStock()
    {
        

        return $this->purchased() - $this->sold();
    }

}
