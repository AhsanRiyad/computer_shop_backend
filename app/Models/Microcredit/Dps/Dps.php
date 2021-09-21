<?php

namespace App\Models\Microcredit\Dps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dps extends Model
{
    //
    use SoftDeletes;
    protected $table = 'dps';
    protected $guarded = ['id'];

    protected $casts = [ 'member_id' => 'integer' ];
    
    public function transactionMicrocredit()
    {
        return $this->morphMany('App\Models\Microcredit\TransactionMicrocredit\TransactionMicrocredit', 'transactionable');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Microcredit\Members\Member', 'member_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function nominee()
    {
        return $this->belongsTo('App\Models\Microcredit\Nominee\Nominee', 'nominee_id' , 'id');
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
