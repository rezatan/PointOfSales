<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseDetailsController;
use App\Http\Controllers\ReportController;

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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['middleware' => 'level:1'], function () {
        Route::resource('/category', CategoryController::class);

        Route::post('/product/delete-selected', [ProductController::class, 'deleteSelected'])->name('product.delete_selected');
        Route::post('/product/print-barcode', [ProductController::class, 'printBarcode'])->name('product.print_barcode');
        Route::resource('/product', ProductController::class);
        
        Route::resource('/stock', StockController::class);
        Route::post('/stock/delete-selected', [StockController::class, 'deleteSelected'])->name('stock.delete_selected');

        Route::resource('/supplier', SupplierController::class);
        Route::resource('/expense', ExpenseController::class);

        Route::get('/purchase/{id}/create', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::resource('/purchase', PurchaseController::class)->except('create');

        Route::get('/pembelian_detail/{id}/data', [PurchaseDetailsController::class, 'data'])->name('purchase_detail.data');
        Route::get('/purchase_detail/loadform/{diskon}/{total}', [PurchaseDetailsController::class, 'loadForm'])->name('purchase_detail.load_form');
        Route::resource('/purchase_detail', PurchaseDetailsController::class)->except('create', 'show', 'edit');
        
        Route::resource('/shop', ShopController::class);

        Route::resource('/users', UserController::class);

        Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak_member');
        Route::resource('/member', MemberController::class);

        Route::get('/sale/data', [SaleController::class, 'data'])->name('penjualan.data');
        Route::get('/sale', [SaleController::class, 'index'])->name('penjualan.index');
        Route::get('/sale/{id}', [SaleController::class, 'show'])->name('penjualan.show');
        Route::delete('/sale/{id}', [SaleController::class, 'destroy'])->name('penjualan.destroy');

        Route::get('/report', [ReportController::class, 'index'])->name('laporan.index');
        Route::get('/report/data/{awal}/{akhir}', [ReportController::class, 'data'])->name('laporan.data');
        Route::get('/report/pdf/{awal}/{akhir}', [ReportController::class, 'exportPDF'])->name('laporan.export_pdf');
    });
    Route::group(['middleware' => 'level:1,2'], function () {
        Route::get('/cashier/new', [SaleController::class, 'create'])->name('transaksi.baru');
        Route::post('/cashier/save', [SaleController::class, 'store'])->name('transaksi.simpan');
        Route::get('/cashier/done', [SaleController::class, 'selesai'])->name('transaksi.selesai');
        Route::get('/cashier/nota-small', [SaleController::class, 'notaKecil'])->name('transaksi.nota_kecil');
        Route::get('/cashier/nota-big', [SaleController::class, 'notaBesar'])->name('transaksi.nota_besar');

        Route::get('/cashier/{id}/data', [CashierController::class, 'data'])->name('transaksi.data');
        Route::get('/cashier/loadform/{diskon}/{total}/{diterima}', [CashierController::class, 'loadForm'])->name('transaksi.load_form');
        Route::resource('/cashier', CashierController::class)
            ->except('create', 'show', 'edit');   
        
        Route::get('/profile', [UserController::class, 'profile']);
        Route::post('/profile', [UserController::class, 'updateProfile'])->name('user.update_profile');
        
        Route::get('/shopdetail', [ShopController::class, 'detail']);

    });
});