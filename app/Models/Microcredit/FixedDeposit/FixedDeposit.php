<?php

namespace App\Models\Microcredit\FixedDeposit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixedDeposit extends Model
{
    //
    use SoftDeletes;

    protected $table = "fixed_deposit";
    protected $guarded = ['id'];
    protected $casts = ['member_id' => 'integer'];
    
    public function transactionMicrocredit()
    {
        return $this->morphMany('App\Models\Microcredit\TransactionMicrocredit\TransactionMicrocredit', 'transactionable');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Microcredit\Members\Member', 'member_id', 'id');
    }

    public function nominee()
    {
        return $this->belongsTo('App\Models\Microcredit\Nominee\Nominee', 'nominee_id', 'id');
    }

    public function collector()
    {
        return $this->belongsTo('App\Models\Employees\Employee', 'collector_id', 'id')->with(['user']);
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branches\Branch', 'branch_id', 'id');
    }
}
