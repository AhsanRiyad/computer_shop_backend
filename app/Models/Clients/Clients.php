<?php

namespace App\Models\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    //
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->hasMany('App\Models\Orders\Orders', 'client_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transactions', 'client_id');
    }
}
