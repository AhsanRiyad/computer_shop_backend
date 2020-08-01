<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTo('App\Models\Clients\Client', 'client_id' , 'id');
    }

	public function order()
    {
        return $this->belongsTo('App\Models\Orders\Order', 'order_id', 'id');
    }    

    public function refund()
    {
        return $this->belongsTo('App\Models\Transactions\Refund', 'refund_id', 'id');
    }

}
