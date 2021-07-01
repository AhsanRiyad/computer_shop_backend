<?php

namespace App\Models\Microcredit\Grantors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Grantor extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function loans()
    {
        return $this->hasMany('App\Models\Microcredit\Loans\Loan', 'grantor_id');
    }
}
