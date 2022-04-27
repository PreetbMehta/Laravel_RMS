<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ViewPurchaseController;
use App\Http\Controllers\EditPurchaseController;
use App\Http\Controllers\ViewPurchaseDetailsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TaxSlabController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\ReturnOrderController;
use App\Http\Controllers\PaybackController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\InvoiceController;

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

Route::get('/',[App\Http\Controllers\HomeController::class, 'index'], function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);

Route::resource('taxSlabMaster', TaxSlabController::class);

Route::resource('products', ProductController::class);

Route::resource('customers', CustomerController::class);

Route::resource('suppliers', SupplierController::class);

Route::get('fetch-supplier',[App\Http\Controllers\SupplierController::class, 'fetchsupplier']);

//purchase routes------------------------------------------------------------------------------
Route::resource('addPurchase',PurchaseController::class);

Route::resource('viewPurchase',ViewPurchaseController::class);

Route::resource('EditPurchase',EditPurchaseController::class);

Route::get('/ViewPurchaseDetails/{id}',[App\Http\Controllers\ViewPurchaseDetailsController::class,'index']);

//sales routes-----------------------------------------------------------------------------------
Route::resource('sales',SalesController::class);

//add new customer while adding sales
Route::post('addNewCustomer',[App\Http\Controllers\SalesController::class,'addNewCust']);

//route for view sales
Route::get('/ViewSales',[App\Http\Controllers\SalesController::class,'view'])->name('viewSales');

//route for viewSalesDetails
Route::get('/viewSales/{id}',[App\Http\Controllers\SalesController::class,'viewSalesDetails']);

//route for delete sales details from edit sales
Route::delete('/DeleteSalesDetails/{id}',[App\Http\Controllers\SalesController::class,'DeleteSalesDetails']);

// Route::get('ViewPurchaseDetails-fetch',[App\Http\Controllers\ViewPurchaseDetailsController::class,'fetch_data'])->name('fetViwPurDet');

//credits Routes--------------------------------------------------------------------------------
Route::get('/credits',[App\Http\Controllers\CreditsController::class,'index'])->name('credits.index');

Route::post('/acceptPayment',[App\Http\Controllers\CreditsController::class,'acceptPayment']);

Route::post('/addCredit',[App\Http\Controllers\CreditsController::class,'addCredit']);

Route::get('/viewStatement/{id}',[App\Http\Controllers\CreditsController::class,'viewStatement']);

//return order routes-----------------------------------------------------------------------------
Route::resource('returnOrder',ReturnOrderController::class);

Route::get('viewReturnOrder/{id}',[App\Http\Controllers\ReturnOrderController::class,'viewReturnOrder']);

// reports routes
Route::get('/salesReport',[App\Http\Controllers\ReportsController::class,'SalesReportindex'])->name('salesReport.index');

Route::get('/purchaseReport',[App\Http\Controllers\ReportsController::class,'PurchaseReportindex'])->name('purchaseReport.index');

Route::get('/ReturnOrdersReport',[App\Http\Controllers\ReportsController::class,'ReturnOrdersReportindex'])->name('ReturnOrdersReport.index');

Route::get('/PaymentReport',[App\Http\Controllers\ReportsController::class,'PaymentReportindex'])->name('PaymentReport.index');

Route::get('/PayBackReport',[App\Http\Controllers\ReportsController::class,'PayBackReportindex'])->name('PayBackReport.index');

Route::get('/StockReport',[App\Http\Controllers\ReportsController::class,'StockReportindex'])->name('StockReport.index');

//payback routes
Route::Resource('/payback',PaybackController::class);

//settings routes
Route::view('/settings','settings')->name('settings.index');

Route::post('/addSettings',[App\Http\Controllers\SettingsController::class,'addSettings'])->name('addSettings');

//invoice route
Route::get('/invoice/{id}',[App\Http\Controllers\InvoiceController::class,'index'])->name('invoice');