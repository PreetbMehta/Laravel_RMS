<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    {
        // return view('suppliers');
        if ($request->ajax()) {
            $data = Supplier::orderBy("id","desc")->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $btn = '<button id="edit_Btn" data-toggle="modal" data-target="#EditSupplierModal" value="'.$row->id.'" class="edit btn btn-primary btn-sm editBtn"><i class="fas fa-pen text-white"></i> Edit</button>';
                $btn = $btn.' <button id="del_Btn" data-toggle="tooltip" value="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn"><i class="far fa-trash-alt text-white" data-feather="delete"></i> Delete</button>';

                return $btn;

            })
            ->rawColumns(['action'])->make(true);

        }

        return view('suppliers');
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
        $ValidatedData = Validator::make($request->all(),[
            'Supplier_Name'=>'required',
            'Brand_Name'=>'required',
            'Address'=>'required',
            'Contact' => 'required|numeric',
            'Email_Id'=>'required|email',
            'GST_No' => 'required|min:15|max:15',
            'Account_No' => 'required|min:9|max:18',
            'IFSC_Code' => 'required|min:11|max:11'
        ]);
        if($ValidatedData->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$ValidatedData->messages(),
            ]);
        }
        else
        {
            //store input data
            $Supplier = Supplier::create($request->all());
            return response()->json([
                'status'=>200,
                'message'=>'Supplier added Successsfully',
            ]);
        
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
            // return redirect()->back()->with('status','Supplier Created Successfully');
        }
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
        $ValidatedEditData = Validator::make($request->all(),[
            'Supplier_Name'=>'required',
            'Brand_Name'=>'required',
            'Address'=>'required',
            'Contact' => 'required|numeric',
            'Email_Id'=>'required|email',
            'GST_No' => 'required|min:15|max:15',
            'Account_No' => 'required|min:9|max:18',
            'IFSC_Code' => 'required|min:11|max:11'
        ]);
        if($ValidatedEditData->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$ValidatedEditData->messages(),
            ]);
        }
        else
        {
            //update input data
            $sup = Supplier::find($id);
            // print_r($request->all());
            // return false;
            $sup->Supplier_Name = $request->Supplier_Name;
            $sup->Brand_Name = $request->Brand_Name;
            $sup->Address = $request->Address;
            $sup->Contact = $request->Contact;
            $sup->Email_Id = $request->Email_Id;
            $sup->GST_No = $request->GST_No;
            $sup->Account_No = $request->Account_No;
            $sup->IFSC_Code = $request->IFSC_Code;
            $sup->Active_Status = $request->Active_Status;
            $sup->update();
            return response()->json([
                'status'=>200,
                'message'=>'Supplier Updated Successsfully',
            ]);
        }
       
        // $Sup->Supplier_Name = $request->input('Supplier_name');
        // $Sup->Brand_Name = $request->input('Brand_Name');
        // $Sup->Address = $request->input('Address');
        // $Sup->Contact = $request->input('Contact');
        // $Sup->Email_Id = $request->input('Email_Id');
        // $Sup->GST_No = $request->input('GST_No');
        // $Sup->Account_No = $request->input('Account_No');
        // $Sup->IFSC_Code = $request->input('IFSC_Code');
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
        return response()->json([
            'status' => 200,
            'message'=>'Supplier Deleted Successsfully'
        ]);
        
    }
}
