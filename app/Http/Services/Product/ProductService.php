<?php


namespace App\Http\Services\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function get(){
        return Product::with('category','createdBy')
            ->orderBy('id')->get();
            // ->paginate(9);
    }

    public function store($request){
        try {
            $request->except('_token');
            Product::create($request->all());
            Session::flash('success','Thêm sản phẩm mới thành công');
        }catch (\Exception $err){
            Session::flash('error','Thêm sản phẩm mới lỗi');
            \Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function getById($id){
        return Product::find($id);
    }

    public function update($productRequest,$product){
        try {
            $product->fill($productRequest->input());
            $product->save();
            Session::flash('success','Cập nhật thành công');
        }catch (\Exception $err){
            Session::flash('error','Có lỗi vui lòng thử lại');
            \Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request){
        $id = (integer)$request->input('id');
        $category = Product::where('id',$id)->first();
        if ($category){
            return Product::where('id',$id)->delete();
        }
        return false;
    }
}
