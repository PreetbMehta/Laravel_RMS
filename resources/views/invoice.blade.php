@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="card-body">
      <!-- Main content -->
      <div class="invoice p-3 mb-3" id="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h4>
                @if($setting[0]->Logo == '')
                  <i class="fas fa-globe"></i> {{$setting[0]->Company_Name}}
                  @else
                  <img src="{{asset('Uploads/settingLogo/'.$setting[0]->Logo)}}" width="45" alt="" class="d-inline-block align-middle mr-2">
                  <Span>{{$setting[0]->Company_Name}}</Span>
                @endif
                
                <small class="float-right">Date: {{$sal_over[0]->Date_Of_Sale}}</small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong>{{$setting[0]->Company_Name}}</strong><br>
                {{$setting[0]->Address}}<br>
                Phone: {{$setting[0]->Mobile_No}}<br>
                Email: {{$setting[0]->Email_Id}}
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <address>
                <strong>{{$sal_over[0]->Customer_Name}}</strong><br>
                Phone: {{$sal_over[0]->Contact}}<br>
                Email: {{$sal_over[0]->Email_Id}}
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>Invoice No.: {{$sal_over[0]->id}}</b><br>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
  
          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Product</th>
                      <th>Qty</th>
                      <th>MRP</th>
                      <th>TaxSlab</th>
                      <th>Tax Amount</th>
                      <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>  
                  @foreach ($sal_det as $item)    
                      <tr>
                          <td>{{$item->Name}}({{$item->Reference_Id}})</td>
                          <td>{{$item->Sales_Quantity}}</td>
                          <td>{{$item->Sales_Price}}</td>
                          <td>{{$item->SalesTaxSlab}}</td>
                          <td>{{$item->SalesTaxAmount}}</td>
                          <td>{{$item->SalesSubTotal}}</td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
  
          <div class="row">
            <div class="col-6">
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Subtotal:</th>
                    <td>{{$sal_over[0]->Total_SubTotal}}</td>
                  </tr>
                  <tr>
                    <th>Tax</th>
                    <td>{{$sal_over[0]->Total_Tax_Amount}}</td>
                  </tr>
                  <tr>
                      <th>Discount Amount</th>
                      <td>{{$sal_over[0]->Discount_Amount}}</td>
                    </tr>
                  <tr>
                    <th>Total:</th>
                    <td>{{$sal_over[0]->Total_Amount}}</td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
  
      </div>
      <!-- /.invoice -->
          
      <!-- this row will not appear when printing -->
      <div class="row no-print">
          <div class="col-12">
              <a href="invoice-print" rel="noopener" target="_blank" id="print" class="btn btn-primary btn-lg float-right m-2" onclick='printDiv();'><i class="fas fa-print"></i> Print</a>
          </div>
      </div>
    </div>

    <script>
        function printDiv() 
        {

        var divToPrint=document.getElementById('invoice').innerHTML;

        var oldPage = document.body.innerHTML;

        document.body.innerHTML=
            "<html><head><title></title></head><body>"+divToPrint+"</body></html>";
        
        window.print();
        document.body.innerHTML = oldPage;

        }
    </script>
@endsection