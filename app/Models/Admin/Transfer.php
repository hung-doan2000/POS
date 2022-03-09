<?php

namespace App\Models\Admin;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'store_send',
        'store_take',
        'status'
    ];
    public function store_send(){
        return $this->belongsTo(Store::class,'id','store_send');
    }
    public function store_take(){
        return $this->belongsTo(Store::class,'id','store_take');
    }

}
