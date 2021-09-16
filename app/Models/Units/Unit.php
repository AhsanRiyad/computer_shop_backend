<?php

namespace App\Models\Units;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    //
    use SoftDeletes;
    protected $table = "units";
    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function branch()
    {
        return $this->belongsToMany('App\Models\Branches\Branch');
    }

    public function porducts()
    {
        return $this->hasMany('App\Models\Products\Product', 'category_id');
    }
}
