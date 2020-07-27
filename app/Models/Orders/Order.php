<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Order extends Model
{
    //
    protected $guarded = ['id'];

    public function address()
    {
        return $this->hasOne('App\Models\Addresses\Address', 'order_id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }


    public function client()
    {
        return $this->belongsTo('App\Models\Clients\Client', 'client_id' , 'id');
    }

    public function warranty()
    {
        return $this->hasMany('App\Models\Warranties\Warranty', 'order_id');
    }


    public function order_details()
    {
        return $this->hasMany('App\Models\Orders\Order_detail', 'order_id')->with(['products' , 'serial_numbers']);
    }

    public function serial_numbers()
    {
        /*return $this->hasManyThrough('App\Models\Products\Serial_number', 'App\Models\Orders\Order_detail')->with(['product']);*/

        return $this->hasManyThrough('App\Models\Products\Serial_number', 'App\Models\Orders\Order_detail');
    }

    public function products()
    {
        return $this->hasManyThrough('App\Models\Products\Product', 'App\Models\Orders\Order_detail');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transaction', 'order_id');
    }
	
    public function order_return()
    {
        return $this->hasMany('App\Models\Orders\Order_return', 'order_id');
    }


    public function getSubTotal()
    {
        return $this->order_details()->sum(DB::raw('quantity * price'));
    }


    public function getDiscount()
    {
        // return  $this->coupon->istk ? $this->coupon->tk . ' AED' : $this->coupon->percentage. " %"  ;
        return  $this->discount . " %";
    }

    public function getTotal()
    {
        /* return $this->getDiscount() == "" ? $this->getSubTotal() : $this->coupon->istk ? $this->getSubTotal() - $this->coupon->tk : ""; */

        return ( $this->getSubTotal() - ($this->getSubTotal() * $this->discount ) / 100);
    }



}
