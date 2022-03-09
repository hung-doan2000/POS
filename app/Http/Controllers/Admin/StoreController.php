<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    

    public function getList()
    {
        return Store::all();
    }
}
