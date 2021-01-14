<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->hasMany('App\Models\Orders\Order', 'client_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transaction', 'client_id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

}
