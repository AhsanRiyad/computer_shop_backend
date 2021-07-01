<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
