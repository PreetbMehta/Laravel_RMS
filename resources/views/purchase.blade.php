@extends('layouts.admin')

@section('content')

    <!-- JQuery DataTables css-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    {{-- Session Message --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show">
            {{session('status')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchases</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Purchases</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Add Purchase --------------------------------------------------------------------------------->
    <div class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3>Add Purchase</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action={{ route('purchase.store') }} method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Date_Of_Purchase">
                                <b>1)Date Of Purchase:</b>
                            </label>
                            <input type="date" name="Date_Of_Purchase" id="Date_Of_Purchase" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="Supplier_Name">
                                <b>2) Supplier Name:</b>
                            </label>
                            <input type="text" name="Supplier_Name" id="Supplier_Name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Supplier_Id">
                                <b>3)Supplier Id:</b>
                            </label>
                            <input type="text" name="Supplier_Id" id="Supplier_Id" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Quantity">
                                <b>4) Quantity:</b>
                            </label>
                            <input type="text" name="Quantity" id="Quantity" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Total_Bill_Amount">
                                <b>5)Total Bill Amount:</b>
                            </label>
                            <input type="text" name="Total_Bill_Amount" id="Total_Bill_Amount" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="GST_Amount">
                                <b>6) GST_Amount:</b>
                            </label>
                            <input type="text" name="GST_Amount" id="GST_Amount" class="form-control" required>
                        </div>
                    </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="Submit" class="btn btn-success btn-lg">Add Purchase</button>
            </div>
            <!-- /.card-footer-->
            </form>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.content -->

    <!-- /.content-header -->
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Purchase List</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="Purchase-Table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Purchase_Id</th>
                            <th>Date_Of_Purchase</th>
                            <th>Supplier_id</th>
                            <th>Supplier_name</th>
                            <th>Quantity</th>
                            <th>Bill_Amount</th>
                            <th>GST_Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @foreach ($showPurchase as $pur_item)
                        <tbody>
                            <tr>
                                <td>{{ $pur_item->id }}</td>
                                <td>{{ $pur_item->Date_Of_Purchase }}</td>
                                <td>{{ $pur_item->Supplier_Id }}</td>
                                <td>{{ $pur_item->Supplier_Name }}</td>
                                <td>{{ $pur_item->Quantity }}</td>
                                <td>{{ $pur_item->Total_Bill_Amount }}</td>
                                <td>{{ $pur_item->GST_Amount }}</td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="#" data-toggle="modal"
                                        data-target="#EditPurchaseModal{{ $pur_item->id }}">
                                        <span class="btn-label"><i class="fa fa-edit"></i></span>
                                        Edit
                                    </a>
                                    <form action="{{ url('purchase/' . $pur_item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            <span class="btn-label"><i class="fa fa-trash"></i></span>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        {{-- #EditPurchaseModal ---------------------------------------------------------------------------- --}}
                        <div class="modal" tabindex="-1" id="EditPurchaseModal{{ $pur_item->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Supplier</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{url('purchase/'.$pur_item->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Date_Of_Purchase">
                                                        <b>1)Date Of Purchase:</b>
                                                    </label>
                                                    <input type="date" name="Date_Of_Purchase" id="Date_Of_Purchase" value="{{$pur_item->Date_Of_Purchase}}" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Supplier_Name">
                                                        <b>2) Supplier Name:</b>
                                                    </label>
                                                    <input type="text" name="Supplier_Name" id="Supplier_Name" value="{{$pur_item->Supplier_Name}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Supplier_Id">
                                                        <b>3)Supplier Id:</b>
                                                    </label>
                                                    <input type="text" name="Supplier_Id" id="Supplier_Id" value="{{$pur_item->Supplier_Id}}" class="form-control" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Quantity">
                                                        <b>4) Quantity:</b>
                                                    </label>
                                                    <input type="text" name="Quantity" id="Quantity" value="{{$pur_item->Quantity}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Total_Bill_Amount">
                                                        <b>5)Total Bill Amount:</b>
                                                    </label>
                                                    <input type="text" name="Total_Bill_Amount" id="Total_Bill_Amount" value="{{$pur_item->Total_Bill_Amount}}" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="GST_Amount">
                                                        <b>6) GST_Amount:</b>
                                                    </label>
                                                    <input type="text" name="GST_Amount" id="GST_Amount" value="{{$pur_item->GST_Amount}}" class="form-control" required>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" id="EditChanges" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{-- Scripts-------------------------------------------------------------------------- --}}

    <!-- JQuery DataTable JS-->
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <!--JQUERY DATATABLE SCRIPT-->
    <script>
        $(document).ready(function() {
            $('#Purchase-Table').DataTable();
        });
    </script>
@endsection
