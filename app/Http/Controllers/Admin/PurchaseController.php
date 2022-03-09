<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PurchaseRequest;
use App\Models\Admin\Purchase;
use App\Models\Admin\Purchases_payment;
use App\Models\Admin\Purchases_product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

class PurchaseController extends Controller
{
   
    public function createPurchase(Request $request){
        $purchase = new Purchase();
        $purchase->stock_id = $request->stock_id;
        $purchase->place_order = $request->place_order;
        $purchase->title = $request->title;
        $purchase->purchase_id = 1234;
        $purchase->save();
        return $purchase;
    }

    public function addProduct(Request $request, $id)
    {
        //return $request;
        $i = 0;
        $total_money = 0;
        while ($request[$i])
        {
            $purchase_product = new Purchases_product();
            $purchase_product->purchase_id = $id;
            $purchase_product->product_id = $request[$i]["id"];
            $purchase_product->quantity = $request[$i]["quantity"];
            $purchase_product->money = $request[$i]["total_money"];
            $purchase_product->save();
            $total_money += $request[$i]["total_money"];
            $i++;
        }
        //return $total_money;
        $purchase = Purchase::find($id);
        $purchase->money = $total_money;
        $purchase->save();

        return response()->json("Success ");
    }

    public function getList()
    {
        return Purchase::all();
    }

    public function purchasePayment(Request $request){
        $purchase = Purchase::find($request->id);
        $purchase->paid = 1;
        $purchase->title = $request->title;
        $purchase->save();
        
        $purchase_products = Purchases_product::where('purchase_id',$purchase->id)->get();
        foreach($purchase_products as $purchase_product){
            $warehouse = Warehouse::where('store_id',$purchase->stock_id)
            ->where('product_id',$purchase_product->product_id)->first();
            $warehouse->quantity += $purchase_product->quantity;
            $warehouse->save();
        }
        return $purchase;
    }

    public function getDetail($id){
        $purchase = Purchase::find($id);
        $purchase_products = Purchases_product::where('purchase_id',$purchase->id)
        ->with(['product'])->get();
        return $purchase_products;
    }

    public function addFile(Request $request){
        $file = $request->file('file');

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Valid File Extensions
            $valid_extension = array("csv");
            if (in_array(strtolower($extension), $valid_extension)) {
                // File upload location
                $location = 'uploads';

                // Upload file
                $file->move($location, $filename);
                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);
                // Reading file
                $file = fopen($filepath, "r");

                $importData_arr = array();
                $i = 0;

                while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                    $num = count($filedata);
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }

                fclose($file);
                $num = count($importData_arr);

                //validate data in file csv
                $check_data = true;
                for ($c = 1; $c < $num; $c++) {
                    // if (($importData_arr[0][0] != "id") or ($importData_arr[0][1] != "name")
                    //     or ($importData_arr[0][2] != "price") or ($importData_arr[0][3] != "quantity")
                    //     or ($importData_arr[0][4] != "total_money") or (count($importData_arr[0]) != 5)
                    // ) {
                    //     $check_data = false;
                    //     break;
                    // }
                    $validator = Validator::make(
                        $importData_arr[$c], [
                        '0' => 'required',
                        '1' => 'required',
                        '2' => 'required',
                        '3' => 'required',
                        '4' => 'required',
                        ]
                    );
                    if ($validator->fails()) {
                        $check_data = false;
                    }
                    if ($check_data == false) {
                        break;
                    }
                }
                // Insert to MySQL database
                $check_insert = true;
                $data=[];
                if ($check_data) {
                    for ($c = 1; $c < $num; $c++) {

                        $insertData = (object)[
                            "id" => $importData_arr[$c][0],
                            "name" => $importData_arr[$c][1],
                            "import_price" => $importData_arr[$c][2],
                            "quantity" => $importData_arr[$c][3],
                            "total_money" => $importData_arr[$c][4]
                        ];
                        array_push($data,$insertData);
                    }
                    
                    return $data;
                }
                return response()->json('fail');
            }
    }
}
