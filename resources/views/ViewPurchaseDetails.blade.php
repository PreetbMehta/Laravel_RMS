@extends('layouts.admin')

@section('content')
    <!-- JQuery DataTables css-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Purchase</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Purchase</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!--card-->
    <div class="content">
        <div class="card">
            {{-- <div class="card-header">
                <h3 class="mb-0">View Purchase</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div> --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="Purchase_No">1)Purchase No.:</label>
                        <input type="text" name="Purchase_No" id="Purchase_No" class="form-control" value="{{$id}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Supplier_Name">2)Supplier Name:</label>
                        <input type="text" name="Supplier_Name" id="Supplier_Name" class="form-control" value="{{$sup[0]->Supplier_Name}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Brand_Name">2)Brand Name:</label>
                        <input type="text" name="Brand_Name" id="Brand_Name" class="form-control" value="{{$sup[0]->Brand_Name}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="Date_Of_Purchase">3)Date of Purchase:</label>
                        <input type="text" name="Date_Of_Purchase" id="Date_Of_Purchase" class="form-control" value="{{$pur_Overview[0]->Date_Of_Purchase}}" readonly>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mt-5 dtr-inline" id="ViewPurDetailsTable">
                        <thead>
                            <tr>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">Product</th>
                                <th style="text-align: center" class="w-5">Price</th>
                                <th style="text-align: center" class="w-5">Quantity Ordered</th>
                                <th style="text-align: center" class="w-5">Tax Slab</th>
                                <th style="text-align: center" class="w-5">Tax Amount</th>
                                <th style="text-align: center" class="w-5">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i=0; $i<$countSDet; $i++)
                                <tr>
                                    <td style="text-align: center">{{$i+1}}</td>
                                    <td style="text-align: center">{{$pro[$i]->Name}}({{$pro[$i]->Reference_Id}})</td>
                                    <td style="text-align: center">{{$showDetails[$i]->Price}}</td>
                                    <td style="text-align: center">{{$showDetails[$i]->Quantity}}</td>
                                    <td style="text-align: center">{{$showDetails[$i]->Tax_Slab}}</td>
                                    <td style="text-align: center">{{$showDetails[$i]->Tax_Amount}}</td>
                                    <td style="text-align: center">{{$showDetails[$i]->Sub_Total}}</td>
                                </tr>
                            @endfor
                            <tr>
                                <td colspan="6" class="text-right">Sub Total:</td>
                                <td style="text-align: center"> {{$pur_Overview[0]->Sub_Total}}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">Tax Total:</td>
                                <td style="text-align: center"> {{$pur_Overview[0]->Total_Tax_Amount}}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">Total Discount:</td>
                                <td style="text-align: center"> {{$pur_Overview[0]->Discount_Amount}}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">Grand Total:</td>
                                <td style="text-align: center"> {{$pur_Overview[0]->Total_Amount}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
