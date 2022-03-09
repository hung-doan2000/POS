<?php


namespace App\Http\Services;


use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutService
{
    public function getProduct()
    {
        $carts = Session::get('carts');
        if (is_null($carts)) return [];
        $productId = array_keys($carts);
        return Product::select('id', 'name', 'price', 'photo')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }

    public function checkout($request)
    {

        try {
            DB::beginTransaction();

            $carts = Session::get('carts');

            if (is_null($carts))
                return false;
            if (!Auth::user()) {
                $data = [
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'email' => $request->input('email'),
                ];
                $customer = Customer::create($data);
            }else {
                $customer = Auth::user();
            }
            $this->Cartinfo($carts, $customer->id);
            DB::commit();
            Session::flash('success', 'Đặt hàng thành công');
            Session::forget('carts');
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    protected function Cartinfo($carts, $customer_id)
    {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'photo')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'quantity' => $carts[$product->id],
                'price' => $product->price,
            ];
        }
        return Cart::insert($data);
    }
}
