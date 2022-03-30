@extends('layouts.admin')

@section('content')

    <style>
        #ViewSalesTable th,td{
            text-align: center;
            overflow: hidden;
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
                <table class="table table-bordered table-striped" id="ViewSalesTable">
                    <thead>
                        <th>id</th>
                        <th>Date of sale</th>
                        <th>Customer Name</th>
                        <th>Contact No</th>
                        <th>Total Products</th>
                        <th>TaxAmount</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($sale_overview as $so)  
                            <tr>
                                <td>{{$so->id}}</td>
                                <td>{{$so->Date_Of_Sale}}</td>
                                <td>{{$so->Customer_Name}}</td>
                                <td>{{$so->Contact}}</td>
                                <td>{{$so->Total_Products}}</td>
                                <td>{{$so->Total_Tax_Amount}}</td>
                                <td>{{$so->Discount_Amount}}</td>
                                <td>{{$so->Total_Amount}}</td>
                                <td>{{$so->Payment_Method}}</td>
                                <td style="display: flex">
                                    <a href="{{url("viewSales/".$so->id)}}" class="btn btn-primary m-2" data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{url('sales/'.$so->id.'/edit')}}" class="btn btn-primary m-2" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{url('sales/'.$so->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-l m-2" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#ViewSalesTable').DataTable({
                order:['0','desc']
            });
        });
    </script>
@endsection