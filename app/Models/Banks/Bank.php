<?php

namespace App\Models\Banks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Bank extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function branch()
    {
        return $this->belongsToMany('App\Models\Branches\Branch' , 'branch_bank');
    }
}
