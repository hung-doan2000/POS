<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'order_id',
        'quatity',
    ];

    public function warehouse(){
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function getProduct(){
        return $this->belongsTo(Warehouse::class,'warehouse_id')->with(['product']);
    }
}
