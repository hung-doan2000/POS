<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.changepassword',['title'=>'Chỉnh sửa thông tin người dùng']);
    }
    public function edit(){
        $user = Auth::user();
        return view('admin.users.edit',[
            'title'=>'Chỉnh sửa thông tin người dùng',
            'user'=>$user,
        ]);
    }

    public function update(UserRequest $userRequest){
        $user = Auth::user();
        try {
            $user->name = $userRequest->name;
            $user->email = $userRequest->email;
            $user->phone = $userRequest->phone;
            $user->birthday = $userRequest->birthday;
            $user->photo = $userRequest->photo;

            $user->save();
            Session::flash('success','Cập nhật thành công');
        }catch (\Exception $err){
            Session::flash('error','Có lỗi vui lòng thử lại');
            \Log::info($err->getMessage());
        }
        return redirect(route('admin.users.edit'));
    }

    // public function changePassword(Request $request)
    // {
    //     $request->validate([
    //       'current_password' => 'required',
    //       'password' => 'required|string|min:6|confirmed',
    //       'password_confirmation' => 'required|same:password',
    //     ]);

    //     $user = Auth::user();

    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return back();
    //     }

    //     $user->password = Hash::make($request->password);
    //     $user->save();
    //     return redirect('login')->with('success', 'Mật khẩu đã bị thay đổi. Vui lòng đăng nhập lại!');
    // }

    public function getUserLogin()
    {
        return Auth::user();
    }

    public function getList()
    {
        return User::with(['store','roles'])->get();
    }

    public function getInfo($id){
        $user = User::with(['store','roles'])->find($id);
        $total_money = 0;
        
        $orders = Order::where('user_id','=',$id)->with(['orderDetails'])->get(); 
        $num_products = 0;
        foreach($orders as $order){
            $total_money += $order->price;
            //$num_products += $order->countProducts();
            $order_details = $order->orderDetails;
            foreach($order_details as $order_detail){
                $num_products += $order_detail->quantity;
            }
        }
        return [$user,$total_money,$num_products,$orders];
    }

    public function editInfo(Request $request,$id){
        $request->validate([
            'name' => "required|max:120",
            'email' => 'required',
            'phone' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $path = $this->_upload($request);
        if ($path) {
            $user->photo = $path;
        }
        $user->save();
        return $user;
    }

    public function editUser(Request $request,$id){
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->store_id = $request->store_id;
        $user->birthday = $request->birthday;
        $user->roles()->detach();
        $user->roles()->attach($request->role_id);
        $path = $this->_upload($request);
        if ($path) {
            $user->photo = $path;
        }
        $user->save();
        return $user;
    }
    public function createUser(Request $request){
        $request->validate([
            'name' => "required|max:120",
            'email' => 'required',
            'phone' => 'required',
        ]);
        //return $request;
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->store_id = $request->store_id;
        $user->birthday = $request->birthday;
        $user->password = Hash::make("password");
        
        $path = $this->_upload($request);
        if ($path) {
            $user->photo = $path;
        }
        $user->save();
        $user->roles()->attach($request->role_id);
        return $user;
    }

    public function changePassword(Request $request,$id)
    {
        $request->validate([
          'current_password' => 'required',
          'password' => 'required|string|min:6|confirmed',
          'password_confirmation' => 'required|same:password',
        ]);

        $user = User::find($id);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['The password does not match.']]],422);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json('success');
    }


    private function _upload($request)
    {
        if ($request->file()) {
            try {
                $name = $request->file('photo')->getClientOriginalName();
                $pathFull = 'uploads/' . date("Y/m/d");
                $request->file('photo')->storeAs(
                    'public/' . $pathFull,
                    $name
                );
                return '/storage/' . $pathFull . '/' . $name;
            } catch (\Exception $error) {
                return false;
            }
            
        }
        return false;
    }

    public function getRoles(){
        return Role::get();
    }
}
