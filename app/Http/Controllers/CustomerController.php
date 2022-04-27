<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
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
    public function index(Request $request)
    {
        //
        if($request->ajax())
        {
            $data = Customer::orderBy('id','desc')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $btn = '<button id="edit_Btn" data-toggle="modal" data-target="#EditCustomerModal" value="'.$row->id.'" class="edit btn btn-primary btn-sm editBtn"><i class="fas fa-pen text-white"></i> Edit</button>';
                $btn = $btn.' <button id="del_Btn" data-toggle="tooltip" value="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn"><i class="far fa-trash-alt text-white" data-feather="delete"></i> Delete</button>';

                return $btn;

            })
            ->rawColumns(['action'])->make(true);
        }
        return view('customers');
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
        //validate data
        $ValidatedData = Validator::make($request->all(),[
            'Customer_Name'=> 'required',
            'Contact'=> 'required|numeric',
            'Email_Id'=> 'required|email'
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
            $customer = Customer::create($request->all());
    
            if($customer)
            {
                return response()->json([
                    'status'=>200,
                    'message'=>'Customer Added Successfully',
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $EditValidatedData = Validator::make($request->all(),[
            'Customer_Name'=> 'required',
            'Contact'=> 'required|numeric',
            'Email_Id'=> 'required|email'
        ]);

        if($EditValidatedData->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$EditValidatedData->messages(),
            ]);
        }
        else
        {
            $cust = Customer::find($id);
            $cust->Customer_Name = $request->Customer_Name;
            $cust->Contact = $request->Contact;
            $cust->Email_Id = $request->Email_Id;
            $cust->Active_Status = $request->Active_Status;
            $cust->update();
            return response()->json([
                'status'=>200,
                'message'=>'Customer Updated Successsfully',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $del_cust = Customer::find($id);
        
        $del_cust->delete();
        return response()->json([
            'status' => 200,
            'message'=>'Customer Deleted Successsfully'
        ]);
    }
}
