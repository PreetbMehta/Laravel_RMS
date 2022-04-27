<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Sales_Overview;
use App\Models\Purchase_Overview;
use App\Models\ReturnOrder_Overview;
use App\Models\Tracker_Table;
use App\Models\Purchase_Detail;
use App\Models\Product;
use App\Models\Product_Tracker;
use DB;

class ReportsController extends Controller
{
    //making auth middleware active for this router
    public function __construct()
    {
        $this->middleware('auth');
    }

    //SalesReport
    public function SalesReportindex(Request $request)
    {
        if($request->ajax())
        {
            if(!empty($request->fdate))
            {
                $data = Sales_Overview::join('customers','customers.id','=','sales_overviews.Customer_Id')
                ->whereBetween('Date_Of_Sale',[$request->fdate,$request->tdate])  
                ->orderBy("sales_overviews.id","desc")
                ->get(['sales_overviews.id','Date_Of_Sale','Total_Products','Total_Amount','Payment_Method','Customer_Name','Contact']);
                
                return Datatables::of($data)
                ->addIndexColumn()->make(true);
            }
            else
            {
                $data = Sales_Overview::join('customers','customers.id','=','sales_overviews.Customer_Id')  
                ->orderBy("sales_overviews.id","desc")
                ->get(['sales_overviews.id','Date_Of_Sale','Total_Products','Total_Amount','Payment_Method','Customer_Name','Contact']);
                
                return Datatables::of($data)
                ->addIndexColumn()->make(true);
            }
        }
        return view('salesReport');
    }

    // PurchaseReport
    public function PurchaseReportindex(Request $request)
    {
        if($request->ajax())
        {
            if(!empty($request->fdate))
            {
                $data = Purchase_Overview::join('suppliers','suppliers.id','=','purchase_overviews.Supplier_Id')
                ->whereBetween('Date_Of_Purchase',[$request->fdate,$request->tdate])
                ->orderBy("purchase_overviews.id","desc")
                ->get(['purchase_overviews.id','Date_Of_Purchase','Total_Products','Total_Amount','Supplier_Name','Brand_Name']);
                
                return Datatables::of($data)
                ->addIndexColumn()->make(true);
            }
            else
            {
                $data = Purchase_Overview::join('suppliers','suppliers.id','=','purchase_overviews.Supplier_Id')
                ->orderBy("purchase_overviews.id","desc")
                ->get(['purchase_overviews.id','Date_Of_Purchase','Total_Products','Total_Amount','Supplier_Name','Brand_Name']);
                
                return Datatables::of($data)
                ->addIndexColumn()->make(true);
            }
        }
        return view('purchaseReport');
    }

    // ReturnOrdersReport
    public function ReturnOrdersReportindex(Request $request)
    {
        if($request->ajax())
        {
            if(!empty($request->fdate))
            {
                $data = ReturnOrder_Overview::join('customers','customers.id','=','return_order_overviews.Customer_Id')
                ->join('sales_overviews','sales_overviews.id','=','return_order_overviews.Sales_Id')
                ->whereBetween('Date_Of_Return',[$request->fdate,$request->tdate])  
                ->orderBy("return_order_overviews.id","desc")
                ->get(['return_order_overviews.id','Date_Of_Return','Sales_Id','Amount_Returned','Return_Method','Total_Amount','Date_Of_Sale','Customer_Name','Contact']);
                
                return Datatables::of($data)
                ->addIndexColumn()->make(true);
            }
            else
            {
                $data = ReturnOrder_Overview::join('customers','customers.id','=','return_order_overviews.Customer_Id')
                ->join('sales_overviews','sales_overviews.id','=','return_order_overviews.Sales_Id')
                ->orderBy("return_order_overviews.id","desc")
                ->get(['return_order_overviews.id','Date_Of_Return','Sales_Id','Amount_Returned','Return_Method','Total_Amount','Date_Of_Sale','Customer_Name','Contact']);
                
                return Datatables::of($data)
                ->addIndexColumn()->make(true);
            }
        }
        return view('ReturnOrdersReport');
    }

    //PaymentReportindex
    public function PaymentReportindex(Request $request)
    {
        if($request->ajax())
        {
            if(!empty($request->fdate))
            {
                $data = Tracker_Table::join('customers','customers.id','=','tracker_tables.Cust_Id')
                ->whereBetween('Date',[$request->fdate,$request->tdate])
                ->where('Type','=','1')
                ->where('Status','=','1')
                ->orderBy("tracker_tables.id","desc")
                ->get(['tracker_tables.id','Date','Amount','Payment_Method','Note','Customer_Name','Contact']);
                
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Amount',function($row){
                    $val = abs($row->Amount);
                    return $val;
                })
                ->addColumn('Note',function($row){
                    $val = ($row->Note == '')?'Null':$row->Note;
                    return $val;
                })
                ->make(true);
            }
            else
            {
                $data = Tracker_Table::join('customers','customers.id','=','tracker_tables.Cust_Id')
                ->where('Type','=','1')
                ->where('Status','=','1')
                ->orderBy("tracker_tables.id","desc")
                ->get(['tracker_tables.id','Date','Amount','Payment_Method','Note','Customer_Name','Contact']);
                
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Amount',function($row){
                    $val = abs($row->Amount);
                    return $val;
                })
                ->addColumn('Note',function($row){
                    $val = ($row->Note == '')?'Null':$row->Note;
                    return $val;
                })
                ->make(true);
            }
        }
        return view('PaymentReport');
    }

    //PayBackReportindex
    public function PayBackReportindex(Request $request)
    {
        if($request->ajax())
        {
            if(!empty($request->fdate))
            {
                $data = Tracker_Table::join('customers','customers.id','=','tracker_tables.Cust_Id')
                ->whereBetween('Date',[$request->fdate,$request->tdate])
                ->where('Type','=','0')
                ->where('Status','=','2')
                ->orderBy("tracker_tables.id","desc")
                ->get(['tracker_tables.id','Date','Amount','Payment_Method','Note','Sales_Id','Return_Id','Customer_Name','Contact']);
                
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Return_Id',function($row){
                    $val = ($row->Return_Id == '')?'Null':$row->Return_Id;
                    return $val;
                })
                ->make(true);
            }
            else
            {
                $data = Tracker_Table::join('customers','customers.id','=','tracker_tables.Cust_Id')
                ->where('Type','=','0')
                ->where('Status','=','2')
                ->orderBy("tracker_tables.id","desc")
                ->get(['tracker_tables.id','Date','Amount','Payment_Method','Note','Sales_Id','Return_Id','Customer_Name','Contact']);
                
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Amount',function($row){
                    $val = abs($row->Amount);
                    return $val;
                })
                ->addColumn('Return_Id',function($row){
                    $val = ($row->Return_Id == '')?'Null':$row->Return_Id;
                    return $val;
                })
                ->make(true);
            }
        }
        return view('PayBackReport');
    }

    //StockReportindex
    public function StockReportindex(Request $request)
    {
        if($request->ajax())
        {
            $data = Product_Tracker::join('products','products.id','product_trackers.Product_Id')
            ->selectRaw('SUM(product_trackers.Quantity) as Stock_Left,products.Name as Name,product_trackers.Product_Id as Product_Id')
            ->groupBy('Product_Id','Name')
            ->get();

            return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
        }
        return view('stockReport');
    }
}
