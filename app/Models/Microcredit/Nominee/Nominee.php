<?php

namespace App\Models\Microcredit\Nominee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Nominee extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "nominee";

    public function dps()
    {
        return $this->hasMany('App\Models\Microcredit\Dps\Dps', 'nominee_id');
    }

    public function members()
    {
        return $this->hasMany('App\Models\Microcredit\Members\Member', 'nominee_id');
    }

    public function fixedDeposit()
    {
        return $this->hasMany('App\Models\Microcredit\FixedDeposit\FixedDeposit', 'nominee_id');
    }
}
