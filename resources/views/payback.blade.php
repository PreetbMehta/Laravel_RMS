@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pay Back</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pay Back</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @if (Session('status'))
        <script>
            swal('Success!',"{{Session('status')}}",'success',{button:'OK'});
        </script>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{route('payback.store')}}" method="POST" id="form">
                @csrf
                <label>Check your order type:</label>
                <div class="form-group radio">
                    <input type="radio" name="Mistaketype" id="ReturnOrder" class="ml-3" value="Return_Order">
                    <label for="ReturnOrder">Return Order</label>
                    <input type="radio" name="Mistaketype" id="EditSale" class="ml-3" value="Edit_Sale">
                    <label for="EditSale">Edit Sale</label>
                </div>
                <div class="col-md-6" id="Return_Select" style="display: none">
                    <label for="Return_Id">
                        Return Id :
                    </label>
                    <select name="Return_Id" id="Return_Id" class="form-control select2 select2bs4 select2-danger">
                        <option value="">open menu to select return order id</option>
                        @foreach ($ro as $item)
                            <option value="{{$item->id}}">{{$item->id}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6" id="Sales_Select" style="display: none">
                    <label for="Sales_Id">
                        Sales Id :
                    </label>
                    <select name="Sales_Id" id="Sales_Id" class="form-control select2 select2bs4 select2-danger">
                        <option value="">open menu to select sales order id</option>
                        @foreach ($s as $item)
                            <option value="{{$item->id}}">{{$item->id}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="Bill_Date">Date of Bill:</label>
                        <input type="text" name="Bill_Date" id="Bill_Date" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="Cust_Name">Customer Name:</label>
                        <input type="text" name="Cust_Name" id="Cust_Name" class="form-control" readonly>
                        <input type="hidden" name="Customer_Id" id="Customer_Id">
                    </div>
                    <div class="col-md-4">
                        <label for="Bill_Amount">Bill Amount:</label>
                        <input type="text" name="Bill_Amount" id="Bill_Amount" class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="ATP">Amount To Pay:</label>
                        <input type="text" name="ATP" id="ATP" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="Payment_Method">Payment Method</label>
                        <input type="text" name="Payment_Method" id="Payment_Method" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="Payment_Note">Payment Note:</label>
                        <textarea name="Payment_Note" id="Payment_Note" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <input type="submit" value="Pay to Customer" class="btn btn-primary mt-2">
            </form>
            <div class="row m-0 p-0">
                <p>
                    ***Note: Pay to customer Only if the 'Amount To Pay' is green as Green means you have to pay, While Red means Customer Needs to pay that much amount of credit and for that credit details and statement view 'Credits Page'.***
                </p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            //initialise select 2
            $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
            
            $('#Return_Select').on('change',function(){
                var id = $('#Return_Select :selected').val();
                // console.log(id);
                $.ajax({
                    type: "get",
                    url: "payback/"+id,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        $.each(response.data[0], function (indexInArray, valueOfElement) { 
                            // console.log(indexInArray+'---'+valueOfElement);
                            $('#'+indexInArray).val(valueOfElement)
                        });
                        // console.log(response[0]);
                        if(response[0] < 0)
                        {
                            $('#ATP').removeClass('bg bg-success bg-danger');
                            $('#ATP').addClass('bg bg-success');console.log(0);
                        }
                        else if(response[0] > 0)
                        {
                            $('#ATP').removeClass('bg bg-success bg-danger');
                            $('#ATP').addClass('bg bg-danger');console.log(1);
                        }
                        $('#ATP').val(response[0]);
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            });

            $('#Sales_Select').on('change',function(){
                var id = $('#Sales_Select :selected').val();
                // console.log(id);
                $.ajax({
                    type: "GET",
                    url: "payback/"+id+'/edit',
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        $.each(response.data[0], function (indexInArray, valueOfElement) { 
                            // console.log(indexInArray+'---'+valueOfElement);
                            $('#'+indexInArray).val(valueOfElement)
                        });
                        if(response[0] < 0)
                        {
                            $('#ATP').removeClass('bg bg-success bg-danger');
                            $('#ATP').addClass('bg bg-success');console.log(0);
                        }
                        else if(response[0] > 0)
                        {
                            $('#ATP').removeClass('bg bg-success bg-danger');
                            $('#ATP').addClass('bg bg-danger');console.log(1);
                        }
                        $('#ATP').val(response[0]);
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            });
        });
        $('.radio input').on('change',function(){
            var i = $('input[name="Mistaketype"]:checked').val();
            // $('#form').trigger('reset');
            $('#ATP').removeClass('bg bg-success bg-danger');
            $('#ATP').val('');
            $('#Bill_Date').val('');
            $('#Cust_Name').val('');
            $('#Bill_Amount').val('');
            $('#Payment_Method').val('');
            $('#Payment_Note').val('');
            $('#Sales_Id').val('');
            $('#Return_Id').val('');
            // console.log(i);
            if(i=='Edit_Sale')
            {
                $('#Sales_Select').css('display','block');
                $('#Return_Select').css('display','none');
            }
            else
            {
                $('#Return_Select').css('display','block');
                $('#Sales_Select').css('display','block');
            }
        });
    </script>
@endsection