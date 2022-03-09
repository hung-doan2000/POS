<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'import_price',
        'description',
        'brand_id',
        'color',
        'created_by',
        'product_code',
        'barcode',
        'category_id',
        'photo',
        'active',
    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id')
            ->withDefault(['name'=>'abc']);
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function brand(){
       return $this->belongsTo(Brand::class,'brand_id');
    }

}

