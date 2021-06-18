<?php

namespace App\Models\Branches;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Products\Product');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Orders\Order');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Clients\Client');
    }
}
