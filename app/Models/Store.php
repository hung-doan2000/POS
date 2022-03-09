<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'address',
      'phone'
    ];

    public function warehouses(){
      return $this->hasMany(Warehouse::class,'store_id')->with('product');
    }
}
