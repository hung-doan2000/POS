<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases_payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'paid',
        'bill_code',
        'trade_code',
    ];
    public function purchase(){
        return $this->belongsTo(Purchase::class,'purchase_id','purchase_id');
    }
}
