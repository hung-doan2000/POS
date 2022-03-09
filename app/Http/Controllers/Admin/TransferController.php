<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Purchase;
use App\Models\Admin\Transfer;
use App\Models\Admin\Transfer_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    public function list()
    {
        $transfers = DB::table('transfers')->where('status', '=', 0)
            ->orderBy('id', 'DESC')->simplePaginate();
        $stores = DB::table('stores')->get();
        return view(
            'admin.transfers.list',
            [
                'title' => 'Danh sách đơn chuyển hàng chưa hoàn thành'
            ],
            compact('transfers', 'stores')
        );
    }

    public function complete_transfers()
    {
        $transfers = DB::table('transfers')->where('status', '=', 1)
            ->orderBy('id', 'DESC')->simplePaginate();
        $stores = DB::table('stores')->get();
        return view(
            'admin.transfers.complete_transfers',
            [
                'title' => 'Danh sách đơn chuyển hàng chưa hoàn thành'
            ],
            compact('transfers', 'stores')
        );
    }

    public function add_transfer(Request $request)
    {
        $request->validate(
            [
            'title' => "required|max:120|unique:transfers,title,{{$request->title}}",
            'store_send' => "required|int|min:1",
            'store_take' => "required|int|min:1",
            ]
        );
        $data =  $request->except('_token');
        $data = array_filter($data, 'strlen');
        if ($data['store_send'] == $data['store_take']) {
            return redirect(route('admin.transfers.list'))
                ->with('error', __('Store_take must not like Store_send!'));
        } else {
            Transfer::create($data);
            return redirect(route('admin.transfers.list'))
                ->with('success', __('Create transfer successfull!'));
        };
        // return redirect(route('admin.transfers.list'))
        //     ->with('error', __('Create transfer\'s fail!'));
    }

    public function edit_transfer($id)
    {
        $transfer = Transfer::find($id);
        $store_send = DB::table('stores')->where('id', $transfer->store_send)->first();
        $stores = DB::table('stores')->get();
        return view(
            'admin.transfers.edit_transfer',
            [
                'title' => 'Sửa thông tin đơn chuyển hàng'
            ],
            compact('transfer', 'stores', 'store_send')
        );
    }

    public function update_transfer(Request $request, $id)
    {
        $request->validate(
            [
            'title' => "required|max:120|unique:transfers,title,$id",
            'store_send' => "required|int|min:1",
            'store_take' => "required|int|min:1",
            ]
        );
        if ($request->store_send == $request->store_take) {
            return redirect()->back()->with('error', __('Store_take must not like Store_send!'));
        };
        $transfer = Transfer::find($id);
        if ($transfer) {
            $transfer->description = $request->input('description');
            $transfer->title = $request->input('title');
            $transfer->store_send = $request->input('store_send');
            $transfer->store_take = $request->input('store_take');
            $transfer->save();
        }
        return redirect(route('admin.transfers.list'))
            ->with('success', __('Update transfer\'s success!'));
    }

    public function detail($transfer_id)
    {
        $products = DB::table('transfer_products')
            ->where('transfer_id', '=', $transfer_id)
            ->orderBy('id', 'DESC')
            ->simplePaginate();
        $title = 'Chi tiết đơn hàng ' . $transfer_id;
        return view(
            'admin.transfers.detail_transfer',
            ['title' => $title],
            compact('products', 'transfer_id')
        );
    }

    public function add_product(Request $request)
    {
        $request->validate(
            [
            'transfer_id' => "required|int|min:1",
            'product_id' => "required|int|min:1",
            'quantity' => "required|int|min:1",
            ]
        );
        $data =  $request->except('_token');
        $data = array_filter($data, 'strlen');
        if ($this->check_product($data)) {
            $transfer = Transfer::find($data['transfer_id']);
            $product_store = DB::table('warehouses')
                ->where(
                    [
                    ['store_id', '=', $transfer->store_send],
                    ['product_id', '=', $data['product_id']]
                    ]
                )->first();
            $new_quantity = $product_store->quantity - $data['quantity'];
            DB::table('warehouses')
                ->where(
                    [
                    ['store_id', '=', $transfer->store_send],
                    ['product_id', '=', $data['product_id']]
                    ]
                )->update(['quantity' => $new_quantity]);
            Transfer_product::create($data);
            return redirect(route('admin.transfers.detail', $data['transfer_id']))
                ->with('success', __('Thêm sản phẩm thành công!'));
        };
        return redirect(route('admin.transfers.detail', $data['transfer_id']))
            ->with('error', __('Thêm sản phẩm thất bại do nhà kho gửi không đủ số lượng hoặc đã tồn tại sản phẩm!'));
    }
    public function check_product($data)
    {
        $product_transfer = DB::table('transfer_products')->where(
            [
            ['transfer_id', $data['transfer_id']],
            ['product_id', $data['product_id']],
            ]
        )->first();
        if ($product_transfer) { return false;
        }
        $transfer = Transfer::find($data['transfer_id']);
        $product = DB::table('warehouses')
            ->where(
                [
                ['store_id', '=', $transfer->store_send],
                ['product_id', '=', $data['product_id']]
                ]
            )->first();
        if ($product and ($product->quantity >= $data['quantity'])) { return true;
        }
        return false;
    }

    public function delete_product(Request $request)
    {
        $product = Transfer_product::find($request->id);
        $transfer = Transfer::find($product->transfer_id);
        if ($product) {
            DB::beginTransaction();
            try {
                $product_store = DB::table('warehouses')->where(
                    [
                    ['store_id', '=', $transfer->store_send],
                    ['product_id', '=', $product->product_id]
                    ]
                )->first();
                $new_quantity = $product_store->quantity + $product->quantity;
                DB::table('warehouses')
                    ->where(
                        [
                        ['store_id', '=', $transfer->store_send],
                        ['product_id', '=', $product->product_id]
                        ]
                    )->update(['quantity' => $new_quantity]);
                $product->delete();
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error($e->getMessage(), [$e->getTraceAsString()]);
                return redirect(route('admin.transfers.detail', $product->transfer_id))
                    ->with('error', __('Product delete has errors!'));
            }
            DB::commit();
            return redirect(route('admin.transfers.detail', $product->transfer_id))
                ->with('success', __('Delete product\'s success!'));
        }
    }

    public function delete_transfer(Request $request)
    {
        $transfer = Transfer::find($request->id);
        if ($transfer) {
            DB::beginTransaction();
            try {
                $products_transfer = DB::table('transfer_products')->where('transfer_id', '=', $request->id)->get();
                foreach ($products_transfer as $product_transfer) {
                    $product_store = DB::table('warehouses')->where(
                        [
                        ['store_id', '=', $transfer->store_send],
                        ['product_id', '=', $product_transfer->product_id]
                        ]
                    )->first();
                    $new_quantity = $product_store->quantity + $product_transfer->quantity;
                    DB::table('warehouses')
                        ->where(
                            [
                            ['store_id', '=', $transfer->store_send],
                            ['product_id', '=', $product_transfer->product_id]
                            ]
                        )->update(['quantity' => $new_quantity]);
                }
                DB::table('transfer_products')->where('transfer_id', '=', $request->id)->delete();
                $transfer->delete();
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error($e->getMessage(), [$e->getTraceAsString()]);
                return redirect(route('admin.transfers.list'))
                    ->with('error', __('Transfer delete has errors!'));
            }
            DB::commit();
            return redirect(route('admin.transfers.list'))
                ->with('success', __('Delete transfer\'s success!'));
        }
    }

    public function orders_list()
    {
        $store_id = Auth::user()->store_id;
        $transfers = DB::table('transfers')
            ->where(
                [
                ['store_take', $store_id],
                ['status', 0]
                ]
            )
            ->orderBy('id', 'DESC')->simplePaginate();
        $purchases = DB::table('purchases')
            ->where(
                [
                ['stock_id', $store_id],
                ['status', 0]
                ]
            )
            ->orderBy('id', 'DESC')->simplePaginate();
        return view(
            'admin.transfers.orders_list',
            [
                'title' => 'Danh sách đơn hàng cần nhận nhà kho ' . $store_id
            ],
            compact('transfers', 'purchases')
        );
    }

    public function take_order(Request $request)
    {
        $trans_id = $request->trans_id;
        $pur_id = $request->pur_id;
        if ($trans_id != 0) {
            $transfer = Transfer::find($trans_id);
            if ($transfer) {
                DB::beginTransaction();
                try {
                    $products_transfer = DB::table('transfer_products')->where('transfer_id', $trans_id)->get();
                    foreach ($products_transfer as $product_transfer) {
                        $product_store = DB::table('warehouses')->where(
                            [
                            ['store_id', '=', $transfer->store_take],
                            ['product_id', '=', $product_transfer->product_id]
                            ]
                        )->first();
                        if ($product_store) {
                            $new_quantity = $product_store->quantity + $product_transfer->quantity;
                            DB::table('warehouses')
                                ->where(
                                    [
                                    ['store_id', '=', $transfer->store_take],
                                    ['product_id', '=', $product_transfer->product_id]
                                    ]
                                )->update(['quantity' => $new_quantity]);
                        } else {
                            DB::table('warehouses')->insert(
                                [
                                'store_id' => $transfer->store_take,
                                'product_id' => $product_transfer->product_id,
                                'quantity' => $product_transfer->quantity
                                ]
                            );
                        }
                    }
                    DB::table('transfers')
                        ->where('id', $trans_id)
                        ->update(['status' => 1]);
                } catch (\Throwable $e) {
                    DB::rollBack();
                    Log::error($e->getMessage(), [$e->getTraceAsString()]);
                    return redirect(route('admin.transfers.orders_list'))
                        ->with('error', __('Xác nhận hàng thất bại !'));
                }
                DB::commit();
                return redirect(route('admin.transfers.orders_list'))
                    ->with('success', __('Xác nhận hàng thành công!'));
            }
        } else if ($pur_id != 0) {
            $purchase = Purchase::find($pur_id);
            if ($purchase) {
                DB::beginTransaction();
                try {
                    $products_purchase = DB::table('purchases_products')->where('purchase_id', $purchase->purchase_id)->get();
                    foreach ($products_purchase as $product_purchase) {
                        $product_store = DB::table('warehouses')->where(
                            [
                            ['store_id', '=', $purchase->stock_id],
                            ['product_id', '=', $product_purchase->product_id]
                            ]
                        )->first();
                        if ($product_store) {
                            $new_quantity = $product_store->quantity + $product_purchase->quantity;
                            DB::table('warehouses')
                                ->where(
                                    [
                                    ['store_id', '=', $purchase->stock_id],
                                    ['product_id', '=', $product_purchase->product_id]
                                    ]
                                )->update(['quantity' => $new_quantity]);
                        } else {
                            DB::table('warehouses')->insert(
                                [
                                'store_id' => $purchase->stock_id,
                                'product_id' => $product_purchase->product_id,
                                'quantity' => $product_purchase->quantity
                                ]
                            );
                        }
                    }
                    DB::table('purchases')
                        ->where('id', $pur_id)
                        ->update(['status' => 1]);
                } catch (\Throwable $e) {
                    DB::rollBack();
                    Log::error($e->getMessage(), [$e->getTraceAsString()]);
                    return redirect(route('admin.transfers.orders_list'))
                        ->with('error', __('Xác nhận hàng thất bại !'));
                }
                DB::commit();
                return redirect(route('admin.transfers.orders_list'))
                    ->with('success', __('Xác nhận hàng thành công!'));
            }
        }
    }

    public function uploadFile(Request $request)
    {
        if ($request->file('file') == null) { return redirect(route('admin.transfers.list'))->with('error', __('You need add file .csv!'));
        }
        if ($request->input('submit') != null) {
            $file = $request->file('file');

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Valid File Extensions
            $valid_extension = array("csv");
            if (in_array(strtolower($extension), $valid_extension)) {
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
                    if (($importData_arr[0][0] != "transfer_id") or ($importData_arr[0][1] != "product_id")
                        or ($importData_arr[0][2] != "quantity") or (count($importData_arr[0]) != 3)
                    ) {
                        $check_data = false;
                        break;
                    }
                    $validator = Validator::make(
                        $importData_arr[$c], [
                        '0' => 'required|int|min:1',
                        '1' => 'required|int|min:1',
                        '2' => 'required|int|between:1,1000000',
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
                if ($check_data) {
                    for ($c = 1; $c < $num; $c++) {
                        $insertData = array(
                            "transfer_id" => $importData_arr[$c][0],
                            "product_id" => $importData_arr[$c][1],
                            "quantity" => $importData_arr[$c][2],
                        );
                        $check_insert = Transfer_product::insertData($insertData)==false? false:$check_insert;
                    }
                    if (!$check_insert) {
                        return redirect(route('admin.transfers.list'))->with('success', __('Some data was not added due to already existing or wrong transfer_id  !'));
                    }
                    return redirect(route('admin.transfers.list'))->with('success', __('Import Data\'s success!'));
                }
                return redirect(route('admin.transfers.list'))->with('error', __('The file has error data!'));
            }
            return redirect(route('admin.transfers.list'))->with('error', __('The file is not file .csv!'));
        }
    }

    public function detail_transfer_order($transfer_id)
    {
        $products = DB::table('transfer_products')
            ->where('transfer_id', '=', $transfer_id)
            ->orderBy('id', 'DESC')
            ->simplePaginate();
        $title = 'Chi tiết đơn hàng ' . $transfer_id;
        return view(
            'admin.transfers.detail_order',
            ['title' => $title],
            compact('products', 'transfer_id')
        );
    }

    public function detail_purchase_order($purchase_id)
    {
        $products = DB::table('purchases_products')
            ->where('purchase_id', '=', $purchase_id)
            ->orderBy('id', 'DESC')
            ->simplePaginate();
        //$title = $purchase->title;
        $title = 'Chi tiết đơn hàng ';
        return view(
            'admin.transfers.detail_purchase',
            ['title' => $title],
            compact('products')
        );
    }

}
