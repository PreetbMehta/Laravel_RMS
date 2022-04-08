<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Purchase_Overview;
use App\Models\Sales_Overview;
use App\Models\Sales_Details;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product = Product::count();
        $supplier = Supplier::count();
        $customer = Customer::count();
        $category = category::count();
        $purchase = Purchase_Overview::count();
        $sale = Sales_Overview::count();
   
        //tptp-------------------------
        // $count = Sales_Details::groupBy('Sales_Product')->select('Sales_Product', DB::raw('count(*) as total'))->get();;
        // return $count;

        //alert Quantity Table
        $proAlert = Product::whereRaw("Alert_Quantity >= Quantity")
                                ->get(['id','Name','Reference_Id','Quantity','Alert_Quantity']);
        return view('home',['product'=>$product,'supplier'=>$supplier,'customer'=>$customer,'category'=>$category,'purchase'=>$purchase,'sale'=>$sale,'proAlert'=>$proAlert]);
    }
}
