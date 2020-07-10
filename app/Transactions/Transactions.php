<?php

namespace App\Transactions;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    //
    public function client()
    {
        return $this->belongsTo('App\Clients\Clients', 'client_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo('App\Orders\Orders', 'order_id', 'id');
    }
}
