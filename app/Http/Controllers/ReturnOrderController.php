<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales_Overview;
use App\Models\Sales_Details;
use App\Models\ReturnOrder_Overview;
use App\Models\ReturnOrder_Details;
use App\Models\Tracker_Table;
use App\Models\Product_Tracker;

class ReturnOrderController extends Controller
{
    //authentication
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
        $roList = ReturnOrder_Overview::join('customers','customers.id','=','return_order_overviews.Customer_Id')
                                    ->get(['return_order_overviews.*','customers.Customer_Name']);
        // return $roList;
        return view('ReturnOrderList',compact('roList'));
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
        // $total = intval($request->Total);
        // $total1 = intval($request->Return_Amount);
        // echo $total."---".$total1;
        // echo intval($total1 - $total);
        // return $request->all();
        $ro_overview = new ReturnOrder_Overview;
        $ro_overview->Date_Of_Return = $request->Date_Of_Return;
        $ro_overview->Customer_Id = $request->Customer_Id;
        $ro_overview->Sales_Id = $request->Sales_Id;
        $ro_overview->Total_SubTotal = $request->TotalSubTotal;
        $ro_overview->Total_TaxAmount = $request->TotalTaxAmount;
        $ro_overview->Discount_Per = $request->DiscountPer;
        $ro_overview->Discount_Amount = $request->DiscountAmount;
        $ro_overview->Amount_Returned = $request->Return_Amount;
        $ro_overview->Return_Method = $request->Return_Payment_Radio;
        $ro_overview->save();

        $insert_Id = $ro_overview->id;
        $no_of_products = count($request->SalesProductId);

        //inserting sales details in sales bills----------------------------------------
        for($i=0; $i<intval($no_of_products); $i++)
        {
            $ro_detail = new ReturnOrder_Details;
            $ro_detail->Return_Id = $insert_Id;
            $ro_detail->Product_Id = $request->SalesProductId[$i];
            $ro_detail->Quantity = $request->SalesQuantity[$i];
            $ro_detail->Price = $request->SalesPrice[$i];
            $ro_detail->Tax_Slab = $request->SalesTaxSlab[$i];
            $ro_detail->Tax_Amount = $request->SalesTaxAmount[$i];
            $ro_detail->Sub_Total = $request->SalesSubTotal[$i];
            $ro_detail->save();

            // $pro = Product::find($request->SalesProduct[$i]);
            // $pro->Quantity -= $request->SalesQuantity[$i];
            // $pro->update();

            //enter details in product tracker table
            $proTrack = new Product_Tracker;
            $proTrack->Date = $request->Date_Of_Return;
            $proTrack->Product_Id = $request->SalesProductId[$i];
            $proTrack->Quantity = $request->SalesQuantity[$i];
            $proTrack->Type = '1';
            $proTrack->Return_Id = $insert_Id;
            $proTrack->save();
        }

        if($ro_overview->Return_Method == 'Credit_Return')
        {
            $tt = new Tracker_Table;
            $tt->Date = $ro_overview->Date_Of_Return;
            $tt->Cust_Id = $ro_overview->Customer_Id;
            $tt->Sales_Id = $ro_overview->Sales_Id;
            $tt->Return_Id = $insert_Id;
            $tt->Payment_Method = $ro_overview->Return_Method;
            $tt->Amount = -ceil($ro_overview->Amount_Returned);
            $tt->Type = '1';
            if($request->Notes == '')
            {
                $tt->Note = 'Credit Return Bill Closure';
            }
            else
            {
                $tt->Note = $request->Notes;
            }
            $tt->Status = '1';
            $tt->save();
        }
        else if($ro_overview->Return_Method == 'Cash' || $ro_overview->Return_Method == 'Bank')
        {
            if($request->Notes == '')
            {
                $Note = 'Return Bill Partial/Full';
            }
            else
            {
                $Note = $request->Notes;
            }
            $tt = Tracker_Table::where('Sales_Id',$request->Sales_Id)
            ->where('Type','0')
            ->update([
                'Date' => $request->Date_Of_Return,
                'Cust_Id' => $request->Customer_Id,
                // $tt->Sales_Id = $ro_overview->Sales_Id;
                'Return_Id' => $insert_Id,
                'Payment_Method' => $request->Payment_Radio,
                'Amount' => ceil($request->Total - $request->Return_Amount),
                // 'Type' => '0',
                // 'Status'=>'2',
                'Note' => $Note
            ]);

            // $tt1 = new Tracker_Table;
            // $tt1->Date = $ro_overview->Date_Of_Return;
            // $tt1->Cust_Id = $ro_overview->Customer_Id;
            // $tt1->Sales_Id = $ro_overview->Sales_Id;
            // $tt1->Return_Id = $insert_Id;
            // $tt1->Payment_Method = $ro_overview->Return_Method;
            // $tt1->Amount = -$ro_overview->Amount_Returned;
            // $tt1->Type = '1';
            // $tt1->Note = 'Return Bill Closure';
            // $tt1->save();
        }

        return redirect()->route('returnOrder.index')->with('status','Return order Generated Successfully');
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
        $sales_overview = Sales_Overview::join('customers','customers.id','=','sales_overviews.Customer_Id')
                                        ->where('sales_overviews.id',$id)
                                        ->get(['sales_overviews.*','customers.Customer_Name','customers.Contact']);

        $sales_detail = Sales_Details::join('products','products.id','=','sales_details.Sales_Product')
                                    ->where('sales_details.Sales_Id',$id)
                                    ->get(['sales_details.*','products.Name']);

        // print_r($sales_overview .'\n-----------------------------'. $sales_detail);return false;
        return view('returnOrder',compact('sales_overview','sales_detail'));
    }

    //special method to view return order details
    public function viewReturnOrder($id)
    {
        $ret_overview = ReturnOrder_Overview::join('customers','customers.id','=','return_order_overviews.Customer_Id')
                                            ->where('return_order_overviews.id',$id)
                                            ->get(['return_order_overviews.*','customers.Customer_Name','customers.Contact']);
                    
        $ret_detail = ReturnOrder_Details::join('products','products.id','=','return_order_details.Product_Id')
                                            ->where('return_order_details.Return_Id',$id)
                                            ->get(['return_order_details.*','products.Name']);

        // print_r($ret_overview.'========='.$ret_detail);return false;
        return view('ReturnOrderDetails',compact('ret_overview','ret_detail'));
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
        $ro_over = ReturnOrder_Overview::find($id)->delete();
        $ro_det = ReturnOrder_Details::where('Return_Id','=',$id)->delete();
        $tts = Tracker_Table::where('Return_Id','=',$id)->delete();
        $pts = Product_Tracker::where('Return_Id','=',$id)->delete();
        if($ro_det && $ro_over && $tts && $pts)
        {
            return redirect()->back()->with('status','Return Order Deleted Successfully');
        }
    }
}
