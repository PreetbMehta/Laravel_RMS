<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\category;
use Illuminate\Http\Request;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $show = Product::all();//for fetching all prooduct details
        
        $cat_for_select = category::all();//for fetching category names
        
        return view('products',['showProduct'=>$show],['Cat_Select'=>$cat_for_select]);
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
        //validate input details
        
        //store product details
        $product = new Product;

        $product->Reference_Id = $request->input('Reference_Id');
        $product->Category = $request->input('Category');
        $product->Quantity = $request->input('Quantity');
        $product->Cost_Price = $request->input('Cost_Price');
        $product->MRP = $request->input('MRP');
        $product->Purchase_no = $request->input('Purchase_no');
        $product->Short_Desc = $request->input('Short_Desc');

        if($request->hasFile('Picture'))
        {
            $file = $request->file('Picture');
            $extension = $file->getClientOriginalExtension();
            $Ref_Id = $request->input('Reference_Id');
            $fileName = $Ref_Id.'.'.$extension;
            $file->move('Uploads/Product_Pics',$fileName);
            $product->Picture = $fileName;
        }
        $product->save();
        if($product->save()){
            return redirect()->back()->with('status','Product added successfully');
        }
        return redirect()->back()->with('status','Product not created successfully');
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
        $pro = Product::find($id);
        
        $pro->Reference_Id = $request->input('Reference_Id');
        $pro->Category = $request->input('Category');
        $pro->Quantity = $request->input('Quantity');
        $pro->Cost_Price = $request->input('Cost_Price');
        $pro->MRP = $request->input('MRP');
        $pro->Purchase_no = $request->input('Purchase_no');
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
            $fileName = $Ref_Id.'.'.time().$extension;
            $file->move('Uploads/Product_Pics',$fileName);
            $pro->Picture = $fileName;
        }
        $pro->update();
        //  $okay = $pro->update();
         if($pro->update()){
             return redirect()->back()->with('status','Purchase updated successfully');
         }
             return redirect()->back()->with('status','Purchase Not Updated successfully');
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
        
        return redirect()->back()->with('status','Purchase deleted successfully');
    }
}
