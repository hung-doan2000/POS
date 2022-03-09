<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Controller;
use App\Models\Admin\Sale;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function print()
    {
        return view('admin.orders.order-print');
    }

    public function indexPos()
    {
        $user = Auth::user();
        $store = Store::where('id', $user->store_id)->first();
        //$stocks = DB::table('warehouses')->where('store_id','=',$store->id)->get();
        $stocks = DB::table('warehouses')
            ->join('products', 'products.id', '=', 'warehouses.product_id')
            ->where('store_id', $user->store_id)
            ->get();

        return $stocks;
    }
    public function cate()
    {
        $categories = DB::table('categories')
            ->get();

        return $categories;
    }
    public function selectCate($id)
    {
        $stocks = $this->indexPos()
            ->where('category_id', $id);

        return $stocks;
    }

    public function getCart()
    {
        return session()->get('cart', []);
    }

    public function addToCartPos($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);
        $check = 0;
        $count = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                if ($item["product_id"] == $id) {
                    $check = 1;
                    break;
                }
                $count++;
            }
        }
        if ($check == 0) {
            $cart[$count] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "photo" => $product->image
            ];
        } else {
            $cart[$count]['quantity']++;
        }
        session()->put('cart', $cart);
        return response()->json($cart);
    }

    public function minusCart($id)
    {
        $cart = session()->get('cart', []);
        $count = 0;
        foreach ($cart as $item) {
            if ($item["product_id"] == $id) {
                break;
            }
            $count++;
        }
        $cart[$count]['quantity']--;
        if ($cart[$count]['quantity'] == 0) {
            array_splice($cart, $count, 1);
        }
        session()->put('cart', $cart);
        return response()->json($cart);
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart');
        $count = 0;
        foreach ($cart as $item) {
            if ($item["product_id"] == $id) {
                break;
            }
            $count++;
        }
        array_splice($cart, $count, 1);
        session()->put('cart', $cart);
        return response()->json($cart);
    }

    public function cancelCart()
    {
        session()->forget('cart');
        return response()->json('Success cancel');
    }

    public function chargeCart($id)
    {
        $user = Auth::user();
        $carts = session()->get('cart');
        $order = new Order();
        $order->customer_id = $id;
        $order->user_id = $user->id;
        $order->save();
        $warehouses = [];
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart['quantity'] * $cart['price'];
            $warehouse = Warehouse::where('product_id', $cart['product_id'])
                ->where('store_id', $user->store_id)->with(['product'])->first();
            $warehouse->quantity = $warehouse->quantity - $cart['quantity'];
            if ($warehouse->quantity < 10) {
                array_push($warehouses, $warehouse);
            }
            $warehouse->save();
            $orderDetail = new OrderDetail();
            $orderDetail->warehouse_id = $warehouse->id;
            $orderDetail->quantity =  $cart['quantity'];
            $orderDetail->order_id = $order->id;
            $orderDetail->save();
        }
        if (count($warehouses) > 0) {
            $t1 = $this->sendMail($warehouses);
        }
        $customer = Customer::find($id);
        $discount = $customer->customer_group->discount;
        $order->discount = $discount;
        $order->price = $total - $total * $discount / 100;
        $order->save();
        $customerController = new CustomerController;
        $customerController->addMoney($id, $total);
        session()->forget('cart');
        return response()->json("Success charge");
    }

    public function sendMail($warehouses)
    {
        $user_mail = User::find(1);
        if (Mail::send('email.productNofitication', ['warehouses' => $warehouses], function ($message) use ($user_mail) {
            $message->to($user_mail->email);
            $message->subject('Out of stock Nofitication');
        })) return 1;
        else return 0;
    }
}
