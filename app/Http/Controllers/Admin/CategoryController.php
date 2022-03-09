<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Services\Category\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function destroy(Request $request)
    {
        $result = $this->categoryService->destroy($request);
        if ($result) {
            return response()->json(
                [
                    'error' => false,
                    'message' => 'Xóa thành công danh mục'
                ]
            );
        }
        return response()->json(
            [
                'error' => true
            ]
        );
    }

    public function listCate()
    {
        return Category::all();
    }

    // public function addCate(CategoryRequest $request)
    // {
    //     $category = $this->categoryService->store($request);
    //     return $category;
    // }

    public function addCate(Request $request)
    {
        $category = new Category();
        //return $request;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->tax = $request->tax;
        $category->unit = $request->unit;
        $path = $this->_upload($request);
        if ($path) {
            $category->photo = $path;
        }
        $category->save();
        return $category;
        //return response()->json('successfully added');
    }

    public function editCate(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->tax = $request->tax;
        $category->unit = $request->unit;
        $path = $this->_upload($request);
        if ($path) {
            $category->photo = $path;
        }
        $category->save();
        return $category;
    }

    public function deleteCate($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json('successfully deleted');
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
}
