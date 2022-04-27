@extends('layouts.admin')

@section('content')

  <style>
    #Alert_Table td,th{
      text-align: center;
    }
  </style>
 <!-- Content Header (Page header) -->
 <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            {{-- <li class="breadcrumb-item active">Dashboard v1</li> --}}
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$product}}</h3>

              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href={{route('products.index')}} class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$supplier}}</h3>

              <p>Total Suppliers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href={{route('suppliers.index')}} class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$customer}}</h3>

              <p>Total Customers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('customers.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$category}}</h3>

              <p>Total Categories</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href={{route('categories.index')}} class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{$purchase}}</h3>

              <p>Total Purchase Bills</p>
            </div>
            <div class="icon">
              <i class="ion ion-clipboard"></i>
            </div>
            <a href={{route('viewPurchase.index')}} class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-dark">
            <div class="inner">
              <h3>{{$sale}}</h3>

              <p>Total Sale Bills</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href={{url('/ViewSales')}} class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      {{-- alert quantity table ================================================================--}}
      <div class="card card-primary alert-quantity-table">
        <div class="card-header">
          <h3 class="card-title">Alert Quantity Products</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body h-25 table-responsive">
          <h5 class="total_alerts small-box p-2 mb-1 bg-info float-right">
            Total Alerts:{{count($proAlert)}}
          </h5>
          <table class="table table-bordered table-striped dataTable dtr-inline" id="Alert_Table">
            <thead>
              <th>#</th>
              <th>Product</th>
              <th>Alert Quantity</th>
              <th>Current Quantity</th>
            </thead>
            <tbody class="overflow-y-auto">
              @foreach ($proAlert as $item)
                  <tr>
                    <td>{{$item->Product_Id}}</td>
                    <td>{{$item->Name}}({{$item->Reference_Id}})</td>
                    <td><span class="bg-danger p-1">{{$item->Alert_Quantity}}</span></td>
                    <td>{{$item->QuantityLeft}}</td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
  </section>
  <!-- /.content -->
  <!-- JQVMap -->
<script src={{asset("plugins/jqvmap/jquery.vmap.min.js")}}></script>
<script src={{asset("plugins/jqvmap/maps/jquery.vmap.usa.js")}}></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src={{asset("dist/js/pages/dashboard.js")}}></script>
@endsection
