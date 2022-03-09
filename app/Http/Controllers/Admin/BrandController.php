<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class BrandController extends Controller
{

    public function index()
    {
        $brands = Brand::paginate(10);
        return view(
            'admin.brands.index', [
            'title' => 'Danh sách brand',
            'brands' => $brands
            ]
        );
    }


    public function edit($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            return view(
                'admin.brands.edit', [
                'title' => 'Chỉnh sửa brand',
                'brand' => $brand
                ]
            );
        }
    }


    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $path = $this->_upload($request);
            if ($path) {
                $brand->photo = $path;
            }
            $brand->name = $request->input('name');
            $brand->save();
        }
        return redirect(route('admin.brands.index'))
            ->with('success', __('sửa brand thành công!'));
    }


    public function create()
    {
        $brand = new Brand();
        return view(
            'admin.brands.create', [
            'title' => 'Thêm brand mới',
            'brand' => $brand
            ]
        )->with('success', __('Thêm brand thành công!'));
    }


    public function store(BrandRequest $request)
    {
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        $path = $this->_upload($request);
        if ($path) {
            $data['photo'] = $path;
        }
        $brand = Brand::create($data);


        return redirect(route('admin.brands.index'))
            ->with('success', __('Thêm thành công'));
    }


    public function destroy(Request $request)
    {
        $brand = Brand::find($request->input('brand_id'));
        if ($brand) {
            $brand->delete();
            //Storage::delete($brand->photo);
            return redirect(route('admin.brands.index'))
                ->with('success', __('Xóa thành công!'));
        }
        return redirect(route('admin.brands.index'))
            ->with('error', __('xóa không thành công!'));
    }


    private function _upload($request)
    {
        if ($request->hasFile('photo')) {
            try {
                $name = $request->file('photo')->getClientOriginalName();
                $pathFull = 'uploads/' . date("Y/m/d");
                $request->file('file')->storeAs(
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


    public function storeBrand(Request $request)
    {
        $brand = new Brand(
            [
            'name' => $request->get('name'),
            ]
        );

        $brand->save();

        return response()->json('successfully added');
    }

    public function indexBrand()
    {
        return Brand::orderBy('id', 'asc')->get();
    }

    public function editBrand($id)
    {
        $brand = Brand::find($id);
        return response()->json($brand);
    }

    public function updateBrand($id, Request $request)
    {
        $brand = Brand::find($id);

        $brand->update($request->all());
        $brand->save();

        return response()->json('successfully updated');
    }

    public function deleteBrand($id)
    {
        $brand = Brand::find($id);

        $brand->delete();

        return response()->json('successfully deleted');
    }

    public function listBrand(){
        return Brand::all();
    }
}
