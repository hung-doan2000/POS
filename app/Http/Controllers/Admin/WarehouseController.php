<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Store;

class WarehouseController extends Controller
{
    public function getProducts(){
        $ware_house = Warehouse::select([DB::raw('sum(quantity) as quantity'),'product_id'])->groupByRaw('product_id')->with(['product'])->get();
        $store = Store::with('warehouses')->get();
    
        return [$ware_house,$store];
    }
}
