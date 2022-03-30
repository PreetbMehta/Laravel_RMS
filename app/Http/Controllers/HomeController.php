<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;

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

        //alert Quantity Table
        $proAlert = Product::whereRaw("Alert_Quantity >= Quantity")
                                ->get(['id','Name','Reference_Id','Quantity','Alert_Quantity']);
        return view('home',['product'=>$product,'supplier'=>$supplier,'customer'=>$customer,'category'=>$category,'proAlert'=>$proAlert]);
    }
}
