<?php

namespace App\Http\Controllers;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales_Overview;
use App\Models\Sales_Details;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cust = Customer::all();
        $pro = Product::select('id','Name','TaxSlab','MRP')->get();
        return view('sales',compact('cust','pro'));
    }

    //special function to return viewsales view
    public function view()
    {
        $sale_overview = Sales_Overview::join('customers','customers.id','=','sales_overviews.Customer_Id')
                                    ->orderBy("sales_overviews.id","desc")
                                    ->get(['sales_overviews.*','customers.Customer_Name','customers.Contact']);
        return view('ViewSales',compact('sale_overview'));
    }

    //special function to return viewsalesdetails view
    public function viewSalesDetails($id)
    {
        //
        $sales_overview = Sales_Overview::join('customers','customers.id','=','sales_overviews.Customer_Id')
                                    ->where('sales_overviews.id',$id)
                                    ->get(['sales_overviews.*','customers.Customer_Name','customers.Contact']);

        $sales_detail = Sales_Details::join('products','products.id','=','sales_details.Sales_Product')
                                    ->where('sales_details.Sales_Id',$id)
                                    ->get(['sales_details.*','products.Name']);
        // return $sales_detail;
        return view('ViewSalesDetail',compact('sales_overview','sales_detail'));
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
        $sale_over = new Sales_Overview;
        $sale_over->Date_Of_Sale = $request->input('Date_Of_Sale');
        $sale_over->Customer_Id = $request->Customer_Id;
        $sale_over->Total_Products = count($request->SalesProduct);
        $sale_over->Total_SubTotal = $request->TotalSubTotal;
        $sale_over->Total_Tax_Amount = $request->TotalTaxAmount;
        $sale_over->Discount_Per = $request->DiscountPer;
        $sale_over->Discount_Amount = $request->DiscountAmount;
        $sale_over->Total_Amount = $request->TotalAmount;
        $sale_over->Payment_Method = $request->Payment_Radio;
        $sale_over->Amount_Paid = $request->Amount_Paid;
        $sale_over->Returning_Change = $request->Returning_Change;
        $sale_over->Card_BankName = $request->Card_Details_BankName;
        $sale_over->Card_OwnerName = $request->Card_Details_Name;
        $sale_over->Card_Number = $request->Card_Details_Number;
        $sale_over->UPI_WalletName = $request->UPI_Details_WalletName;
        $sale_over->UPI_TransactionId = $request->UPI_Details_TransactionId;

        $sale_over->save();//store above data in sales_overviews table
        $no_of_products = count($request->SalesProduct);//count the total no of products to run for loop as many times 
        $insert_id = $sale_over->id;//get the insert id of above data as foreign key in sale_detail table

        for($i=0; $i<intval($no_of_products); $i++)
        {
            $sale_det = new Sales_Details;
            $sale_det->Sales_Id = $insert_id;
            $sale_det->Sales_Product = $request->SalesProduct[$i];
            $sale_det->Sales_Quantity = $request->SalesQuantity[$i];
            $sale_det->Sales_Price = $request->SalesPrice[$i];
            $sale_det->SalesTaxSlab = $request->SalesTaxSlab[$i];
            $sale_det->SalesTaxAmount = $request->SalesTaxAmount[$i];
            $sale_det->SalesSubTotal = $request->SalesSubTotal[$i];
            $sale_det->save();

            // $pro = Product::find($request->SalesProduct[$i]);
            // $pro->Quantity -= $request->SalesQuantity[$i];
            // $pro->update();
        }
        return redirect()->back()->with('status','Sale Added Successfully');
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
        $sales_overview = Sales_Overview::where('sales_overviews.id',$id)
                                        ->get();

        $sales_detail = Sales_Details::join('products','products.id','=','sales_details.Sales_Product')
                                    ->where('sales_details.Sales_Id',$id)
                                    ->get(['sales_details.*','products.Name']);

        $cust = Customer::select('id','Customer_Name','Contact')->get();

        $pro = Product::select('id','Name','MRP','TaxSlab')->get();
        // print_r($sales_overview .'\n-----------------------------'. $sales_detail);return false;
        return view('EditSales',compact('sales_overview','sales_detail','cust','pro'));
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
        // return $request->all();
        $sale_over = Sales_Overview::find($id);
        $sale_over->Date_Of_Sale = $request->input('Date_Of_Sale');
        $sale_over->Customer_Id = $request->Customer_Id;
        $sale_over->Total_Products = count($request->SalesProduct);
        $sale_over->Total_SubTotal = $request->TotalSubTotal;
        $sale_over->Total_Tax_Amount = $request->TotalTaxAmount;
        $sale_over->Discount_Per = $request->DiscountPer;
        $sale_over->Discount_Amount = $request->DiscountAmount;
        $sale_over->Total_Amount = $request->TotalAmount;
        $sale_over->Payment_Method = $request->Payment_Radio;
        $sale_over->Amount_Paid = $request->Amount_Paid;
        $sale_over->Returning_Change = $request->Returning_Change;
        $sale_over->Card_BankName = $request->Card_Details_BankName;
        $sale_over->Card_OwnerName = $request->Card_Details_Name;
        $sale_over->Card_Number = $request->Card_Details_Number;
        $sale_over->UPI_WalletName = $request->UPI_Details_WalletName;
        $sale_over->UPI_TransactionId = $request->UPI_Details_TransactionId;

        $sale_over->save();//store above data in sales_overviews table
        $no_of_products = count($request->SalesProduct);//count the total no of products to run for loop as many times 
        $insert_id = $sale_over->id;//get the insert id of above data as foreign key in sale_detail table

        for($i=0; $i<intval($no_of_products); $i++)
        {
            if($request->RowId[$i]==0)
            {
                $sale_det = new Sales_Details;
                $sale_det->Sales_Id = $insert_id;
                $sale_det->Sales_Product = $request->SalesProduct[$i];
                $sale_det->Sales_Quantity = $request->SalesQuantity[$i];
                $sale_det->Sales_Price = $request->SalesPrice[$i];
                $sale_det->SalesTaxSlab = $request->SalesTaxSlab[$i];
                $sale_det->SalesTaxAmount = $request->SalesTaxAmount[$i];
                $sale_det->SalesSubTotal = $request->SalesSubTotal[$i];
                $sale_det->save();
            }
            else
            {
                $sale = Sales_Details::find($request->RowId[$i]);
                $sale->Sales_Id = $insert_id;
                $sale->Sales_Product = $request->SalesProduct[$i];
                $sale->Sales_Quantity = $request->SalesQuantity[$i];
                $sale->Sales_Price = $request->SalesPrice[$i];
                $sale->SalesTaxSlab = $request->SalesTaxSlab[$i];
                $sale->SalesTaxAmount = $request->SalesTaxAmount[$i];
                $sale->SalesSubTotal = $request->SalesSubTotal[$i];
                $sale->update();
            }

            // $pro = Product::find($request->SalesProduct[$i]);
            // $pro->Quantity -= $request->SalesQuantity[$i];
            // $pro->update();
        }
        return redirect('ViewSales')->with('status','Sale Added Successfully');
    }

    //delete sales row from edit sales
    public function DeleteSalesDetails($id)
    {
        $sal_det = Sales_Details::find($id);
        $sal_det->delete();
        if($sal_det)
        {
            return response()->json([
                'status'=>'200',
                'message'=>'Row Deleted Successfully'
            ]);
        }
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
        $salo = Sales_Overview::find($id)->delete();

        $salD = Sales_Details::where('sales_details.Sales_Id',$id)->delete();
        // echo($pur.'\n'.$purD);

        if($salo && $salD)
        {
            return redirect()->back()->with('status','Sale deleted successfully');
        }
        else{
            return redirect()->back()->with('error','Sale not deleted successfully');
        }
    }
}
