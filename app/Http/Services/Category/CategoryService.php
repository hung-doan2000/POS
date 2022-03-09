<?php


namespace App\Http\Services\Category;


use App\Models\Category;
use Illuminate\Support\Facades\Session;

class CategoryService
{
    public function getById($id){
        return Category::find($id);
    }

    public function getParent(){
        return Category::where('parent_id',0)->get();
    }

    public function store($request){
        try {
            $request->except('_token');
            $category = Category::create($request->all());
            Session::flash('success','Thêm danh mục mới thành công');
        }catch (\Exception $err){
            Session::flash('error','Thêm danh mục mới lỗi');
            \Log::info($err->getMessage());
            return false;
        }
        return $category;
    }

    public function getAll(){
        return Category::orderByDesc('id')->get();
    }

    public function update($categoryRequest,$category){
        try {
            $category->fill($categoryRequest->input());
            $category->save();
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
        $category = Category::where('id',$id)->first();
        if ($category){
            return Category::where('id',$id)->orWhere('parent_id',$id)->delete();
        }
        return false;
    }
}
