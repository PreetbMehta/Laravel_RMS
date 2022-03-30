<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase_Overview;
use App\Models\Purchase_Detail;
use App\Models\Supplier;
use App\Models\Product;
use DB;

class ViewPurchaseController extends Controller
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
        $showPur = DB::table('purchase_overviews')->join('suppliers','suppliers.id','=','purchase_overviews.Supplier_Id')
                                        ->select('purchase_overviews.*','suppliers.Supplier_Name','suppliers.Brand_Name')
                                        ->orderBy("purchase_overviews.id","desc")
                                        ->get();
        $showSup = Supplier::select('id','Supplier_Name','Brand_Name')->get();
        // return $showPur;
        $pro = Product::select('id','Name')->get();

        return view('viewPurchase',compact('showPur','showSup','pro'));
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
        // $pro = Product::select('id','Name')->get();
        
        // $pur_det = Purchase_Detail::all()->where('Purchase_Id',$id);
        // // return compact('id','sup','pur_over','pur_det');
        // return response()->json([
        //     'status'=>'200',
        //     'id'=>$id,
        //     'product'=>$pro,
        //     'pur_det'=>$pur_det
        // ]);
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
        $pur = Purchase_Overview::find($id)->delete();

        $purD = Purchase_Detail::where('purchase_details.Purchase_Id',$id)->delete();
        echo($pur.'\n'.$purD);

        if($pur && $purD)
        {
            return redirect()->back()->with('status','Purchase deleted successfully');
        }
        else{
            return redirect()->back()->with('error','Purchase not deleted successfully');
        }
    }
}
