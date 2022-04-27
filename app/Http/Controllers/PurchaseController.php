<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use App\Models\Product_Tracker;
use App\Models\Purchase_Detail;
use App\Models\Purchase_Overview;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $show = Product::select('id','Name','TaxSlab','Reference_Id')
                    ->where('Active_Status','=','1')
                    ->orderBy('Name','asc')
                    ->get();
        $show_supp = Supplier::select('id','Supplier_Name','Brand_Name')
                    ->where('Active_Status','=','1')
                    ->get();
        return view('addPurchase',['showProduct'=>$show,'Show_supp'=>$show_supp]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
            // $request->validate([
            //     //purchase overview fields validation
            //     'Date_Of_Purchase'=>'required|date',
            //     'Supplier_Id'=>'required',
            //     'Total_Products' => 'required|numeric',
            //     'Total_Tax_Amount' => 'required|numeric',
            //     'Total_Amount' => 'required|numeric',
            //     //purchase detail fields validations
            //     'PurchaseProductId' => 'required',
            //     'PurchaseQuantity' => 'required',
            //     'PurchasePrice' => 'required',
            //     'PurchaseTaxSlab' => 'required',
            //     'PurchaseTaxAmount' => 'required',
            //     'PurchaseSubTotal' => 'required'
            // ]);
            // print_r($request->all());
            $validatedData = Validator::make($request->all(),[
                // purchase overview fields validation
                'Date_Of_Purchase'=>'required|date',
                'Supplier_Id'=>'required',
                'TotalTaxAmount' => 'required|numeric',
                'TotalAmount' => 'required|numeric',
                //purchase detail fields validations
                'PurchaseProductId' => 'required',
                'PurchaseQuantity' => 'required',
                'PurchasePrice' => 'required',
                'PurchaseTaxSlab' => 'required',
                'PurchaseTaxAmount' => 'required',
                'PurchaseSubTotal' => 'required'
            ]);
            if($validatedData->fails())
            {
                return redirect()->back()->with('errors',$validatedData->messages());
            }
            else
            {
                //store data in order overview ----------------------------------------------
                $purchase_Overview = new Purchase_Overview;
                $purchase_Overview->Date_Of_Purchase = $request->input('Date_Of_Purchase');
                $purchase_Overview->Supplier_Id = $request->input('Supplier_Id');
                $purchase_Overview->Sub_Total = $request->input('TotalSubTotal');
                $purchase_Overview->Total_Tax_Amount = $request->input('TotalTaxAmount');
                $purchase_Overview->Total_Amount = $request->input('TotalAmount');
                $purchase_Overview->Discount_Amount = $request->input('DiscountAmount');
                $purchase_Overview->Total_Products = count($request->input('PurchaseProductId'));
                $purchase_Overview->save();

                //store data in purchase details ---------------------------------------------
                $insert_id = $purchase_Overview->id;//get insert id of above added record
                $no_of_products = count($request->input('PurchaseProductId'));
                // echo($no_of_products);
                // return false;
                
                for($i=0; $i<intval($no_of_products); $i++)
                {
                    $purchase_detail = new Purchase_Detail;
                    $purchase_detail->Purchase_Id = $insert_id;
                    $purchase_detail->Product_Id = $request->PurchaseProductId[$i];
                    $purchase_detail->Price = $request->PurchasePrice[$i];
                    $purchase_detail->Quantity = $request->PurchaseQuantity[$i];
                    $purchase_detail->Tax_Slab = $request->PurchaseTaxSlab[$i];
                    $purchase_detail->Tax_Amount = $request->PurchaseTaxAmount[$i];
                    $purchase_detail->Sub_Total = $request->PurchaseSubTotal[$i];
                    $purchase_detail->save();

                    //enter details in product tracker table
                    $proTrack = new Product_Tracker;
                    $proTrack->Date = $request->input('Date_Of_Purchase');
                    $proTrack->Product_Id = $request->PurchaseProductId[$i];
                    $proTrack->Quantity = $request->PurchaseQuantity[$i];
                    $proTrack->Type = '1';
                    $proTrack->Purchase_Id = $insert_id;
                    $proTrack->save();
                }
                return redirect()->back()->with("status","Purchase Added Successfully");
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase_Detail $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase_Detail $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
