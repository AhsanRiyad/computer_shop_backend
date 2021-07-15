<?php

namespace App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;
    //
    protected $guarded = ['id'];

    protected $casts = [ 'client_id' => 'integer', ];

    public function address()
    {
        return $this->hasOne('App\Models\Addresses\Address', 'order_id');
    }

    public function branch()
    {
        return $this->belongsToMany('App\Models\Branches\Branch','branch_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
    
    public function updated_by()
    {
        return $this->belongsTo('App\User', 'updated_by', 'id');
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
        return $this->hasMany('App\Models\Orders\Order_detail', 'order_id')->with(['products' , 'serial_numbers_purchase', 'serial_numbers_sell']);
    }

    public function serial_numbers()
    {
        /*return $this->hasManyThrough('App\Models\Products\Serial_number', 'App\Models\Orders\Order_detail')->with(['product']);*/

        return $this->hasManyThrough('App\Models\Products\Serial_number', 'App\Models\Orders\Order_detail');
    }

    public function serial_numbers_purchase()
    {
        /*return $this->hasManyThrough('App\Models\Products\Serial_number', 'App\Models\Orders\Order_detail')->with(['product']);*/

        return $this->hasManyThrough('App\Models\Products\Serial_purchase', 'App\Models\Orders\Order_detail', 'order_id' , 'order_detail_id', 'id' , 'id');
    }

    public function serial_numbers_sell()
    {
        /*return $this->hasManyThrough('App\Models\Products\Serial_number', 'App\Models\Orders\Order_detail')->with(['product']);*/

        return $this->hasManyThrough('App\Models\Products\Serial_sell', 'App\Models\Orders\Order_detail', 'order_id' , 'order_detail_id', 'id' , 'id');
    }

    public function products()
    {
        return $this->hasManyThrough('App\Models\Products\Product', 'App\Models\Orders\Order_detail');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transaction', 'order_id')->with(['client']);
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

    public function discounts()
    {
        // return  $this->coupon->istk ? $this->coupon->tk . ' AED' : $this->coupon->percentage. " %"  ;
        return  ( ($this->getSubTotal() *  $this->discount) /100 ) ;
    }

    public function getTotal()
    {
        /* return $this->getDiscount() == "" ? $this->getSubTotal() : $this->coupon->istk ? $this->getSubTotal() - $this->coupon->tk : ""; */

        return round( ( $this->getSubTotal() - ($this->getSubTotal() * $this->discount ) / 100) , 2 );
    }

    public function paid()
    {
        /* return $this->getDiscount() == "" ? $this->getSubTotal() : $this->coupon->istk ? $this->getSubTotal() - $this->coupon->tk : ""; */
        return ( $this->transactions->where('is_debit', '=', true)->sum(DB::raw( 'tk' )) );
    }

    public function received()
    {
        /* return $this->getDiscount() == "" ? $this->getSubTotal() : $this->coupon->istk ? $this->getSubTotal() - $this->coupon->tk : ""; */

        return ( $this->transactions->where('is_debit', '=', false)->sum(DB::raw( 'tk' )) );
    }

    public function balance()
    {
        /* return $this->getDiscount() == "" ? $this->getSubTotal() : $this->coupon->istk ? $this->getSubTotal() - $this->coupon->tk : ""; */

        return  round( (   $this->getTotal() -  ( $this->paid() - $this->received() )  ) , 2 );
        // $t =  (double) $this->getTotal();
    
        // return $t;
    }


    public function balance_sell()
    {
        /* return $this->getDiscount() == "" ? $this->getSubTotal() : $this->coupon->istk ? $this->getSubTotal() - $this->coupon->tk : ""; */
        return  round( (   $this->getTotal() -  ( $this->received() - $this->paid() )  ) , 2 );
        // $t =  (double) $this->getTotal();
    
        // return $t;
    }

    public function daily_sales(){
        return $this->where('date' , '11')->get();
    }
}
