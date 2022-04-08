@extends('layouts.admin')

@section('content')
    <style>
        #ViewReturnsDetailsTable th,
        td {
            text-align: center;
            overflow: hidden;
        }

    </style>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @if (Session('status'))
        <script>
            swal('Success!', "{{ Session('status') }}", 'success', {
                button: 'OK'
            });
        </script>
    @endif
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Order List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><a href="#">Return Order List</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="ViewReturnsDetailsTable">
                    <thead>
                        <th>#</th>
                        <th>Date of Return</th>
                        <th>Customer Name</th>
                        <th>Sales Id</th>
                        <th>Amount Returned</th>
                        <th>Return Method</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($roList as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->Date_Of_Return }}</td>
                                <td>({{ 'Id: ' . $item->Customer_Id }}) {{ $item->Customer_Name }}</td>
                                <td>{{ $item->Sales_Id }}</td>
                                <td>{{ $item->Amount_Returned }}</td>
                                <td>{{ $item->Return_Method }}</td>
                                <td style="display: flex;">
                                    <a href="{{url('viewReturnOrder/'.$item->id)}}" class="btn btn-info viewReturnOrderDetails" data-bs-toggle="tooltip"
                                        title="View">
                                        <span class="fas fa-eye"></span>
                                    </a>
                                    <form action="{{ url('returnOrder/' . $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger ml-2 Delete" data-bs-toggle="tooltip" title="Delete">
                                            <span class="fas fa-trash"></span>
                                        </button>
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
            $('#ViewReturnsDetailsTable').DataTable();
        });
    </script>
@endsection
