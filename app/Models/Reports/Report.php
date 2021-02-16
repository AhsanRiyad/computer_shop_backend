<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;



class Report extends Model
{
    //
    protected $guarded = ['id'];

    protected $table = 'order';

    public function daily_sales()
    {
        // return $this->belongsTo('App\Models\Categories\Category', 'category_id', 'id');
        return $this->hasMany('App\Models\Orders\Order');
        
    }


    public function daily_purchase()
    {
        return $this->belongsTo('App\Models\Categories\Category', 'category_id', 'id');
    }

}
