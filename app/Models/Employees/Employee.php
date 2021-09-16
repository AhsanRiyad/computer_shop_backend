<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];
    
    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo('App\User', 'shop_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branches\Branch', 'branch_id', 'id');
    }

}
