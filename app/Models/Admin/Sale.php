<?php

namespace App\Models\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'month',
        'year',
        'sold_quantity',
        'money',
        'store',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
