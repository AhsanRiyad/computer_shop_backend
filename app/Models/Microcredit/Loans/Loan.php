<?php

namespace App\Models\Microcredit\Loans;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Loan extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];
    public function transactionMicrocredit()
    {
        return $this->morphMany('App\Models\Microcredit\TransactionMicrocredit\TransactionMicrocredit', 'transactionable');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Microcredit\Members\Member', 'member_id', 'id');
    }

    public function grantor()
    {
        return $this->belongsTo('App\Models\Microcredit\Grantors\Grantor', 'grantor_id', 'id');
    }

    public function collector()
    {
        return $this->belongsTo('App\Models\Microcredit\Employees\Employee', 'collect_id', 'id');
    }
}
