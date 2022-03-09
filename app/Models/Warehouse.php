<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'product_id',
        'quantity',
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function store(){
        return $this->belongsTo(Store::class,'store_id');
    }

    public function inOrder(){
        return $this->belongsTo(OrderDetail::class,'warehose_id');
    }
}
