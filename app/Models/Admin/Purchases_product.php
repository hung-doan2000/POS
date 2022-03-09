<?php

namespace App\Models\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchases_product extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'money',
        'quantity',
        'product_id',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public static function insertData($data)
    {
        $old_purchase = DB::table('purchases')->where('purchase_id', '=', $data['purchase_id'])->first();
        $value = DB::table('purchases_products')->where([
            ['purchase_id', '=', $data['purchase_id']],
            ['product_id', '=', $data['product_id']]
        ])->get();
        if ($old_purchase and ($value->count() == 0)) {
            $id = $old_purchase->id;
            $purchase = Purchase::find($id);
            $purchase->money = $purchase->money + $data['money'];

            DB::table('purchases_products')->insert($data);
            $purchase->save();
            return true;
        }
        return false;
    }
}
