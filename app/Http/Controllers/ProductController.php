<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\category;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class ProductController extends Controller
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
        $Cat_Select = category::all();//for fetching category names
        if ($request->ajax()) {
            $data = Product::orderBy("id","desc")->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('Picture',function($row){
                $url = asset('Uploads/Product_Pics/'.$row->Picture);
                return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
            })
            ->addColumn('action',function($row){
                $btn = '<button id="edit_Btn" data-toggle="modal" data-target="#EditProductModal" value="'.$row->id.'" class="edit btn btn-primary btn-sm editBtn"><i class="fas fa-pen text-white"></i> Edit</button>';
                $btn = $btn.' <button id="del_Btn" data-toggle="tooltip" value="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn"><i class="far fa-trash-alt text-white" data-feather="delete"></i> Delete</button>';

                return $btn;

            })
            ->rawColumns(['Picture','action'])->make(true);

        }

        return response()->view('products',compact('Cat_Select'));
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
        //validate input data
        $validate = Validator::make($request->all(),[
            'Name'=>'required',
            'Category'=>'required',
            'Reference_Id'=>'required',
            'MRP'=>'required|numeric',
            'Unit'=>'required',
            'Quantity'=>'required|numeric',
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
            //store product details
            $product = new Product;
            
            $product->Reference_Id = $request->input('Reference_Id');
            $product->Category = $request->input('Category');
            $product->Quantity = $request->input('Quantity');
            $product->Name = $request->input('Name');
            $product->MRP = $request->input('MRP');
            $product->Unit = $request->input('Unit');
            $product->Short_Desc = $request->input('Short_Desc');

            if($files = $request->file('Picture'))
            {
                $file = $request->file('Picture');
                $extension = $file->getClientOriginalExtension();
                $Ref_Id = $request->input('Reference_Id');
                $fileName = date('dmY') .uniqid().'.'.$extension;
                $file->move('Uploads/Product_Pics',$fileName);
                $product->Picture = $fileName;
            }
            // $product->save();
            if($product->save())
            {
                return response()->json([
                    'status'=>200,
                    'message'=>'Product Added successfully']);
                }
            }
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate input data
        $Editvalidate = Validator::make($request->all(),[
            'Name'=>'required',
            'Category'=>'required',
            'Reference_Id'=>'required',
            'MRP'=>'required|numeric',
            'Unit'=>'required',
            'Quantity'=>'required|numeric',
        ]); 
        // $Editvalidate = $request->validate([
        //     'Name'=>'required',
        //     'Category'=>'required',
        //     'Reference_Id'=>'required',
        //     'MRP'=>'required|numeric',
        //     'Unit'=>'required',
        //     'Quantity'=>'required|numeric',
        // ]);
        if($Editvalidate->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$Editvalidate->messages()
            ]);
        }
        else
        {

            $pro = Product::find($id);

            $pro->Category = $request->input('Category');
            $pro->Quantity = $request->input('Quantity');
            $pro->Name = $request->input('Name');
            $pro->MRP = $request->input('MRP');
            $pro->Unit = $request->input('Unit');
            $pro->Short_Desc = $request->input('Short_Desc');
            
            if($request->hasFile('Picture'))
            {
                $destination = 'Uploads/Product_Pics/'.$pro->Picture;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
                $file = $request->file('Picture');
                $extension = $file->getClientOriginalExtension();
                $Ref_Id = $request->input('Reference_Id');
                $fileName = date('dmY') .uniqid().'.'.$extension;
                $file->move('Uploads/Product_Pics',$fileName);
                $pro->Picture = $fileName;
            }
             $okay = $pro->update();
            if($okay){
                return response()->json([
                    'status'=>200,
                    'message'=>'Product Updated successfully']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $destination = 'Uploads/Product_Pics/'.$product->Picture;
        if(File::exists($destination))
        {
            File::delete($destination);
        }
        $product->delete();
        
        return response()->json([
            'status'=>200,
            'message'=>'Product deleted successfully']);
    }
}
