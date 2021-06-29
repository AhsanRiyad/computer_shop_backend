<?php

namespace App\Models\Microcredit\TransactionMicrocredit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TransactionMicrocredit extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Microcredit\Members\Member', 'member_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employees\Employee', 'employee_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo('App\Models\Banks\Bank', 'bank_id', 'id');
    }
}
