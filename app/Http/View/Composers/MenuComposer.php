<?php


namespace App\Http\View\Composers;


use App\Models\Category;
use Illuminate\View\View;

class MenuComposer
{
    protected $menu;
    public function __construct()
    {
    }
    public function compose(View $view){
        $categories = Category::select('id','name','parent_id')->orderByDesc('id')->get();
        $view->with('categories',$categories);
    }
}
