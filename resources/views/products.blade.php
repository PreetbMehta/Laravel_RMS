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
                     <h1 class="m-0">Products</h1>
                 </div><!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#">Home</a></li>
                         <li class="breadcrumb-item active">Products</li>
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
                 <h3>Add Product</h3>
 
                 <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                         <i class="fas fa-minus"></i>
                     </button>
                 </div>
             </div>
             <div class="card-body">
                 <form action={{ route('products.store') }} method="POST">
                     @csrf
                     <div class="row">
                         <div class="col-md-6">
                             <label for="Picture">
                                 <b>1)Picture:</b>
                             </label>
                             <input type="date" name="Picture" id="Picture" class="form-control"
                                 required>
                         </div>
                         <div class="col-md-6">
                             <label for="Reference_Id">
                                 <b>2) Reference Id:</b>
                             </label>
                             <input type="text" name="Reference_Id" id="Reference_Id" class="form-control" required>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-8">
                             <label for="Category">
                                 3)Category
                             </label>
                             <input type="select">
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <label for="Cost_Price">
                                 <b>4)Cost Price:</b>
                             </label>
                             <input type="text" name="Cost_Price" id="Cost_Price" class="form-control" required>
                         </div>
                         <div class="col-md-6">
                             <label for="MRP">
                                 <b>5) MRP:</b>
                             </label>
                             <input type="text" name="MRP" id="MRP" class="form-control" required>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <label for="Purchase_no">
                                 <b>6)Purchase no:</b>
                             </label>
                             <input type="text" name="Purchase_no" id="Purchase_no" class="form-control"
                                 required>
                         </div>
                         <div class="col-md-6">
                             <label for="Quantity">
                                 <b>7) Quantity:</b>
                             </label>
                             <input type="text" name="Quantity" id="Quantity" class="form-control" required>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-8">
                             <label for="Short_Desc">
                                 8)Short Description:
                             </label>
                             <textarea name="Short_Desc" id="Short_Desc" cols="30" rows="10"></textarea>
                         </div>
                     </div>
             </div>
             <!-- /.card-body -->
             <div class="card-footer">
                 <button type="Submit" class="btn btn-success btn-lg">Add Product</button>
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
                <h3 class="mb-0">Product List</h3>
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
                            <th>#</th>
                            <th>Picture</th>
                            <th>Reference_id</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Cost_Price</th>
                            <th>MRP</th>
                            <th>Purchase Number</th>
                            <th>Short Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @foreach ($showProduct as $pro_item)
                        $count=0;
                        <tbody>
                            <tr>
                                <td>{{ $pro_item->$count }}</td>
                                <td>{{ $pro_item->Picture }}</td>
                                <td>{{ $pro_item->Reference_Id }}</td>
                                <td>{{ $pro_item->Category }}</td>
                                <td>{{ $pro_item->Quantity }}</td>
                                <td>{{ $pro_item->Cost_Price }}</td>
                                <td>{{ $pro_item->MRP }}</td>
                                <td>{{ $pro_item->Purchase_no }}</td>
                                <td>{{ $pro_item->Short_Desc }}</td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="#" data-toggle="modal"
                                        data-target="#EditProModal{{ $pur_item->id }}">
                                        <span class="btn-label"><i class="fa fa-edit"></i></span>
                                        Edit
                                    </a>
                                    <form action="{{ url('purchase/' . $pro_item->id) }}" method="POST">
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
                        {{-- #EditProductModal ---------------------------------------------------------------------------- --}}
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
                        $count++;
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
            $('#Product-Table').DataTable();
        });
    </script>
@endsection