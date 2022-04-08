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
Route::get('/ViewSales',[App\Http\Controllers\SalesController::class,'view']);

//route for viewSalesDetails
Route::get('/viewSales/{id}',[App\Http\Controllers\SalesController::class,'viewSalesDetails']);

//route for delete sales details from edit sales
Route::delete('/DeleteSalesDetails/{id}',[App\Http\Controllers\SalesController::class,'DeleteSalesDetails']);

// Route::get('ViewPurchaseDetails-fetch',[App\Http\Controllers\ViewPurchaseDetailsController::class,'fetch_data'])->name('fetViwPurDet');

//credits Routes--------------------------------------------------------------------------------
Route::get('/credits',[App\Http\Controllers\CreditsController::class,'index']);

Route::post('/acceptPayment',[App\Http\Controllers\CreditsController::class,'acceptPayment']);

Route::post('/addCredit',[App\Http\Controllers\CreditsController::class,'addCredit']);

Route::get('/viewStatement/{id}',[App\Http\Controllers\CreditsController::class,'viewStatement']);

//return order routes-----------------------------------------------------------------------------
Route::resource('returnOrder',ReturnOrderController::class);

Route::get('viewReturnOrder/{id}',[App\Http\Controllers\ReturnOrderController::class,'viewReturnOrder']);

