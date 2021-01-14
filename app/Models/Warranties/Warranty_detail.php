<?php

namespace App\Models\Warranties;

use Illuminate\Database\Eloquent\Model;

class Warranty_detail extends Model
{
    //
	protected $guarded = ['id'];

    public function warranty()
    {
        return $this->belongsTo('App\Models\Warranties\Warranty', 'warranty_id', 'id');
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
