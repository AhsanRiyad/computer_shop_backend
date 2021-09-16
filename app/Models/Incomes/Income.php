<?php

namespace App\Models\Incomes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;
    //
    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function branch()
    {
        return $this->belongsToMany('App\Models\Branches\Branch');
    }

    public function transaction()
    {
        return $this->morphMany('App\Models\Transactions\Transaction', 'transactionable');
    }
}
