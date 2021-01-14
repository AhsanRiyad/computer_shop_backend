<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    //
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transactions\Transaction', 'transaction_id', 'id');
    }
}
