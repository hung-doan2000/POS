<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Customer extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'google_id',
        'address',
        'total_money'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',

    ];

     public function carts(){
        return $this->hasMany(Cart::class,'customer_id','id');
    }

    public function orders(){
        return $this->hasMany(Order::class,'customer_id','id');
    }

    public function customer_group(){
        return $this->belongsTo(CustomerGroup::class,'group_id','id');
    }

}
