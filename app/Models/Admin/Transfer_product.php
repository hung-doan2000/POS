<?php

namespace App\Models\Admin;

use App\Http\Controllers\Admin\TransferController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transfer_product extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        'product_id',
        'quantity'
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'id', 'transfer_id');
    }

    public static function insertData($data)
    {
        $check_data = new Transfer_product();
        if ($check_data->check_product($data)) {
            $transfer = Transfer::find($data['transfer_id']);
            $product_store = DB::table('warehouses')
                ->where([
                    ['store_id', '=', $transfer->store_send],
                    ['product_id', '=', $data['product_id']]
                ])->first();
            $new_quantity = $product_store->quantity - $data['quantity'];
            DB::table('warehouses')
                ->where([
                    ['store_id', '=', $transfer->store_send],
                    ['product_id', '=', $data['product_id']]
                ])->update(['quantity' => $new_quantity]);
            DB::table('transfer_products')->insert($data);
            return true;
        }
        return false;
    }

    public function check_product($data)
    {
        $product_transfer = DB::table('transfer_products')->where([
            ['transfer_id',$data['transfer_id']],
            ['product_id',$data['product_id']],
        ])->first();
        if($product_transfer) return false;
        $transfer = Transfer::find($data['transfer_id']);
        if ($transfer and $transfer->status==0) {
            $product = DB::table('warehouses')
                ->where([
                    ['store_id', '=', $transfer->store_send],
                    ['product_id', '=', $data['product_id']]
                ])->first();
            if ($product and ($product->quantity >= $data['quantity'])) return true;
            return false;
        };
        return false;
    }
}
