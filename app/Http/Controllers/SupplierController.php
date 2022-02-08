<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
// use App\Models\Supplier;

class SupplierController extends Controller
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
        //List down All the Suppliers
        $show = Supplier::all();
        return view('suppliers',["showSupplier"=>$show]);
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
        //validate date
        $ValidatedData = $request->validate([
            'Contact' => 'required|numeric',
            'GST_No' => 'required|min:15|max:15',
            'Account_No' => 'required|min:9|max:18',
            'IFSC_Code' => 'required|min:11|max:11'
        ]);
        //store input data
        $Supplier = Supplier::create($request->all());
        // $Supplier = new Supplier::find(id);
        // $Supplier->Supplier_Name = $request->input('Supplier_Name');
        // $Supplier->Brand_Name = $request->input('Brand_Name');
        // $Supplier->Address = $request->input('Address');
        // $Supplier->Contact = $request->input('Contact');
        // $Supplier->Email_Id = $request->input('Email_Id');
        // $Supplier->GST_No = $request->input('GST_No');
        // $Supplier->Account_No = $request->input('Account_No');
        // $Supplier->IFSC_Code = $request->input('IFSC_Code');
        // $Supplier->save();
        return redirect()->back()->with('status','Supplier Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate date
        $ValidatedEditData = $request->validate([
            'Edit_Contact' => 'required|numeric',
            'Edit_GST_No' => 'required|min:15|max:15',
            'Edit_Account_No' => 'required|min:9|max:18',
            'Edit_IFSC_Code' => 'required|min:11|max:11'
        ]);

        // return $request->all();
        $sup = Supplier::find($id);
        // $Sup->Supplier_Name = $request->input('Supplier_name');
        // $Sup->Brand_Name = $request->input('Brand_Name');
        // $Sup->Address = $request->input('Address');
        // $Sup->Contact = $request->input('Contact');
        // $Sup->Email_Id = $request->input('Email_Id');
        // $Sup->GST_No = $request->input('GST_No');
        // $Sup->Account_No = $request->input('Account_No');
        // $Sup->IFSC_Code = $request->input('IFSC_Code');
        
        $okay = $sup->update($request->all());
        if($okay){
            return redirect()->back()->with('status','Supplier details Updated Successfully');
        }
        return redirect()->back()->with('status','Supplier details Not Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $Supplier = Supplier::find($id);
        $Supplier->delete();
        
        return redirect()->back()->with('status','Purchase deleted successfully');
    }
}
