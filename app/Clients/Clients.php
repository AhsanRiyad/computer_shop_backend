<?php

namespace App\Clients;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    //
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->hasMany('App\Orders\Orders', 'client_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transactions\Transactions', 'client_id');
    }
}
