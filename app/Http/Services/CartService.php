<?php


namespace App\Http\Services;


use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request){
        $qty = (int)$request->input('product-quantity');
        $product_id = (int)$request->input('product_id');

        if ($qty<=0 || $product_id<=0 ){
            Session::flash('error','Số lượng hoặc sản phẩm không hợp lệ');
            return false;
        }
        $carts = Session::get('carts');
        if (is_null($carts)){
            Session::put('carts',[
                $product_id=>$qty
            ]);
            return true;
        }
        $exists = Arr::exists($carts,$product_id);
        if ($exists){
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts',$carts);
            return true;
        }
        $carts[$product_id] = $qty;
        Session::put('carts', $carts);
        return true;
    }

    public function getProduct(){
        $carts = Session::get('carts');
        if (is_null($carts)) return[];
        $productId = array_keys($carts);
        return Product::select('id','name','price','photo')
            ->where('active',1)
            ->whereIn('id',$productId)
            ->get();
    }

    public function update($request){
        Session::put('carts',$request->input('num_product'));
        return true;
    }

    public function delete($id){
        $carts = Session::get('carts');
        unset($carts[$id]);
        Session::put('carts',$carts);
        return true;
    }

    public function getCartList(){
        return Customer::orderByDesc('id')->paginate(15);
    }

    public function destroy($request){
        $id = (integer)$request->input('id');
        $cart = Customer::where('id',$id)->first();
        if ($cart){
            return Customer::where('id',$id)->delete();
        }
        return false;
    }
}
