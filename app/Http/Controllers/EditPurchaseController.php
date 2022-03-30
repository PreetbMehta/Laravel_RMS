<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Purchase_Overview;
use App\Models\Purchase_Detail;
use App\Models\Product;
use DB;
use Illuminate\Support\Facades\Validator;

class EditPurchaseController extends Controller
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
    public function index($id)
    {
        //
        // $sup = Supplier::select('id','Supplier_Name','Brand_Name')->get();

        // $pur_over = Purchase_Overview::select('*')->where('id',$id)->first();

        // $pur_det = Purchase_Detail::all()->where('Purchase_Id',$id);

        // $showProduct = Product::all();
        // return view('EditPurchase',compact('sup','pur_over','pur_det','id','showProduct'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $sup = Supplier::select('id','Supplier_Name','Brand_Name')->get();

        $pur_over = Purchase_Overview::select('*')->where('id',$id)->first();

        $pur_det = Purchase_Detail::all()->where('Purchase_Id',$id);

        $showProduct = Product::all();
        return view('EditPurchase',compact('sup','pur_over','pur_det','id','showProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = Validator::make($request->all(),[
            // purchase overview fields validation
            'Date_Of_Purchase'=>'required|date',
            'Supplier_Id'=>'required',
            'TotalTaxAmount' => 'required|numeric',
            'TotalAmount' => 'required|numeric',
            //purchase detail fields validations
            'PurchaseProduct' => 'required',
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
        {//return $request->all();
            //store data in order overview ----------------------------------------------
            $purchase_Overview = Purchase_Overview::find($id);
            $purchase_Overview->Date_Of_Purchase = $request->input('Date_Of_Purchase');
            $purchase_Overview->Supplier_Id = $request->input('Supplier_Id');
            $purchase_Overview->Sub_Total = $request->input('TotalSubTotal');
            $purchase_Overview->Total_Tax_Amount = $request->input('TotalTaxAmount');
            $purchase_Overview->Total_Amount = $request->input('TotalAmount');
            $purchase_Overview->Discount_Amount = $request->input('DiscountAmount');
            $purchase_Overview->Total_Products = count($request->input('PurchaseProduct'));
            $purchase_Overview->update();
            // 
            // $no_of_products = count($request->input('PurchaseProduct'));//count no of products
            for($i=0; $i<count($request->RowId); $i++)
            {
                // echo($i."\n \t");
                // echo($request->PurchaseProduct[$i]);
                if($request->RowId[$i]==0)
                { 
                // echo($i.":: \t");return false;
                    $purchase_detail = new Purchase_Detail;
                    $purchase_detail->Purchase_Id = $id;
                    $purchase_detail->Product_Id = $request->PurchaseProduct[$i];
                    $purchase_detail->Price = $request->PurchasePrice[$i];
                    $purchase_detail->Quantity = $request->PurchaseQuantity[$i];
                    $purchase_detail->Tax_Slab = $request->PurchaseTaxSlab[$i];
                    $purchase_detail->Tax_Amount = $request->PurchaseTaxAmount[$i];
                    $purchase_detail->Sub_Total = $request->PurchaseSubTotal[$i];
                    $purchase_detail->save();
                }
                else
                {
                // echo($request->PurchaseProduct[$i].":");
                    // $purchase_detail = DB::table('purchase_details')
                    //                             ->where('id',$request->RowId[$i])
                    //                             ->update([
                    //                                 'Product_Id'=>$request->PurchaseProduct[$i],
                    //                                 'Price'=>$request->PurchasePrice[$i],
                    //                                 'Quantity'=>$request->PurchaseQuantity[$i],
                    //                                 'Tax_Slab'=>$request->PurchaseTaxSlab[$i],
                    //                                 'Tax_Amount'=>$request->PurchaseTaxAmount[$i],
                    //                                 'Sub_Total'=>$request->PurchaseSubTotal[$i]
                    //                             ]);
                    // echo($request->RowId[$i].":");
                    $purchase_detail = Purchase_Detail::find($request->RowId[$i]);
                    $purchase_detail->Product_Id = $request->PurchaseProduct[$i];
                    $purchase_detail->Price = $request->PurchasePrice[$i];
                    $purchase_detail->Quantity = $request->PurchaseQuantity[$i];
                    $purchase_detail->Tax_Slab = $request->PurchaseTaxSlab[$i];
                    $purchase_detail->Tax_Amount = $request->PurchaseTaxAmount[$i];
                    $purchase_detail->Sub_Total = $request->PurchaseSubTotal[$i];
                    $purchase_detail->update();
                }
            }
            return redirect('viewPurchase')->with("status","Purchase Updated Successfully");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pur_det = Purchase_Detail::find($id);
        $pur_det->delete();
        if($pur_det)
        {
            return response()->json([
                'status'=>'200',
                'message'=>'Row Deleted Successfully'
            ]);
        }
    }
}
