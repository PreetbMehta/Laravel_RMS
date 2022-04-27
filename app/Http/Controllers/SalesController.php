<?php

namespace App\Http\Controllers;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales_Overview;
use App\Models\Sales_Details;
use App\Models\Tracker_Table;
use App\Models\Product_Tracker;
use App\Models\Settings;
use DB;

use Illuminate\Http\Request;

class SalesController extends Controller
{   //authenticate
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
        $cust = Customer::all()
                        ->where('Active_Status','=','1');
        $pro = Product::join('product_trackers','product_trackers.Product_Id','=','products.id')
                        ->groupBy('products.id','Name','TaxSlab','MRP','Reference_Id')
                        ->select('products.id','Name','TaxSlab','MRP','Reference_Id', DB::raw('SUM(product_trackers.Quantity) as QuantityLeft'))
                        ->where('Active_Status','=','1')
                        ->get();
        // return ['cust'=>$cust,'pro'=>$pro];
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
        //inserting sales overview for sales bills-----------------------------------------
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

        //inserting sales details in sales bills----------------------------------------
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

            //inserting record in product_Trackers table
            $pro_track = new Product_Tracker;
            $pro_track->Date = $request->input('Date_Of_Sale');
            $pro_track->Product_Id = $request->SalesProduct[$i];
            $pro_track->Quantity = -$request->SalesQuantity[$i];
            $pro_track->Type = '0';
            $pro_track->Sales_Id = $insert_id;
            $pro_track->save();
        }
        // print_r($sale_over->Payment_Method);
        
        //inserting in tracker table for every sales
        if($sale_over->Payment_Method == 'Credit')
        {
            $tracker_table = new Tracker_Table;
            $tracker_table->Date = $sale_over->Date_Of_Sale;
            $tracker_table->Cust_Id = $sale_over->Customer_Id;
            $tracker_table->Sales_Id = $insert_id;
            $tracker_table->Amount = $sale_over->Total_Amount;
            $tracker_table->Type = '0';
            $tracker_table->Payment_Method = $sale_over->Payment_Method;
            $tracker_table->Status = '0';
            $tracker_table->Note = $request->Notes;
            $tracker_table->save();
        }
        else if($sale_over->Payment_Method == 'Cash'||$sale_over->Payment_Method == 'Card'||$sale_over->Payment_Method == 'UPI')
        {
            //inserting for type=0 entry on sales
            $tracker_table = new Tracker_Table;
            $tracker_table->Date = $sale_over->Date_Of_Sale;
            $tracker_table->Cust_Id = $sale_over->Customer_Id;
            $tracker_table->Sales_Id = $insert_id;
            $tracker_table->Amount = $sale_over->Total_Amount;
            $tracker_table->Type = '0';
            $tracker_table->Payment_Method = 'Bill Generate';
            $tracker_table->Status = '0';
            $tracker_table->Note = $request->Notes;
            $tracker_table->save();

            //inserting for type-1 entry on sales
            $tracker_table = new Tracker_Table;
            $tracker_table->Date = $sale_over->Date_Of_Sale;
            $tracker_table->Cust_Id = $sale_over->Customer_Id;
            $tracker_table->Sales_Id = $insert_id;
            $tracker_table->Amount = -$sale_over->Total_Amount;
            $tracker_table->Type = '1';
            $tracker_table->Payment_Method = $sale_over->Payment_Method;
            $tracker_table->Status = '0';
            $tracker_table->Note = $request->Notes;
            $tracker_table->save();
        }

        if($sale_over && $sale_det && $tracker_table && $pro_track)
        {
            return redirect()->route('invoice',$sale_over->id)->with('status','Sale Added Successfully');
        }
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

        $cust = Customer::select('id','Customer_Name','Contact')
                        ->where('Active_Status','=','1')
                        ->get();

        $pro = Product::select('id','Name','MRP','TaxSlab')
                        ->where('Active_Status','=','1')
                        ->get();
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

        $sale_over->update();//store above data in sales_overviews table
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

                //inserting record in product_Trackers table
                $pro_track = new Product_Tracker;
                $pro_track->Date = $request->input('Date_Of_Sale');
                $pro_track->Product_Id = $request->SalesProduct[$i];
                $pro_track->Quantity = -$request->SalesQuantity[$i];
                $pro_track->Type = '0';
                $pro_track->Sales_Id = $insert_id;
                $pro_track->save();
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

                //adding record to product_trackers table
                $pro_track = Product_Tracker::where('Sales_Id','=',$insert_id)
                                            ->where('Product_Id','=',$request->OldProduct[$i])
                                            ->update(['Date'=>$request->input('Date_Of_Sale'),'Product_Id'=>$request->SalesProduct[$i],'Quantity'=>-$request->SalesQuantity[$i] ]);
            }

            // $pro = Product::find($request->SalesProduct[$i]);
            // $pro->Quantity -= $request->SalesQuantity[$i];
            // $pro->update();
        }
        //adding entry of tracker_table
        if($request->Payment_Radio == 'Credit')
        {
            $track = Tracker_Table::where('Sales_Id',$id)
                                ->where('Type','0')
                                ->update(['Date'=>$request->Date_Of_Sale,'Payment_Method'=>$request->Payment_Radio,'Amount'=>$request->TotalAmount,'Cust_Id'=>$request->Customer_Id]);

            $tdel = Tracker_Table::where('Sales_Id',$id)
                                ->where('Type','1')
                                ->Delete();
        }
        else
        {
            if($request->Pay_Meth == 'Credit')
            {
                $track1 = Tracker_Table::where('Sales_Id',$id)
                                ->where('Type','0')
                                ->update(['Date'=>$request->Date_Of_Sale,'Payment_Method'=>$request->Payment_Radio,'Amount'=>$request->TotalAmount,'Cust_Id'=>$request->Customer_Id]);

                                
                // $trackAdd = new Tracker_Table;
                // $trackAdd->Date = $request->Date_Of_Sale;
                // $trackAdd->Cust_Id = $request->Customer_Id;
                // $trackAdd->Sales_Id = $id;
                // $trackAdd->Amount = -$request->TotalAmount;
                // $trackAdd->Type = '1';
                // $trackAdd->Payment_Method = $request->Payment_Radio;
                // $trackAdd->save();
            }
            else
            {
                $track1 = Tracker_Table::where('Sales_Id',$id)
                                ->where('Type','0')
                                ->update(['Date'=>$request->Date_Of_Sale,'Payment_Method'=>"EditSale ".$request->Payment_Radio,'Amount'=>$request->TotalAmount,'Cust_Id'=>$request->Customer_Id]);

                $track2 = Tracker_Table::where('Sales_Id',$id)
                                ->where('Type','1')
                                ->update(['Date'=>$request->Date_Of_Sale,'Payment_Method'=>"EditSale ".$request->Payment_Radio,'Cust_Id'=>$request->Customer_Id]);
            }
        }
        return redirect('ViewSales')->with('status','Sale Updated Successfully');
    }

    //delete sales row from edit sales
    public function DeleteSalesDetails($id)
    {
        $sal_det = Sales_Details::find($id);
        $sal_pro = $sal_det->Sales_Product;//get product id from sales_details table row
        $sal_id = $sal_det->Sales_Id;//get sales id from sales_Details table

        $protrack = Product_Tracker::where('Sales_Id','=',$sal_id)
                                    ->where('Product_Id','=',$sal_pro)
                                    ->delete();
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

        $protra = Product_Tracker::where('product_trackers.Sales_Id',$id)->delete();

        if($salo && $salD && $protra)
        {
            return redirect()->back()->with('status','Sale deleted successfully');
        }
        else{
            return redirect()->back()->with('error','Sale not deleted successfully');
        }
    }

    //add new customer while adding sales\making bills
    public function addNewCust(Request $request)
    {
        $cust_new = new Customer;
        $cust_new->Customer_Name = $request->NewCust_Customer_Name;
        $cust_new->Contact = $request->NewCust_Contact;
        $cust_new->Email_Id = $request->NewCust_Email_Id;
        $cust_new->save();
    
            if($cust_new)
            {
                return redirect()->back()->with(['status'=>'New Customer Added Successfully','customer'=>$cust_new->id]);
            }
    }
}
