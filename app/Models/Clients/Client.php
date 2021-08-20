<?php

namespace App\Models\Clients;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $guarded = ['id'];
    public function orders()
    {
        return $this->hasMany('App\Models\Orders\Order', 'client_id');
    }

    public function transaction()
    {
        return $this->morphMany('App\Models\Transactions\Transaction', 'transactionable');
    }


    public function branch()
    {
        return $this->belongsToMany('App\Models\Branches\Branch');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transaction', 'client_id');
    }

    public function debit()
    {
        return $this->transactions()->where('is_debit' , true)->sum(DB::raw('amount'));
    }

    public function credit()
    {
        return $this->transactions()->where('is_debit' , false)->sum(DB::raw('amount'));
    }

    //seller starts
    public function debitSeller()
    {
        // return $this->orders->sum('total');
        $total = 0;
        foreach ($this->orders as $value) {
            $total += $value->getTotal();
        };
        return round( $total , 2 );
    }
    public function creditSeller()
    {
        return $this->transactions()->where('is_debit' , false)->sum(DB::raw('amount'));
    }
    //seller ends

    //customer starts
    public function debitCustomer()
    {
        // return $this->orders->sum('total');
        $total = 0;
        foreach ($this->orders as $value) {
            $total += $value->getTotal();
        };
        return round($total, 2);
    }
    public function creditCustomer()
    {
        return $this->transactions()->where('is_debit' , true)->sum(DB::raw('amount'));
    }
    //customer ends

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

}
