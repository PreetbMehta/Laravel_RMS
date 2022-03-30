<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase_Overview;
use App\Models\Supplier;
use App\Models\Purchase_Detail;
use App\Models\Product;
use DB;


class ViewPurchaseDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $showDetails = DB::table('purchase_details')->select('*')->where('Purchase_Id','=',$id)->get();
        // echo($showDetails);

        $countSDet = count($showDetails);

        $pur_Overview = Purchase_Overview::select('*')->where('id',$id)->get();
        // echo($pur_Overview);

        $Supid = $pur_Overview[0]->Supplier_Id;
        $sup = Supplier::select('Supplier_Name','Brand_Name','Address','Contact','Email_id')
                            ->where('id',$Supid)
                            ->get();
        // echo($sup);return false;

        $pro = Product::join('purchase_details','purchase_details.Product_Id','=','products.id')
                                ->where('purchase_details.Purchase_Id',$id)
                                ->get(['products.id','products.Name','products.Reference_Id']);
        // echo($pro);return false;

        return view('ViewPurchaseDetails',compact('showDetails','id','countSDet','pur_Overview','sup','pro'));
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
    }
}
