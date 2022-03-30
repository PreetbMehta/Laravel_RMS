<?php

namespace App\Http\Controllers;

use App\Models\taxSlab;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables as Datatables;
use Illuminate\Support\Facades\Validator;

class TaxSlabController extends Controller
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
        //
        if ($request->ajax()) {

            $data = taxSlab::orderBy("id","desc")->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $btn = '<button id="edit_Btn" data-toggle="modal" data-target="#EditTaxSlabModal" value="'.$row->id.'" class="edit btn btn-primary btn-sm editBtn"><i class="fas fa-pen text-white"></i> Edit</button>';
                $btn = $btn.' <button id="del_Btn" data-toggle="tooltip" value="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn"><i class="far fa-trash-alt text-white" data-feather="delete"></i> Delete</button>';

                return $btn;

            })
            ->rawColumns(['action'])->make(true);

        }
        return view('taxSlabMaster');
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
        $validate = Validator::make($request->all(),[
            'TaxPercentage'=>'required'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validate->messages()
            ]);
        }
        else
        {
            $taxSlab = taxSlab::create($request->all());
            
            if($taxSlab){
                return response()->json([
                    'status' => 200,
                    'message' => 'TaxSlab added successfully'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\taxSlab  $taxSlab
     * @return \Illuminate\Http\Response
     */
    public function show(taxSlab $taxSlab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\taxSlab  $taxSlab
     * @return \Illuminate\Http\Response
     */
    public function edit(taxSlab $taxSlab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\taxSlab  $taxSlab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $Edit_validate = Validator::make($request->all(),[
            'TaxPercentage'=>'required'
        ]);
        if($Edit_validate->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$Edit_validate->messages()
            ]);
        }
        else
        {
            $taxSlab = taxSlab::find($id);

            $okay = $taxSlab->update($request->all());
            if($okay){
                // return redirect()->back()->with('status','Category updated successfully');
                return response()->json([
                    'status' => 200,
                    'message'=> 'Category updated successfully'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\taxSlab  $taxSlab
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $taxSlab = category::find($id);
        $taxSlab->delete();
        
        return response()->json([
            'status'=>200,
            'message'=>'Category deleted successfully'
        ]);
    }
}
