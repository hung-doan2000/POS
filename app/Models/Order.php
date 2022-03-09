<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'price',
        'user_id',
        'discount',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->with(['store']);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class,'order_id','id')->with(['getProduct']);
    }

    public function countProducts(){
        $order_details = $this->hasMany(OrderDetail::class);
        $sum = 0;
        // foreach($order_details as $order_detail){
        //     $sum += $order_detail->quantity;
        // }
        return $order_details[0];
    }

}
