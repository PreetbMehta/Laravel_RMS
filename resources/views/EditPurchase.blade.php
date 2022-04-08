@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Purchases</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">EditPurchases</li>
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
            <form method="POST" id="FormData" action="{{url('EditPurchase/'.$id)}}"><!--///////-->
                @csrf
                @method('PUT')
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
                            <input type="date" name="Date_Of_Purchase" id="Date_Of_Purchase" class="form-control" value="{{$pur_over->Date_Of_Purchase}}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="Supplier_Name">
                                <b>Supplier Name:</b>
                                <span style="color: red">*</span>
                            </label>
                            <select name="Supplier_Name" id="Supplier_Name" class="form-control select2 select2bs4 select2-danger" required>
                                <option value="">Open this select menu</option>
                                @foreach ($sup as $show_supp)
                                    <option value="{{ $show_supp->Supplier_Name }}"
                                        data-brand="{{ $show_supp->Brand_Name }}" data-id="{{ $show_supp->id}}" {{$show_supp->id==$pur_over->Supplier_Id?'selected':""}}>
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
                                <table class="table table-bordered table-stripped" id="Purchase-Table">
                                    <thead>
                                        <tr>
                                            <th>Product <span style="color: red">*</span></th>
                                            <th style="width: 120px">Quantity <span style="color: red">*</span></th>
                                            <th style="width: 120px">Price <span style="color: red">*</span></th>
                                            <th style="width: 120px">Tax Slab(%)</th>
                                            <th style="width: 120px">Tax Amount</th>
                                            <th style="width: 200px">SubTotal</th>
                                            <th style="width: 100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="Purchase_tbody">
                                        <input type="hidden" name="Total_Products" id="Total_Products" value="{{$pur_over->Total_Products}}">
                                        @foreach($pur_det as $pur_item)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="RowId[]" class="RowId" value="{{$pur_item->id}}">
                                                    <div class="form-group">
                                                        <select name="PurchaseProduct[]" class="form-control select2 select2bs4 select2-danger PurchaseProduct" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                                            <option value=
                                                            "">open to select product</option>
                                                            @foreach ($showProduct as $Product_Item)
                                                                <option value="{{ $Product_Item->id }}" data-name={{$Product_Item->Name}} data-id="{{ $Product_Item->id }}" data-TaxSlab="{{$Product_Item->TaxSlab}}" {{$Product_Item->id==$pur_item->Product_Id?'selected':""}} >{{ $Product_Item->Name }}</option>
                                                            @endforeach
                                                        </select>
                                                        {{-- <input type="hidden" name="PurchaseProductId[]" class="PurchaseProductId"> --}}
                                                    </div>
                                                </td>
                                                <td style="width: 120px">
                                                    <input type="number" min="1" class="form-control PurchaseQuantity" name="PurchaseQuantity[]" value="{{$pur_item->Quantity}}" required>
                                                </td>
                                                <td style="width: 120px">
                                                    <input type="number" min="0.01" step="0.01" class="form-control PurchasePrice" name="PurchasePrice[]" value="{{$pur_item->Price}}" required>
                                                </td>
                                                <td style="width: 120px">
                                                    <input type="number" class="form-control PurchaseTaxSlab" value="{{$pur_item->Tax_Slab}}" name="PurchaseTaxSlab[]" readonly>
                                                </td>
                                                <td style="width: 120px">
                                                    <input type="number" class="form-control PurchaseTaxAmount" value="{{$pur_item->Tax_Amount}}" name="PurchaseTaxAmount[]" readonly>
                                                </td>
                                                <td style="width: 200px">
                                                    <input type="text" class="form-control PurchaseSubTotal" value="{{$pur_item->Sub_Total}}" name="PurchaseSubTotal[]" readonly>
                                                </td>
                                                <td style="width: 100px;text-align:center">
                                                    <span class="mt-2 btn btn-sm btn-danger rounded-3 btnSpan DelProduct" data-rowId='{{$pur_item->id}}'><i class="fas fa-times mt-2 btnI"></i></span>
                                                    <span class="mt-2 btn btn-sm btn-success rounded-3 btnSpan AddMoreProduct" style="display: none"><i class="fas fa-plus mt-2 btnI"></i></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <label style=" float: right;">Total SubTotal:</label>
                                            </td>
                                            <td colspan="3">
                                                    <input type="text" class="form-control" name="TotalSubTotal" id="TotalSubTotal" placeholder="Total SubTotal" value="{{$pur_over->Sub_Total}}" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <label style="float: right;">Total Tax Amount:</label>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" class="form-control" name="TotalTaxAmount" id="TotalTaxAmount" placeholder="Tax Amount" value="{{$pur_over->Total_Tax_Amount}}" readonly>
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
                                                <input type="text" class="form-control" name="DiscountAmount" id="DiscountAmount" placeholder="Discount Amount" value="{{$pur_over->Discount_Amount}}" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <label style="float: right;">Total Amount:</label>
                                            </td>
                                            <td colspan="3">
                                                <input type="text" class="form-control" name="TotalAmount" id="TotalAmount" placeholder="Total Amount" value="{{$pur_over->Total_Amount}}" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="m-3 float-right">
                        <input type="Submit" class="btn btn-success btn-lg" id="AddPurchase" value="Edit Purchase"/>
                    </div>
            </div>
            <!-- /.card-body -->
            </form><!--form ends/////////////////////////////////////////////-->
        </div>
        <!--/.card-->
    </div>
    <script>
    $(document).ready(function(){
        //initialise select 2
        $('.select2').select2();
        
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4' 
        });

        //remove class of red cross and add classes of green plus to the last row of tbody
        $('#Purchase_tbody tr:last td:last .AddMoreProduct').css('display','inline-block');

    });
    //set brand name according to supplier name
    var brand = $('#Supplier_Name :selected').data('brand');
    $('#Brand_Name').val(brand);
    var id = $('#Supplier_Name :selected').data('id');
    $('#Supplier_Id').val(id);
    $('#Supplier_Name').on('change',function(){
        var brand = $('#Supplier_Name :selected').data('brand');
        $('#Brand_Name').val(brand);
        var id = $('#Supplier_Name :selected').data('brand');
        $('#Supplier_Id').val(id);
    });

    // set tax slab value as per product selected
    $(document).on('input','.PurchaseProduct', function() {
                var row = $(this).closest('tr');
                var selectTaxSlab = row.find(".PurchaseProduct :selected").attr("data-TaxSlab");
                var selectProductId = row.find(".PurchaseProduct :selected").attr("data-id");
                console.log(selectTaxSlab);
                row.find(".PurchaseTaxSlab").val(selectTaxSlab);
                row.find(".PurchaseProductId").val(selectProductId);
    });

    //calculate discount percentage based on discount amount
    $(function(){
        dis = $('#DiscountAmount').val();
        console.log(dis);
        total = $('#TotalSubTotal').val();
        console.log(total);
        disper = (dis*100)/total;
        console.log(disper);
        $('#DiscountPer').val(disper.toFixed(2));
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var count = $('#Total_Products').val(); //initialize counter variable to count number of rows/products ordered

    //delete row on click on del product
    $(document).on('click','.DelProduct',function(){
        var row_id = $(this).attr('data-rowId');
        console.log(row_id);
        var tr = $(this).closest('tr');
        var name = tr.find('.PurchaseProduct :selected').attr('data-name');
        if(row_id)
        {
            count-=1;
             console.log(count);
            if(count<=0)
            {
                alert("All rows Can't be Deleted \n Minimum one row should be there");
                count += 1;
                console.log("After Del Row: " + count);
            }
            else
            {
                swal('Alert',"Are you sure you want to  delete this Purchase of "+name+"?",'warning',{buttons:{
                    cancel:"Cancel",
                    yes:"YES,Delete!"
                    }}).then((value)=>{
                        switch(value){
                            case 'yes':
                                    $.ajax({
                                        type: "DELETE",
                                        url: "/EditPurchase/"+row_id,
                                        success: function (response) {
                                            tr.closest('tr').remove();
                                            swal("Great",response.message,"success",{button:"OK"});
                                            //remove red cross and add green plus to the last row of tbody
                                            $('#Purchase_tbody tr:last td:last .AddMoreProduct').css('display','inline-block');
                                            TotalCalculate();
                                        },
                                        error: function (response) {
                                            console.log('Error:', response);
                                            swal("Something went wrong","warning",{button:"OK"});
                                        }
                                    });
                                    break;
                                default: 
                                    swal(name+" Purchase Item Not Deleted!!","","warning");
                                    break;
                        }
                    });
            }
        }
        else
        {
            $(this).closest('tr').remove();
            //remove red cross and add green plus to the last row of tbody
            $('#Purchase_tbody tr:last td:last .AddMoreProduct').css('display','inline-block');
            TotalCalculate();
        }
    });

    //add row on click on add more product
    $(document).on('click','.AddMoreProduct',function(){
        $('#Purchase_tbody').append('<tr>\
                                                <td>\
                                                    <input type="hidden" name="RowId[]" class="RowId" value="0">\
                                                    <div class="form-group">\
                                                        <select name="PurchaseProduct[]" class="form-control select2 select2bs4 select2-danger PurchaseProduct" data-dropdown-css-class="select2-danger" style="width: 100%;" required>\
                                                            <option value=\
                                                            "">open to select product</option>\
                                                            @foreach ($showProduct as $Product_Item)\
                                                                <option value="{{ $Product_Item->id }}" data-id="{{ $Product_Item->id }}" data-TaxSlab="{{$Product_Item->TaxSlab}}">{{ $Product_Item->Name }}</option>\
                                                            @endforeach\
                                                        </select>\
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
                                                <td style="width: 100px;text-align:center">\
                                                    <span class="mt-2 btn btn-sm btn-danger rounded-3 btnSpan DelProduct"><i class="fas fa-times mt-2 btnI"></i></span>\
                                                    <span class="mt-2 btn btn-sm btn-success rounded-3 btnSpan AddMoreProduct"><i class="fas fa-plus mt-2 btnI"></i></span>\
                                                </td>\
        </tr>');
        //initialise select 2
        $('.select2').select2();
        
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4' 
        });
        //remove red cross and add green plus to the last row of tbody
        $('#Purchase_tbody tr:last td:last .AddMoreProduct').css('display','inline-block');
        // $('#Purchase_tbody tr:last td:last .DelProduct').css('display','none');
        $(this).css('display','none');
        $(this).parent().children('.DelProduct').css('display','inline-block');
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

    </script>
@endsection