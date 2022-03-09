<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    public function guard()
    {
        return Auth::guard('admin');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function authenticate(LoginRequest $request){
        $credentials = $request->except('_token');
        $user = DB::table('users')->where('email',$request -> email) -> first();

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin/vue/dashboard');
        }else{
            return back()->withErrors([
                'email' => 'Tài khoản hoặc mật khẩu không đúng. ',
            ]);
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }
}
