<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

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
        $show = Purchase::all();
        return view('purchase',['showPurchase'=>$show]);
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
        $purchase = Purchase::create($request->all());

        if($purchase){
            return redirect()->back()->with('status','Purchase added successfully');
        }
        return redirect()->back()->with('status','Purchase not created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
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
        $pur = Purchase::find($id);

        // $pur->Date_Of_Purchase = $request->input('Date_Of_Purchase');
        // $pur->Supplier_Name = $request->input('Supplier_Name');
        // $pur->Supplier_Id = $request->input('Supplier_Id');
        // $pur->Quantity = $request->input('Quantity');
        // $pur->Total_Bill_Amount = $request->input('Total_Bill_Amount');
        // $pur->GST_Amount = $request->input('GST_Amount');

        $okay = $pur->update($request->all());
        if($okay){
            return redirect()->back()->with('status','Purchase updated successfully');
        }
            return redirect()->back()->with('status','Purchase Not Updated successfully');
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
        $purchase = Purchase::find($id);
        $purchase->delete();
        
        return redirect()->back()->with('status','Purchase deleted successfully');
    }
}
