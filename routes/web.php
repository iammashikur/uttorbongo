<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Backend\ShopController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SaleController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\BuyerController;
use App\Http\Controllers\Backend\SellerController;
use App\Http\Controllers\Backend\BranchController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\SupplierReturnController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\PosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {

        Route::get('point-of-sale', function(){
            return view('backend.pos.index');
        })->name('pos');

        Route::post('pos-search', [PosController::class, 'search'])->name('pos-search');
        Route::post('pos-checkout', [PosController::class, 'checkout'])->name('checkout');
        Route::post('get-customer', [PosController::class, 'customer'])->name('customer');


        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('products', ProductController::class);
        Route::resource('product-categories', ProductCategoryController::class);
        Route::resource('sellers', SellerController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('supplier-returns', SupplierReturnController::class);
        Route::resource('shops', ShopController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('users', UserController::class);
        Route::resource('sales', SaleController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('buyers', BuyerController::class);
        Route::resource('dues', DueController::class);
    });
