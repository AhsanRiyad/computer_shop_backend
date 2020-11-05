<?php



namespace App\Models\Orders;



use Illuminate\Database\Eloquent\Model;



class Order_detail extends Model

{

    //

    protected $guarded = ['id'];



    protected $casts = [ 'quantity' => 'integer', 'price' => 'double' , ];



    public function order()

    {

        return $this->belongsTo('App\Models\Orders\Order', 'order_id', 'id');

    }



    public function created_by()

    {

        return $this->belongsTo('App\User', 'created_by', 'id');

    }



    public function products()

    {

        return $this->belongsTo('App\Models\Products\Product', 'product_id', 'id');

    }

    

    public function serial_numbers()

    {

        return $this->hasMany('App\Models\Products\Serial_number', 'order_detail_id');

    }



    public function serial_numbers_purchase()

    {

        return $this->hasMany('App\Models\Products\Serial_purchase', 'order_detail_id');

    }




    public function serial_numbers_sell()

    {

        return $this->hasMany('App\Models\Products\Serial_sell', 'order_detail_id');

    }


    public function subtotal()

    {

        return $this->price * $this.quantity;

    }



}

