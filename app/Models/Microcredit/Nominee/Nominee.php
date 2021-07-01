<?php

namespace App\Models\Microcredit\Nominee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Nominee extends Model
{
    //
    
    use SoftDeletes;
    protected $guarded = ['id'];

    public function dps()
    {
        return $this->hasMany('App\Models\Microcredit\Dps\Dps', 'nominee_id');
    }

    public function fixedDeposit()
    {
        return $this->hasMany('App\Models\Microcredit\FixedDeposit\FixedDeposit', 'nominee_id');
    }
}
