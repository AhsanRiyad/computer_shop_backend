<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Transactions extends Model
{

    protected $guarded = ['id'];

    /* const created_by = 1;
    const updated_by = true; */

    /* protected $attributes = [
        'created_by' => self::created_by,
    ]; */

   /*  protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (request()->isMethod('post')) {
                $model->created_by =  request()->header('employeeId');
            } else if (request()->isMethod('put')) {
                $model->updated_by =  request()->header('employeeId');
            }

            // $model->generateKeys();
            // $model->generateConfirmationCode();
        });
    } */

    //
    public function client()
    {
        return $this->belongsTo('App\Models\Clients\Clients', 'client_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Orders\Orders', 'order_id', 'id');
    }
}
