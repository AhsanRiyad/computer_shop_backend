<?php

namespace App;

use App\Http\Resources\Role\Role;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable , HasApiTokens ,  HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Orders\Order', 'user_id');
    }

    public function employees()
    {
        return $this->hasMany('App\Models\Employees\Employee', 'user_id');
    }

    public function shop()
    {
        return $this->hasOne('App\Models\Shop\Shop', 'user_id');
    }

    public function salary()
    {
        return $this->hasMany('App\Models\Salary\Salary', 'user_id');
    }

    public function branches()
    {
        return $this->hasMany('App\Models\Branches\Branch', 'shop_id');
    }

    

}
