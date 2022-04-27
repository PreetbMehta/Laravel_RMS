<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracker_Table;
use App\Models\Customer;

class CreditsController extends Controller
{
    //authentication
    public function __construct()
    {
        $this->middleware('auth');
    }
    //call index page with data
    public function index()
    {
        $Total_Credit = Tracker_Table::sum('Amount');

        $cust_credit = Tracker_Table::join('customers','customers.id','=','tracker_tables.Cust_Id')
                                    ->selectRaw('sum(Amount) as Credit,Cust_Id as cust_id,Customer_Name as Customer,Contact as Contact')
                                    ->groupBy('cust_id','Customer','Contact')
                                    ->get();

        $customer = Customer::select('id','Customer_Name','Contact')->get();

        return view('credits',compact('Total_Credit','cust_credit','customer'));
    }

    public function acceptPayment(Request $request)
    {
        // return $request->all();
        $payment = new Tracker_Table;
        $payment->Date = $request->Date;
        $payment->Cust_Id = $request->Customer_Details;
        $payment->Amount = -$request->Amount;
        $payment->type = '1';
        $payment->Payment_Method = $request->Payment_Method;
        $payment->Note = $request->Note;
        $payment->Status = '1';
        $payment->save();
        return redirect('credits')->with('status','Payment Added Successfully');
    }

    public function addCredit(Request $request)
    {
        // return $request->all();
        $payment = new Tracker_Table;
        $payment->Date = $request->Credit_Date;
        $payment->Cust_Id = $request->Credit_Customer_Details;
        $payment->Amount = $request->Credit_Amount;
        $payment->type = '0';
        $payment->Payment_Method = 'Credit';
        $payment->Note = $request->Credit_Note;
        $payment->save();
        return redirect('credits')->with('status','Payment Added Successfully');
    }

    public function viewStatement($id)
    {
        $state = Tracker_Table::select('Date','Cust_Id','Amount','Payment_Method','Note','Sales_Id','Return_Id')
                                ->where('Cust_Id','=',$id)
                                ->get();

        $cust = Customer::select('id','Customer_Name','Contact')
                        ->where('id',$id)
                        ->get();
        
        $credit = Tracker_Table::where('Cust_Id',$id)
                                ->sum('Amount');
        
        return view('viewStatement',compact('state','cust','credit'));
    }
}
