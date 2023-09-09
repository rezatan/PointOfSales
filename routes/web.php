<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseDetailsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('locale/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'id'])) {
        abort(400);
    }
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale');

Route::get('/login', function (){
    return view('auth.login', [LoginController::class, 'index']);
})->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth')->group(function() {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');
    Route::group(['middleware' => 'level:1'], function () {
        Route::resource('/category', CategoryController::class);

        Route::post('/product/delete-selected', [ProductController::class, 'deleteSelected'])->name('product.delete_selected');
        Route::resource('/product', ProductController::class);
        
        Route::resource('/stock', StockController::class);
        Route::post('/stock/delete-selected', [StockController::class, 'deleteSelected'])->name('stock.delete_selected');
        Route::post('/stock/print-barcode', [StockController::class, 'printBarcode'])->name('stock.print_barcode');

        Route::resource('/supplier', SupplierController::class);
        Route::resource('/expense', ExpenseController::class);

        Route::get('/purchase/{id}/create', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::resource('/purchase', PurchaseController::class)->except('create');

        Route::get('/pembelian_detail/{id}/data', [PurchaseDetailsController::class, 'data'])->name('purchase_detail.data');
        Route::get('/purchase_detail/loadform/{diskon}/{total}', [PurchaseDetailsController::class, 'loadForm'])->name('purchase_detail.load_form');
        Route::resource('/purchase_detail', PurchaseDetailsController::class)->except('create', 'show', 'edit');
        
        Route::resource('/shop', ShopController::class);
        
        Route::resource('/users', UserController::class);
    });
    Route::group(['middleware' => 'level:1,2'], function () {
        Route::get('/profile', [UserController::class, 'profile']);
        Route::post('/profile', [UserController::class, 'updateProfile'])->name('user.update_profile');
    });
});