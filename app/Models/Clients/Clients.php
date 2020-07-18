<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    //
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->hasMany('App\Models\Orders\Order', 'client_id');
    }

}
