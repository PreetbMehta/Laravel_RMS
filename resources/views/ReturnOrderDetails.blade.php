@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Order Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><a href="#">Return_Order_Details</a></li>
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
                        <label for="Date_Of_return">
                            Date Of Return:
                            <span style="color: red">*</span>
                        </label>
                        <input type="date" name="Date_Of_return" id="Date_Of_return" class="form-control" value="{{$ret_overview[0]->Date_Of_Return}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Return_No">Return Order No.:</label>
                        <input type="text" class="form-control" id="Return_No" name="Return_No" value="{{$ret_overview[0]->id}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Customer_Id">
                            Customer Name:
                            <span style="color: red">*</span>
                        </label>
                        <input type="text" class="form-control" name="Customer_Name" id="Customer_Name" value="{{$ret_overview[0]->Customer_Name}}" readonly>
                        <input type="hidden" name="Customer_Id" id="Customer_Id" class="form-control" value="{{$ret_overview[0]->Customer_Id}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Contact">
                            Contact No:
                        </label>
                        <input type="text" name="Contact" id="Contact" class="form-control" value="{{$ret_overview[0]->Contact}}" readonly>
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
                            @for ($i=0; $i< count($ret_detail); $i++)    
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$ret_detail[$i]->Name}}({{$ret_detail[$i]->Product_Id}})</td>
                                    <td style="width: 120px">{{$ret_detail[$i]->Quantity}}</td>
                                    <td style="width: 120px">{{$ret_detail[$i]->Price}}</td>
                                    <td style="width: 120px">{{$ret_detail[$i]->Tax_Slab}}</td>
                                    <td style="width: 120px">{{$ret_detail[$i]->Tax_Amount}}</td>
                                    <td style="width: 200px">{{$ret_detail[$i]->Sub_Total}}</td>
                                </tr>
                            @endfor
                            <tr>
                                <td colspan="5">
                                    <label style=" float: right;">Total SubTotal:</label>
                                </td>
                                <td colspan="2">{{$ret_overview[0]->Total_SubTotal}}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <label style="float: right;">Total Tax Amount:</label>
                                </td>
                                <td colspan="2">{{$ret_overview[0]->Total_TaxAmount}}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <label style="float: right">Discount:</label>
                                </td>
                                <td colspan="2">
                                    <label>Discount Percentage:</label>
                                    <div style="display: inline-block">{{$ret_overview[0]->Discount_Per}}</div>
                                    <br>
                                    <label>Discount Amount:</label>
                                    <div style="display: inline-block">{{$ret_overview[0]->Discount_Amount}}</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <label style="float: right;">Total Amount:</label>
                                </td>
                                <td colspan="2">{{$ret_overview[0]->Amount_Returned}}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div style="float: right">
                                        <label>Return Method:</label>
                                    </div>
                                </td>
                                <td colspan="2"><div id="Pay_meth">{{$ret_overview[0]->Return_Method}}</div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection