<?php

namespace App\Models\Branches;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Products\Product');
    }

    public function brands()
    {
        return $this->belongsToMany('App\Models\Brands\Brand');
    }

    public function banks()
    {
        return $this->belongsToMany('App\Models\Banks\Bank' , 'branch_bank');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Categories\Category');
    }

    public function incomes()
    {
        return $this->belongsToMany('App\Models\Incomes\Income');
    }

    public function expenses()
    {
        return $this->belongsToMany('App\Models\Expenses\Expense');
    }

    public function units()
    {
        return $this->belongsToMany('App\Models\Units\Unit');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Orders\Order' , 'branch_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions\Transaction' , 'branch_id');
    }

    public function dps()
    {
        return $this->hasMany('App\Models\Microcredit\Dps\Dps' , 'branch_id');
    }

    public function loans()
    {
        return $this->hasMany('App\Models\Microcredit\Loans\Loan' , 'branch_id');
    }

    public function FixedDeposit()
    {
        return $this->hasMany('App\Models\Microcredit\FixedDeposit\FixedDeposit' , 'branch_id');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Models\Clients\Client');
    }

    public function members()
    {
        return $this->belongsToMany('App\Models\Microcredit\Members\Member');
    }
}
