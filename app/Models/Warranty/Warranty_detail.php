<?php

namespace App\Models\Warranty;

use Illuminate\Database\Eloquent\Model;

class Warranty_detail extends Model
{
    //
	protected $guarded = ['id'];

    public function warranty()
    {
        return $this->belongsTo('App\Models\Warranty\Warranty', 'warranty_id', 'id');
    }

	public function product()
    {
        return $this->belongsTo('App\Models\Products\Product', 'product_id', 'id');
    }

    public function serial_numbers()
    {
        return $this->hasMany('App\Models\Products\Subcategory', 'warranty_detail_id');
    }



}
