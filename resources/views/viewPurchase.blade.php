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
                        <li class="breadcrumb-item active"><a href={{ route('viewPurchase.index') }}>View Purchase</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

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
                <table class="table table-bordered table-striped" id="ViewPurTable">
                    <thead>
                        <tr>
                            <th style="text-align: center">Id</th>
                            <th style="text-align:center">Date Of Purchase</th>
                            <th style="text-align: center">Supplier Name</th>
                            <th style="text-align: center">Brand Name</th>
                            <th style="text-align: center; width:20px">Total Products</th>
                            <th style="text-align: center">SubTotal</th>
                            <th style="text-align: center">Total Tax Amount</th>
                            <th style="text-align: center">Total Discount</th>
                            <th style="text-align: center">Total Amount</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        @foreach ($showPur as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->Date_Of_Purchase }}</td>
                                <td>{{ $item->Supplier_Name }}<input type="hidden" value="{{$item->Supplier_Id}}" id="sup_id"></td>
                                <td>{{ $item->Brand_Name }}</td>
                                <td>{{ $item->Total_Products }}</td>
                                <td>{{ $item->Sub_Total }}</td>
                                <td>{{ $item->Total_Tax_Amount }}</td>
                                <td>{{ $item->Discount_Amount }}</td>
                                <td>{{ $item->Total_Amount }}</td>
                                <td style="display:flex">
                                    <a href="ViewPurchaseDetails/{{ $item->id }}"
                                        class="btn btn-primary btn-l m-2 viewPurchase" data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="EditPurchase/{{$item->id}}" class="btn btn-primary btn-l m-2 editPurchase" data-id="{{ $item->id }}" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ url('viewPurchase/' . $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-l m-2 delPurchase" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></button>
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
        $(document).ready(function() {
            $('#ViewPurTable').DataTable({
                order: [
                    ['0', 'desc']
                ]
            });
            // //initialise select 2
            // $('.select2').select2();
            
            // //Initialize Select2 Elements
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4' 
            // });
        });

       
    </script>
@endsection
