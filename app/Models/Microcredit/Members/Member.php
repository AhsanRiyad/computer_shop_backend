<?php

namespace App\Models\Microcredit\Members;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];

    public function transactionMicrocredit()
    {
        return $this->hasMany('App\Models\Microcredit\TransactionMicrocredit', 'member_id');
    }

    public function dps()
    {
        return $this->hasMany('App\Models\Microcredit\Dps\Dps', 'member_id');
    }

    public function loans()
    {
        return $this->hasMany('App\Models\Microcredit\FixedDeposit\FixedDeposit', 'member_id');
    }

    public function fixedDeposit()
    {
        return $this->hasMany('App\Models\Microcredit\Loans\Loan', 'member_id');
    }

}
