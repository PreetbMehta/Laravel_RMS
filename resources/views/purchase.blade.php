@extends('layouts.admin')

@section('content')

    <!-- JQuery DataTables css-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    {{-- Session Message --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('status') }}
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

    <!-- Add Purchase ----------------------------------------------------------------------------->
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
                <div class="row">
                    <div class="col-md-4">
                        <label for="Date_Of_Purchase">
                            <b>1)Date Of Purchase:</b>
                        </label>
                        <input type="date" name="Date_Of_Purchase" id="Date_Of_Purchase" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="Supplier_Name">
                            <b>2) Supplier Name:</b>
                        </label>
                        {{-- <input type="text" name="Supplier_Name" id="Supplier_Name" class="form-control" required> --}}
                        <select name="Supplier_Name" id="Supplier_Name" class="form-control">
                            <option>Open this select menu</option>
                            @foreach ($Show_supp as $show_supp)
                                <option value="{{ $show_supp->Supplier_Name }}" data-brand="{{ $show_supp->Brand_Name }}">
                                    {{ $show_supp->Supplier_Name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="Brand_Name">
                            <b>3)Brand Name:</b>
                        </label>
                        <input type="text" name="Brand_Name" id="Brand_Name" class="form-control" required readonly>
                        {{-- <select name="Brand_Name" id="Brand_Name" class="form-control">
                                <option value="">Open this select menu</option>
                                @foreach ($Show_supp as $show_supp)
                                    <option value="{{$show_supp->Brand_Name}}">{{$show_supp->Brand_Name}}</option>
                                @endforeach
                            </select> --}}
                    </div>
                </div>
                {{-- select product to purchase --}}
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="GST_Amount">
                            <b>5) GST_Amount:</b>
                        </label>
                        <input type="number" min="1" step="1" name="GST_Amount" id="GST_Amount" class="form-control"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="Total_Bill_Amount">
                            <b>6)Total Bill Amount:</b>
                        </label>
                        <input type="number" name="Total_Bill_Amount" id="Total_Bill_Amount" class="form-control" required
                            readonly>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="Submit" class="btn btn-success btn-lg">Add Purchase</button>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </div>
    <!-- /.content -->

    {{-- Scripts-------------------------------------------------------------------------- --}}
    {{-- script to use moment.js method to get by default today's date --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js">
    </script>
    <!-- JQuery DataTable JS-->
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <!--JQUERY DATATABLE SCRIPT-->
    <script>
        $(document).ready(function() {
            $('#Purchase-Table').DataTable();
        });

        // using moment.js method to get by default today's date
        var today = moment().format('YYYY-MM-DD');
        $('#Date_Of_Purchase').val(today);

        //fetching brand name by default on the basis of supplier name
        $("#Supplier_Name").on('change', function() {
            var selecteBrand = $(this).find(":selected").data("brand");
            $("#Brand_Name").val(selecteBrand);
        });
    </script>
@endsection
