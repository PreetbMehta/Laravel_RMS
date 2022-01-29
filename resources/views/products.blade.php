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
@endsection