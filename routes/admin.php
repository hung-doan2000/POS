<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\FeedController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\WarehouseController;

Route::get('',
    [LoginController::class, 'login']
    )->name('admin.login');
Route::post('admin/login',
    [LoginController::class, 'authenticate']
    )->name('admin.login.authenticate');
Route::get('admin/logout',
    [LoginController::class,'logout'])
    ->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/vue/{any}', function () {
        return view('admin.admin');
      })->where('any', '.*');

    Route::get('get-sale',[DashboardController::class, 'getSale']);
    Route::get('get-monthyear',[DashboardController::class, 'getMonthYear']);
    Route::post('get-productmonth',[DashboardController::class, 'getProductMonth']);
    Route::post('get-productyear',[DashboardController::class, 'getProductYear']);

    Route::prefix('categories')->name('categories.')->group(function (){
        Route::get('/list',[CategoryController::class,'listCate']);
        Route::post('/add-cate',[CategoryController::class,'addCate'])->middleware('role:Manager');
        Route::post('/edit-cate/{id}',[CategoryController::class,'editCate'])->middleware('role:Manager');
        Route::delete('/delete-cate/{id}', [CategoryController::class, 'deleteCate']);

    });

    Route::prefix('products')->name('products.')->group(function (){
        Route::get('/list',[ProductController::class,'listProd']);
        Route::post('/add-product',[ProductController::class,'addProd'])->middleware('role:Manager');
        Route::delete('delete-prod/{id}', [ProductController::class, 'deleteProduct'])->middleware('role:Manager');;
        Route::get('/info/{id}',[ProductController::class,'getInfo']);
        Route::post('/edit-product/{id}',[ProductController::class,'editProd'])->middleware('role:Manager');
        
    });
    
    Route::prefix('brands')->name('brands.')->group(function (){
     
        Route::get('list',[BrandController::class,'listBrand']);
    });
    Route::prefix('stores')->name('stores.')->group(function (){
        Route::get('/list',[StoreController::class,'getList']);
       
    });

    Route::prefix('warehouses')->name('warehouses.')->group(function (){
     
        Route::get('/get-products',[WarehouseController::class,'getProducts']);
    });


    Route::prefix('users')->name('users.')->group(function (){
        Route::post('/change-password/{id}',[UserController::class,'changePassword']);
        Route::get('/get-user-login',[UserController::class,'getUserLogin']);
        Route::get('/list',[UserController::class,'getList']);
        Route::get('/roles',[UserController::class,'getRoles']);
        Route::get('/info/{id}',[UserController::class,'getInfo']);
        Route::post('/edit-info/{id}',[UserController::class,'editInfo']);
        Route::post('/edit-user/{id}',[UserController::class,'editUser'])->middleware('role:Admin');;
        Route::post('/create-user',[UserController::class,'createUser'])->middleware('role:Admin');;
    });

    Route::prefix('feeds')->name('feeds.')->group(function (){
        Route::get('/index',[FeedController::class,'index'])->name('index');
        Route::get('/create',[FeedController::class,'create'])->name('create');
        Route::post('/create',[FeedController::class,'store'])->name('store');

    });


    Route::prefix('orders')->name('orders.')->group(function (){
        Route::get('/index', [OrderController::class, 'indexPos']);
        Route::get('/cate', [OrderController::class, 'cate']);
        Route::get('/cart', [OrderController::class, 'getCart']);
        Route::get('add-to-cart-pos/{id}', [OrderController::class, 'addToCartPos']);
        Route::get('minus-cart/{id}', [OrderController::class, 'minusCart']);
        Route::get('remove-cart/{id}', [OrderController::class, 'removeCart']);
        Route::delete('cancel-cart', [OrderController::class, 'cancelCart']);
        Route::get('charge-cart/{id}', [OrderController::class, 'chargeCart']);
        Route::get('/select-cate/{id}', [OrderController::class, 'selectCate']);
        Route::get('print', [OrderController::class, 'print'])->name('print');
    });
    Route::prefix('purchases')->name('purchases.')->group(function (){
        Route::post('/new-purchase',[PurchaseController::class,'createPurchase']);
        Route::post('/add-product/{id}',[PurchaseController::class,'addProduct']);
        Route::post('/add-file',[PurchaseController::class,'addFile']);
        Route::get('/list',[PurchaseController::class,'getList']);
        Route::post('/purchase-payment',[PurchaseController::class,'purchasePayment']);
        Route::get('/details/{id}',[PurchaseController::class,'getDetail']);

    });

    Route::prefix('transfers')->name('transfers.')->group(function (){
        Route::get('/list',[TransferController::class,'list'])->name('list');
        Route::get('/compelete_transfers',[TransferController::class,'complete_transfers'])->name('complete_transfers');
        Route::post('/add_transfer',[TransferController::class,'add_transfer'])->name('add_transfer');
        Route::get('/edit_transfer/{id}',[TransferController::class,'edit_transfer'])->name('edit_transfer');
        Route::post('/edit_transfer/{id}',[TransferController::class,'update_transfer'])->name('update_transfer');

        Route::get('/detail/{id}',[TransferController::class,'detail'])->name('detail');
        Route::post('/add_product',[TransferController::class,'add_product'])->name('add_product');
        Route::delete('/delete_product',[TransferController::class,'delete_product'])->name('delete_product');
        Route::delete('/delete_transfer',[TransferController::class,'delete_transfer'])->name('delete_transfer');

        Route::get('/orders_list',[TransferController::class,'orders_list'])->name('orders_list');
        Route::get('/detail_transfer_order/{id}',[TransferController::class,'detail_transfer_order'])->name('detail_transfer_order');
        Route::get('/detail_purchase_order/{id}',[TransferController::class,'detail_purchase_order'])->name('detail_purchase_order');
        Route::post('/take_order',[TransferController::class,'take_order'])->name('take_order');

        Route::post('/uploadFile',[TransferController::class,'uploadFile'])->name('uploadFile');
    });

    Route::prefix('feeds')->name('feeds.')->group(function (){
        Route::get('/upfile',[FeedController::class,'upfileView'])->name('upfileView');
        Route::post('/upFbcode',[FeedController::class,'upFbcode'])->name('upFbcode');
        Route::post('/upGgcode',[FeedController::class,'upGgcode'])->name('upGgcode');
    });

    Route::prefix('customers')->name('customers.')->group(function (){
        Route::get('/index',[CustomerController::class,'index'])->name('index');
        Route::post('/store',[CustomerController::class,'create'])->name('store');
        Route::get('/list',[CustomerController::class,'getList']);
        Route::get('/info/{id}',[CustomerController::class,'getInfo']);
        Route::get('/order-list/{id}',[CustomerController::class,'getOrderList']);
        Route::get('/group',[CustomerController::class,'getCustomerGroup']);
        Route::post('/group-edit/{id}',[CustomerController::class,'editCustomerGroup']);
    });

    Route::prefix('suppliers')->name('suppliers.')->group(function (){
        Route::get('/list',[SupplierController::class,'getList']);

    });
    
});
