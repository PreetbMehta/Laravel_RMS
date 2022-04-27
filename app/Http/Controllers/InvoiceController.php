<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales_Overview;
use App\Models\Sales_Details;
use App\Models\Settings;

class InvoiceController extends Controller
{
    //
    public function index(Request $request,$id)
    {
        // dd('123'.'\n'.$id);
        $sal_over = Sales_Overview::join('customers','customers.id','sales_overviews.Customer_Id')
                                ->where('sales_overviews.id',$id)
                                ->get(['sales_overviews.*','customers.*']);
        $sal_det = Sales_Details::join('products','products.id','sales_details.Sales_Product')
                                ->where('Sales_Id','=',$id)
                                ->get();
        $setting = Settings::select('*')->get();

        return view('invoice',compact('sal_over','sal_det','setting'));
        // return ['sal_Over'=>$sal_over,'sal_det'=>$sal_det,'sett'=>$setting];
    }
}
