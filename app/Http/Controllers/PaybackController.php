<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnOrder_Overview;
use App\Models\Sales_Overview;
use App\Models\Tracker_Table;

class PaybackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ro = ReturnOrder_Overview::select('id')->get();
        $s = Sales_Overview::select('id')->get();
        // dd($ro.'++'.$s);
        return view('payback',compact('ro','s'));
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
        // return $request->all();
        
        $tt = new Tracker_Table;
        $tt->Date = $request->Bill_Date;
        $tt->Cust_Id = $request->Customer_Id;
        $tt->Sales_Id = $request->Sales_Id;
        $tt->Return_Id = $request->Return_Id;
        $tt->Amount = abs($request->ATP);
        $tt->Type = '0';
        $tt->Payment_Method = 'Payback '.$request->Payment_Method;
        $tt->Note = $request->Payment_Note;
        $tt->Status = '2';
        $tt->save();

        return redirect()->back()->with('status','Payback added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //values for return_id radio type
        $r = ReturnOrder_Overview::join('customers','customers.id','return_order_overviews.Customer_Id')
                                ->where('return_order_overviews.id',$id)
                                ->get(['Date_Of_Return as Bill_Date','Sales_Id','Customer_Id','Customer_Name as Cust_Name','Amount_Returned as Bill_Amount','Return_Method as Payment_Method']);
        $a = $r[0]->Sales_Id;
        $s = Tracker_Table::where('Sales_Id','=',$a)
                            ->sum('Amount');
        // dd($s,$a);
        return response()->json([
            'status'=>'200',
            'data'=>$r,$s
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //values for edit sales radio type
        $r = Sales_Overview::join('customers','customers.id','sales_overviews.Customer_Id')
                                ->where('sales_overviews.id',$id)
                                ->get(['Date_Of_Sale as Bill_Date','Customer_Id','Customer_Name as Cust_Name','Total_Amount as Bill_Amount','Payment_Method']);

        $s = Tracker_Table::where('Sales_Id','=',$id)
                            ->sum('Amount');
        return response()->json([
            'status'=>'200',
            'data'=>$r,$s
        ]);
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
    }
}
