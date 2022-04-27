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
use App\Models\Product_Tracker;
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

        //alert Quantity Table
        $pro_track = Product_Tracker::join('products','products.id','product_trackers.Product_Id')
        ->groupBy('Product_Id','Name','products.Reference_Id','products.Alert_Quantity')
        ->selectRaw('sum(product_trackers.Quantity) as QuantityLeft,Product_Id,products.Name,products.Reference_Id,products.Alert_Quantity')
        ->get();
        // return $pro_track;
        $check = [];
        for($i=0;$i<count($pro_track);$i++)
        {
            if($pro_track[$i]->QuantityLeft <= $pro_track[$i]->Alert_Quantity)
            {
                $check[] = $pro_track[$i];
            }
        }
        // return $check;
        return view('home',['product'=>$product,'supplier'=>$supplier,'customer'=>$customer,'category'=>$category,'purchase'=>$purchase,'sale'=>$sale,'proAlert'=>$check]);
    }
}
