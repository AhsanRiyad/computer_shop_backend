<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
    public function branches()
    {
        return $this->hasMany('App\Models\Branches\Branch', 'shop_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
