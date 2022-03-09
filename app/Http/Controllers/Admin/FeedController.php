<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Product;

class FeedController extends Controller
{
    public function index()
    {
        return view(
            'admin.feeds.index', [
            'title' => 'Feeds Product',
            ]
        );
    }

    public function create()
    {
        $fbcategories = DB::table('fb_feeds')->get();
        $ggcategories = DB::table('gg_feeds')->get();
        $categories = DB::table('categories')->get();
        $feedscategories = DB::table('categories')
            ->leftjoin('fb_feeds', 'fb_feeds.fb_cate_id', '=', 'categories.fb_cate_id')
            ->leftjoin('gg_feeds', 'gg_feeds.gg_cate_id', '=', 'categories.gg_cate_id')
            ->whereNotNull('categories.fb_cate_id')->orwhereNotNULl('categories.gg_cate_id')
            ->get();

        return view(
            'admin.feeds.create', [
            'title'=>'Feeds Product',
            'fbcategories'=>$fbcategories,
            'ggcategories'=>$ggcategories,
            'categories'=>$categories,
            'feedscategories'=> $feedscategories,
            ]
        );
    }

    public function store(Request $request)
    {
        if(!$request->category_id) { return redirect()->back()->with('error', 'Chua chon category_id');
        }
        $category = Category::where('id', $request -> category_id)->first();
        if($request->fb_cate_id) { $category->fb_cate_id = $request -> fb_cate_id;
        }
        if($request->gg_cate_id) { $category->gg_cate_id = $request -> gg_cate_id;
        }
            $category -> save();
        return redirect(route('admin.feeds.create'));
    }

    public function upfileView()
    {
        return view(
            'admin.feeds.upfileView',
            [
                'title' => 'Up file Google Feeds and Facebook Feeds '
            ],
        );
    }

    public function upFbcode(Request $request)
    {
        if ($request->file('fileFb') == null) { return redirect(route('admin.feeds.upfileView'))->with('error', __('You need add file .csv!'));
        }

        if ($request->input('submit') != null) {
            $file = $request->file('fileFb');

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Valid File Extensions
            $valid_extension = array("csv");
            if (in_array(strtolower($extension), $valid_extension)) {
                // File upload location
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
                    $validator = Validator::make(
                        $importData_arr[$c], [
                        '0' => 'required|int|min:1',
                        '1' => 'required'
                        ]
                    );
                    if ($validator->fails()) {
                        $check_data = false;
                    }
                    if ($check_data == false) {
                        break;
                    }
                }
                if ($check_data) {
                    for ($c = 1; $c < $num; $c++) {

                        $insertData = array(
                            "fb_cate_id" => $importData_arr[$c][0],
                            "fb_category" => $importData_arr[$c][1],
                        );
                        $this->insertFb($insertData);
                    }
                    return redirect(route('admin.feeds.upfileView'))
                        ->with('success', __('Import Facebook Category ID success  !'));
                }
                return redirect(route('admin.feeds.upfileView'))
                    ->with('error', __('Import Facebook Category ID has errors  !'));
            }
            return redirect(route('admin.feeds.upfileView'))
                ->with('error', __('You need add file .csv !'));
        }
    }
    public function insertFb($data)
    {
        $value = DB::table('fb_feeds')->where('fb_cate_id', $data['fb_cate_id'])->get();
        if ($value->count() == 0) {
            DB::table('fb_feeds')->insert($data);
        }
    }
    public function upGgcode(Request $request)
    {
        if ($request->file('fileGg') == null) { return redirect(route('admin.feeds.upfileView'))->with('error', __('You need add file .csv!'));
        }
        if ($request->input('submit') != null) {
            $file = $request->file('fileGg');

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Valid File Extensions
            $valid_extension = array("csv");
            if (in_array(strtolower($extension), $valid_extension)) {
                // File upload location
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
                    $validator = Validator::make(
                        $importData_arr[$c], [
                        '0' => 'required',
                        '1' => 'required'
                        ]
                    );
                    if ($validator->fails()) {
                        $check_data = false;
                    }
                    if ($check_data == false) {
                        break;
                    }
                }
                if ($check_data) {
                    for ($c = 0; $c < $num; $c++) {
                        $gg_category = $importData_arr[$c][1];
                        for ($i = 2; $i < 8; $i++) {
                            if ($importData_arr[$c][$i]) {
                                $gg_category = $gg_category . " > " . $importData_arr[$c][$i];
                            }
                        }
                        $insertData = array(
                            "gg_cate_id" => $importData_arr[$c][0],
                            "gg_category" => $gg_category,
                        );
                        $this->insertGg($insertData);
                    }
                    return redirect(route('admin.feeds.upfileView'))
                        ->with('success', __('Import Google Category ID success  !'));
                }
                return redirect(route('admin.feeds.upfileView'))
                    ->with('error', __('Import Google Category ID has errors  !'));
            }
            return redirect(route('admin.feeds.upfileView'))
                ->with('error', __('You need add file .csv !'));
        }
    }

    public function insertGg($data)
    {
        $value = DB::table('gg_feeds')->where('gg_cate_id', $data['gg_cate_id'])->get();
        if ($value->count() == 0) {
            DB::table('gg_feeds')->insert($data);
        }
    }

    public function fbFeed($id)
    {
        if ($id) {
            $category = DB::table('categories')->where('id', $id)->first();
            $products = Product::with('brand')
                ->where('category_id', $id)->get();
            $cateFB = DB::table('fb_feeds')->where('fb_cate_id', $category->fb_cate_id)->first();
            return response()->view(
                'admin.feeds.map-fb',
                [
                    'products' => $products,
                    'category' => $category,
                    'cate_fb' => $cateFB,
                ]
            )->header('Content-Type', 'text/xml');
        }
    }


    public function ggFeed($id)
    {
        if ($id) {
            $category = DB::table('categories')->where('id', $id)->first();
            $products = Product::with('brand')
                ->where('category_id', $id)->get();
            $cateGG = DB::table('gg_feeds')->where('gg_cate_id', $category->gg_cate_id)->first();
            return response()->view(
                'admin.feeds.map-gg',
                [
                    'products' => $products,
                    'category' => $category,
                    'cate_gg' => $cateGG,
                ]
            )->header('Content-Type', 'text/xml');
        }
    }
}
