<?php

namespace App\Models\Microcredit\Dps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dps extends Model
{
    //
    use SoftDeletes;

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
        return $this->morphOne('App\Models\Microcredit\Nominee\Nominee', 'nomineeable');
    }
    
    public function collect()
    {
        return $this->belongsTo('App\Models\Microcredit\Employees\Employee', 'collect_id', 'id');
    }
}
