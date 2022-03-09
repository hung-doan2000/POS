<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'purchase_id',
        'money',
        'place_order',
        'stock_id',
        'status'
    ];

    public function stock(){
        //return $this->belongsTo();
    }

    public function purchases_product(){
        return $this->hasMany(Purchases_product::class,'purchase_id','purchase_id');
    }

    public function payment(){
        return $this->hasOne(Purchases_payment::class,'purchase_id','purchase_id');
    }
}
