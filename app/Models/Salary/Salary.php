<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    //
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    


}
