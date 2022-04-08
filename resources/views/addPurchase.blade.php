@extends('layouts.admin')

@section('content')
    
    {{-- select2 styles --}}
    <link rel="stylesheet" href="{{asset("/plugins/select2/css/select2.css")}}">
    <link rel="stylesheet" href="{{asset("/plugins/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{asset("/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{asset("/plugins/select2-bootstrap4-theme/select2-bootstrap4.css")}}">

    <style>
        #Purchase-Table {
            /* border: 1px solid black; */
            table-layout: fixed;
            width: 100%;
        }

        #Purchase-Table 
        th,
        td {
            /* border: 1px solid black; */
            /* width: 100px; */
            overflow: hidden;
            text-align: center;
        }

    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Purchases</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">AddPurchases</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="card">
            
            {{-- <div class="card-header">
                <h3>Add Purchase</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div> --}}
            {{-- !card-header-ends --}}
            <form method="POST" id="FormData" action="{{route('addPurchase.store')}}"><!--///////-->
                @csrf
            <div class="card-body">
                <!--div to print error messages-->
                @if(session('errors'))
                    <script>
                        $('#success_message').removeClass("alert alert-danger");
                    </script>
                   <div class="error_message alert alert-danger">
                       <ul>
                            @foreach($errors->all() as $err)
                                <li>{{$err}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('status'))
                <script>
                    swal('Success!',"{{Session('status')}}",'success',{button:'OK'});
                </script>
                @endif
                <!--input csrf token on post request-->
                {{-- <input type="hidden" id="CSRF_Token" value="{{csrf_token()}}"> --}}
                <div class="row">
                        <div class="col-md-4">
                            <label for="Date_Of_Purchase">
                                <b>Date Of Purchase:</b>
                                <span style="color: red">*</span>
                            </label>
                            <input type="date" name="Date_Of_Purchase" id="Date_Of_Purchase" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="Supplier_Name">
                                <b>Supplier Name:</b>
                                <span style="color: red">*</span>
                            </label>
                            <select name="Supplier_Name" id="Supplier_Name" class="form-control select2 select2bs4 select2-danger" required>
                                <option value="">Open this select menu</option>
                                @foreach ($Show_supp as $show_supp)
                                    <option value="{{ $show_supp->Supplier_Name }}"
                                        data-brand="{{ $show_supp->Brand_Name }}" data-id="{{ $show_supp->id}}">
                                        {{ $show_supp->Supplier_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="Brand_Name">
                                <b>Brand Name:</b>
                            </label>
                            <input type="text" name="Brand_Name" id="Brand_Name" class="form-control" required readonly>
                            <input type="hidden" name="Supplier_Id" id="Supplier_Id">
                        </div>
                    </div>
                </div>
                    <div class="content m-3">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="Purchase-Table">
                                    <thead>
                                        <tr>
                                            <th>Product <span style="color: red">*</span></th>
                                            <th style="width: 120px">Quantity <span style="color: red">*</span></th>
                                            <th style="width: 120px">Price <span style="color: red">*</span></th>
                                            <th style="width: 120px">Tax Slab(%)</th>
                                            <th style="width: 120px">Tax Amount</th>
                                            <th style="width: 200px">SubTotal</th>
                                            <th style="width: 90px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="Purchase_tbody">
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <select name="PurchaseProduct[]" class="form-control select2 select2bs4 select2-danger PurchaseProduct" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                                        <option value=
                                                        "">open to select product</option>
                                                        @foreach ($showProduct as $Product_Item)
                                                            <option value="{{ $Product_Item->Name }}" data-id="{{ $Product_Item->id }}" data-TaxSlab="{{$Product_Item->TaxSlab}}">{{ $Product_Item->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="PurchaseProductId[]" class="PurchaseProductId">
                                                </div>
                                            </td>
                                            <td style="width: 120px">
                                                <input type="number" min="1" class="form-control PurchaseQuantity" name="PurchaseQuantity[]" required>
                                            </td>
                                            <td style="width: 120px">
                                                <input type="number" min="0.01" step="0.01" class="form-control PurchasePrice" name="PurchasePrice[]" required>
                                            </td>
                                            <td style="width: 120px">
                                                <input type="number" class="form-control PurchaseTaxSlab" name="PurchaseTaxSlab[]" readonly>
                                            </td>
                                            <td style="width: 120px">
                                                <input type="number" class="form-control PurchaseTaxAmount" name="PurchaseTaxAmount[]" readonly>
                                            </td>
                                            <td style="width: 200px">
                                                <input type="text" class="form-control PurchaseSubTotal" name="PurchaseSubTotal[]" readonly>
                                            </td>
                                            <td style="width: 60px">
                                                <a class=" btn btn-sm btn-danger rounded-3 btnSpan DelPurchase"><i class="fas fa-times mt-2 btnI"></i></a>
                                                <a class=" btn btn-sm btn-success rounded-3 btnSpan AddMoreProduct" style="display: none"><i class="fas fa-plus mt-2 btnI"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <label style=" float: right;">Total SubTotal:</label>
                                            </td>
                                            <td colspan="3">
                                                    <input type="text" class="form-control" name="TotalSubTotal" id="TotalSubTotal" placeholder="Total SubTotal" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <label style="float: right;">Total Tax Amount:</label>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" class="form-control" name="TotalTaxAmount" id="TotalTaxAmount" placeholder="Tax Amount" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <label style="float: right;margin-top:49px">Discount:</label>
                                            </td>
                                            <td colspan="3">
                                                <label>Discount Percentage:</label>
                                                <br>
                                                <input type="text" class="form-control" name="DiscountPer" id="DiscountPer" placeholder="Discount Percentage">
                                                <label>Discount Amount:</label>
                                                <br>
                                                <input type="text" class="form-control" name="DiscountAmount" id="DiscountAmount" value="0" placeholder="Discount Amount" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <label style="float: right;">Total Amount:</label>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" class="form-control" name="TotalAmount" id="TotalAmount" placeholder="Total Amount" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="m-3 float-right">
                        <input type="Submit" class="btn btn-success btn-lg" id="AddPurchase" value="Add Purchase"/>
                    </div>
            </div>
            <!-- /.card-body -->
            </form><!--form ends/////////////////////////////////////////////-->
        </div>
        <!--/.card-->
    </div>

    {{-- Imported Scripts---------------------------------------------------------------------- --}}

    {{-- script to use moment.js method to get by default today's date --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    {{-- script to use select2 --------------------------------------------------------------}}
    <script src={{asset("/plugins/select2/js/select2.full.min.js")}} defer></script>


    {{-- JQuery Section ------------------------------------------------------------------------ --}}
    <script>
        // using moment.js method to get by default today's date
        var today = moment().format('YYYY-MM-DD');
        $('#Date_Of_Purchase').val(today);

        //fetching brand name by default on the basis of supplier name
        $("#Supplier_Name").on('change', function() {
            var selecteBrand = $(this).find(":selected").data("brand");
            var selectSupId = $(this).find(":selected").data("id");
            $("#Brand_Name").val(selecteBrand);
            $('#Supplier_Id').val(selectSupId)
        });

         //fetching tax slab by default on the basis of product name
         $(document).on('input','.PurchaseProduct', function() {
                var row = $(this).closest('tr');
                var selectTaxSlab = row.find(".PurchaseProduct :selected").attr("data-TaxSlab");
                var selectProductId = row.find(".PurchaseProduct :selected").attr("data-id");
                console.log(selectTaxSlab);
                row.find(".PurchaseTaxSlab").val(selectTaxSlab);
                row.find(".PurchaseProductId").val(selectProductId);
        });
        
        $(document).ready(function(){
            //add green plus to the last row of adding product
            $('#Purchase-Table tbody tr:last td:last .AddMoreProduct').css('display', 'inline-block');

           var count = 1;//counter for no of rows

           //on click adding new row dynamically
           $(document).on('click','.AddMoreProduct',function(e){
               e.preventDefault(e);
                
                count += 1;//counting no. of rows
                console.log("After Row Add count: "+count);
                //appending new row
                $('#Purchase_tbody').append('<tr>\
                                        <td>\
                                            <div class="form-group">\
                                                <select name="PurchaseProduct[]" class="form-control select2 select2bs4 select2-danger PurchaseProduct" data-dropdown-css-class="select2-danger" style="width: 100%;" required>\
                                                    <option>open to select product</option>\
                                                    @foreach ($showProduct as $Product_Item)\
                                                        <option value="{{ $Product_Item->Name }}" data-id="{{ $Product_Item->id }}" data-TaxSlab="{{$Product_Item->TaxSlab}}"">{{ $Product_Item->Name }}</option>\
                                                    @endforeach\
                                                </select>\
                                                <input type="hidden" name="PurchaseProductId[]" class="PurchaseProductId">\
                                            </div>\
                                        </td>\
                                        <td style="width: 120px">\
                                            <input type="number" min="1" class="form-control PurchaseQuantity" name="PurchaseQuantity[]" required>\
                                        </td>\
                                        <td style="width: 120px">\
                                            <input type="number" min="0.01" step="0.01" class="form-control PurchasePrice" name="PurchasePrice[]" required>\
                                        </td>\
                                        <td style="width: 120px">\
                                            <input type="number" class="form-control PurchaseTaxSlab" name="PurchaseTaxSlab[]" readonly>\
                                        </td>\
                                        <td style="width: 120px">\
                                            <input type="number" class="form-control PurchaseTaxAmount" name="PurchaseTaxAmount[]" readonly>\
                                        </td>\
                                        <td style="width: 200px">\
                                            <input type="text" class="form-control PurchaseSubTotal" name="PurchaseSubTotal[]" readonly>\
                                        </td>\
                                        <td style="width: 60px">\
                                            <a class=" btn btn-sm btn-danger rounded-3 btnSpan DelPurchase"><i class="fas fa-times mt-2 btnI"></i></a>\
                                            <a class=" btn btn-sm btn-success rounded-3 btnSpan AddMoreProduct" style="display: none"><i class="fas fa-plus mt-2 btnI"></i></a>\
                                        </td>\
                                    </tr>');
                //initialise select 2
                $('.select2').select2();
        
                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4' 
                });

                //remove green plus from everywhere and add it only in the last row
                $('#Purchase-Table tbody tr:last td:last .AddMoreProduct').css('display', 'inline-block');
                $(this).css('display', 'none');
           });
           //initialise select 2
           $('.select2').select2();
        
           //Initialize Select2 Elements
           $('.select2bs4').select2({
               theme: 'bootstrap4' 
           });
           
           //del row functionality
           $(document).on('click','.DelPurchase',function(){
               var row = $(this).closest('tr');
               count -=1;//decrease row count
               console.log("After Del Row: "+count);
               row.remove();

               //add green plus to the last row of adding product
                $('#Purchase-Table tbody tr:last td:last .AddMoreProduct').css('display', 'inline-block');
                
               TotalCalculate();
           });

           function TotalCalculate()
           {
               //calculating total of sub total
               var TotalAmount = 0;
                $('.PurchaseSubTotal').each( function () { 
                    if(isNaN($(this).val()) || $(this).val()=='')
                    {
                        var pst=0;
                        // alert("purchase subtotal is NAN");
                    }
                    else{
                        pst = $(this).val();
                    }
                    TotalAmount = parseFloat(TotalAmount) + parseFloat(pst);
                });
                $('#TotalSubTotal').val("");
                $('#TotalSubTotal').val(isNaN(TotalAmount.toFixed(2)) ? 0 : TotalAmount.toFixed(2));//add total value in tfoot

                $('#TotalAmount').val("");
                $('#TotalAmount').val(isNaN(TotalAmount.toFixed(2)) ? 0 : TotalAmount.toFixed(2));///add total value in Grand_total

                //calculating total tax amount
               var TotalTaxAmount = 0;
                $('.PurchaseTaxAmount').each( function () { 
                    if(isNaN($(this).val()) || $(this).val()=='')
                    {
                        var pta=0;
                        // alert("purchase subtotal is NAN");
                    }
                    else{
                        pta = $(this).val();
                    }
                    TotalTaxAmount = parseFloat(TotalTaxAmount) + parseFloat(pta);
                });
                $('#TotalTaxAmount').val("");
                $('#TotalTaxAmount').val(isNaN(TotalTaxAmount.toFixed(2)) ? 0 : TotalTaxAmount.toFixed(2));//add total tax value in tfoot

                //calculate discount on change of subtotal
                var disper = $('#DiscountPer').val();
                var amountBeforeDis = $('#TotalSubTotal').val();
                disAmt = parseFloat((amountBeforeDis*disper)/100);
                $('#DiscountAmount').val(disAmt.toFixed(2));
                console.log("discount amount on change"+disAmt);
                
                // calculate final total value
                var dis = $('#DiscountAmount').val();
                if(dis<=0 || isNaN(dis))
                {
                    dis = 0;
                }
                if(TotalAmount<=0 || isNaN(TotalAmount))
                {
                    TotalAmount = 0;
                }
                if(TotalTaxAmount<=0 || isNaN(TotalTaxAmount))
                {
                    TotalTaxAmount = 0;
                }
                var ta = parseFloat(TotalAmount) + parseFloat(TotalTaxAmount) - parseFloat(dis);
                $('#TotalAmount').val(isNaN(ta.toFixed(2)) ? 0 : ta.toFixed(2));//set final value of total amount with tax and discount 
           }

           //calculate subtotal on entering price
           $(document).on('input','.PurchasePrice',function(){
               var row = $(this).closest('tr');
               var price = row.find('.PurchasePrice').val();
               var qty = row.find('.PurchaseQuantity').val();
               
               var subTotal = qty * parseFloat(price);
                console.log(qty + '\t' + price + '\t' + subTotal);
                row.find(".PurchaseSubTotal").val(isNaN(subTotal.toFixed(2)) ? 0 : subTotal.toFixed(2));
                
                //calculating tax amount
                var taxslab = row.find('.PurchaseTaxSlab').val();
                taxAmt = parseFloat((taxslab*price*qty)/100);
                row.find('.PurchaseTaxAmount').val(isNaN(taxAmt.toFixed(2)) ? 0 : taxAmt.toFixed(2));
                console.log(taxAmt);
                TotalCalculate();
           });

           //calculate subtotal on entering quantity
           $(document).on('input','.PurchaseQuantity',function(){
               var row = $(this).closest('tr');
               var price = row.find('.PurchasePrice').val();
               var qty = row.find('.PurchaseQuantity').val();
               
               var subTotal = qty * parseFloat(price);
                console.log(qty + '\t' + price + '\t' + subTotal);
                row.find(".PurchaseSubTotal").val(isNaN(subTotal.toFixed(2)) ? 0 : subTotal.toFixed(2));
                
                //calculating tax amount
                var taxslab = row.find('.PurchaseTaxSlab').val();
                taxAmt = parseFloat((taxslab*price*qty)/100);
                row.find('.PurchaseTaxAmount').val(isNaN(taxAmt.toFixed(2)) ? 0 : taxAmt.toFixed(2));
                console.log(taxAmt);
                TotalCalculate();
           });

           //calculating discount percentage
           $('#DiscountPer').on('input',function(){
                var discountpercentage = $('#DiscountPer').val();
                var amountBeforeDis = $('#TotalSubTotal').val();
                disAmt = parseFloat((amountBeforeDis*discountpercentage)/100);
                $('#DiscountAmount').val(disAmt.toFixed(2));
                console.log(disAmt);
                TotalCalculate();
           });

           //calculating tax amount on the basis of tax slab
           $(document).on('change','.PurchaseTaxSlab',function(){
                var row = $(this).closest('tr');
                var taxslab = row.find('.PurchaseTaxSlab').val();
                var productSubTotal = row.find('.PurchaseSubTotal').val();
                taxAmt = parseFloat((taxslab*productSubTotal)/100);
                row.find('.PurchaseTaxAmount').val(taxAmt);
                console.log(taxAmt);
                TotalCalculate();
           });

        });

    </script>
@endsection
