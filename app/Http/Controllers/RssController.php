<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RssController extends Controller
{
    public function index(){
        $feedscategories = DB::table('categories')
            ->whereNotNull('categories.fb_cate_id')->orwhereNotNULl('categories.gg_cate_id')
            ->get();
        $categories = Category::orderByDESC('id')->get();
        return view('rss',[
            'title'=>'Rss',
            'feedscategories'=>$feedscategories,
        ]);
    }
}
