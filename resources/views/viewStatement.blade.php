@extends('layouts.admin')

@section('content')
     <!-- Content Header (Page header) -->
     <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Credits</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Credits</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3>Statement</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="Cust_Name">Customer_Name:</label>
                        <input type="text" name="Cust_Name" id="Cust_Name" class="form-control" value="{{$cust[0]->Customer_Name}}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="Cust_Contact">Contact:</label>
                        <input type="text" name="Cust_Contact" id="Cust_Contact" class="form-control" value="{{$cust[0]->Contact}}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="Total_Credit">Total Credit Left:</label>
                        <input type="text" name="Total_Credit" id="Total_Credit" class="form-control bg-danger" value="{{- $credit}}" readonly>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped dataTable dtr-inline">
                        <thead>
                            <th>#</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Payment_Type</th>
                            <th>Note</th>
                        </thead>
                        <tbody>
                            @php
                                $i=1
                            @endphp
                            @foreach ($state as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$item->Date}}</td>
                                    <td>
                                        @if ($item->Amount < 0)
                                            <i class="bg-success p-2"> {{abs($item->Amount)}} </i>
                                            @else
                                                <i class="bg-danger p-2"> {{$item->Amount}} </i>
                                        @endif
                                    </td>
                                    <td>{{$item->Payment_Method}}</td>
                                    <td>
                                        @if ($item->Note == '')
                                            Nothing To Show
                                            @else {{$item->Note}} 
                                                @if($item->Sales_Id)
                                                    (sales id: {{$item->Sales_Id}})
                                                @endif
                                                @if ($item->Return_Id)
                                                    (Return id: {{$item->Return_Id}})
                                                @endif
                                        @endif
                                    </td>
                                </tr>
                                @php $i++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection