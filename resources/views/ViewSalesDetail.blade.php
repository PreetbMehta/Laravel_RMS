@extends('layouts.admin')

@section('content')

    <style>
        #Sales_Table th,td{
            text-align: center;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Sales</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><a href="#">View Sales</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="card">
            <div class="card-body">
                <!--first row of info -->
                <div class="row">
                    <div class="col-md-3">
                        <label for="Date_Of_Sale">
                            Date Of Sale:
                            <span style="color: red">*</span>
                        </label>
                        <input type="date" name="Date_Of_Sale" id="Date_Of_Sale" class="form-control" value="{{$sales_overview[0]->Date_Of_Sale}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Sale_No">Sale No.:</label>
                        <input type="text" class="form-control" id="Sale_No" name="Sale_No" value="{{$sales_overview[0]->id}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Customer_Id">
                            Customer Name:
                            <span style="color: red">*</span>
                        </label>
                        <input type="text" name="Customer_Id" id="Customer_Id" class="form-control" value="{{$sales_overview[0]->Customer_Name}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Contact">
                            Contact No:
                        </label>
                        <input type="text" name="Contact" id="Contact" class="form-control" value="{{$sales_overview[0]->Contact}}" readonly>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- table for adding ordered products -->
                    <table class="table table-striped mt-4 dtr-inline" id="Sales_Table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product <span style="color: red">*</span></th>
                                <th style="width: 100px">Quantity <span style="color: red">*</span></th>
                                <th style="width: 100px">MRP <span style="color: red">*</span></th>
                                <th style="width: 100px">Tax Slab(%)</th>
                                <th style="width: 100px">Tax Amount</th>
                                <th style="width: 100px">SubTotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i=0; $i<$sales_overview[0]->Total_Products; $i++)    
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$sales_detail[$i]->Name}}({{$sales_detail[$i]->Sales_Product}})</td>
                                    <td style="width: 120px">{{$sales_detail[$i]->Sales_Quantity}}</td>
                                    <td style="width: 120px">{{$sales_detail[$i]->Sales_Price}}</td>
                                    <td style="width: 120px">{{$sales_detail[$i]->SalesTaxSlab}}</td>
                                    <td style="width: 120px">{{$sales_detail[$i]->SalesTaxAmount}}</td>
                                    <td style="width: 200px">{{$sales_detail[$i]->SalesSubTotal}}</td>
                                </tr>
                            @endfor
                            <tr>
                                <td colspan="5">
                                    <label style=" float: right;">Total SubTotal:</label>
                                </td>
                                <td colspan="2">{{$sales_overview[0]->Total_SubTotal}}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <label style="float: right;">Total Tax Amount:</label>
                                </td>
                                <td colspan="2">{{$sales_overview[0]->Total_Tax_Amount}}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <label style="float: right">Discount:</label>
                                </td>
                                <td colspan="2">
                                    <label>Discount Percentage:</label>
                                    <div style="display: inline-block">{{$sales_overview[0]->Discount_Per}}</div>
                                    <br>
                                    <label>Discount Amount:</label>
                                    <div style="display: inline-block">{{$sales_overview[0]->Discount_Amount}}</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <label style="float: right;">Total Amount:</label>
                                </td>
                                <td colspan="2">{{$sales_overview[0]->Total_Amount}}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div style="float: right">
                                        <label>Payment Method:</label>
                                        <div style="display: inline-block" id="Pay_meth">{{$sales_overview[0]->Payment_Method}}</div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="Cash_Details" style="display: none">
                                        <label>Amount Paid:</label>
                                        <div style="display: inline-block">{{$sales_overview[0]->Amount_Paid}}</div>
                                        <br>
                                        <label>Returned Change:</label>
                                        <div style="display: inline-block">{{$sales_overview[0]->Returning_Change}}</div>
                                    </div>
                                    <div class="Card_Details" style="display: none">
                                        <label>Card Owner Name:</label>
                                        <div style="display: inline-block">{{$sales_overview[0]->Card_OwnerName}}</div>
                                        <br>
                                        <label>Bank Name:</label>
                                        <div style="display: inline-block">{{$sales_overview[0]->Card_BankName}}</div>
                                        <br>
                                        <label>Card Number:</label>
                                        <div style="display: inline-block">{{$sales_overview[0]->Card_Number}}</div>
                                    </div>
                                    <div class="UPI_Details" style="display: none">
                                        <label for="">UPI Wallet:</label>
                                        <div style="display: inline-block">{{$sales_overview[0]->UPI_WalletName}}</div>
                                        <br>
                                        <label for="">UPI Transaction ID:</label>
                                        <div style="display: inline-block">{{$sales_overview[0]->UPI_TransactionId}}</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="{{route('invoice',$sales_overview[0]->id)}}" class="btn btn-primary float-right">Print Invoice</a>
            </div>
        </div>
    </div>

    <script>
        // console.log($('#Pay_meth').text());
        var pay_meth = $('#Pay_meth').text();
        if(pay_meth=='Cash')
        {
            $('.Cash_Details').css('display','block');
            $('.Card_Details').css('display','none');
            $('.UPI_Details').css('display','none');
        }
        else if(pay_meth=='Card')
        {
            $('.Card_Details').css('display','block');
            $('.Cash_Details').css('display','none');
            $('.UPI_Details').css('display','none');
        }
        else if(pay_meth == 'UPI')
        {
            $('.UPI_Details').css('display','block');
            $('.Cash_Details').css('display','none');
            $('.Card_Details').css('display','none');
        }
        else
        {
            $('.UPI_Details').css('display','none');
            $('.Cash_Details').css('display','none');
            $('.Card_Details').css('display','none');
        }
    </script>
@endsection