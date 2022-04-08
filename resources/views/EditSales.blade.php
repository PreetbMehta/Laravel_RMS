@extends('layouts.admin')

@section('content')
        <style>
            #Sales_Table {
                table-layout: fixed;
                width: 100%;
                overflow: hidden;
                text-align: center;
            }
            #Sales_Table th,td{
                overflow: hidden;
                text-align: center;
            }
        </style>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Sales</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Sales</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    
        <form action="{{url('sales/'.$sales_overview[0]->id)}}" method="POST" id="SalesFrom">
            @csrf
            @method('PUT')
            <!-- row for containing both the cards -->
            <div class="row m-2">
                <!-- first product card -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Ordered Products</h3>
                        </div>
                        <div class="card-body">
                            @if (Session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{Session('status')}} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <!--first row of info -->
                            <div class="row">
                                <input type="hidden" value="{{$sales_overview[0]->Total_Products}}" id="Total_Products">
                                <div class="col-md-4">
                                    <label for="Date_Of_Sale">
                                        <b>Date Of Sale:</b>
                                        <span style="color: red">*</span>
                                    </label>
                                    <input type="date" name="Date_Of_Sale" id="Date_Of_Sale" class="form-control" value="{{$sales_overview[0]->Date_Of_Sale}}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Customer_Id">
                                        <b>Customer Name:</b>
                                        <span style="color: red">*</span>
                                    </label>
                                    <select name="Customer_Id" id="Customer_Id"
                                        class="form-control select2 select2bs4 select2-danger" required>
                                        <option value="">Open this select menu</option>
                                        @foreach ($cust as $show_cust)
                                            <option value="{{ $show_cust->id }}" data-contact="{{ $show_cust->Contact }}"{{($show_cust->id==$sales_overview[0]->Customer_Id)?'selected':''}}>
                                                {{ $show_cust->Customer_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="Contact">
                                        <b>Contact No:</b>
                                    </label>
                                    <input type="text" name="Contact" id="Contact" class="form-control" required readonly>
                                </div>
                            </div>
                            <div class="card m-2">
                                <div class="card-body">
                                    <!-- table for adding ordered products -->
                                    <table class="table table-bordered table-striped m-1" id="Sales_Table">
                                        <thead>
                                            <tr>
                                                <th>Product <span style="color: red">*</span></th>
                                                <th style="width: 100px">Quantity <span style="color: red">*</span></th>
                                                <th style="width: 100px">MRP <span style="color: red">*</span></th>
                                                <th style="width: 100px">Tax Slab(%)</th>
                                                <th style="width: 100px">Tax Amount</th>
                                                <th style="width: 100px">SubTotal</th>
                                                <th style="width: 90px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales_detail as $item)    
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="RowId[]" class="RowId" value="{{$item->id}}">
                                                        <div class="form-group">
                                                            <select name="SalesProduct[]"
                                                                class="form-control select2 select2bs4 select2-danger SalesProduct"
                                                                data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                                required>
                                                                <option value="">open to select product</option>
                                                                @foreach ($pro as $Pro_Item)
                                                                    <option value="{{ $Pro_Item->id }}" data-name="{{ $Pro_Item->Name }}" data-MRP="{{ $Pro_Item->MRP }}" data-TaxSlab="{{ $Pro_Item->TaxSlab }}" {{($Pro_Item->id==$item->Sales_Product)?'selected':''}}>
                                                                        {{ $Pro_Item->Name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td style="width: 120px">
                                                        <input type="number" min="1" class="form-control SalesQuantity"
                                                        name="SalesQuantity[]" value="{{$item->Sales_Quantity}}" required>
                                                    </td>
                                                    <td style="width: 120px">
                                                        <input type="number" min="0.01" step="0.01" class="form-control SalesPrice" name="SalesPrice[]" value="{{$item->Sales_Price}}" readonly>
                                                    </td>
                                                    <td style="width: 120px">
                                                        <input type="number" class="form-control SalesTaxSlab" name="SalesTaxSlab[]" value="{{$item->SalesTaxSlab}}" readonly>
                                                    </td>
                                                    <td style="width: 120px">
                                                        <input type="number" class="form-control SalesTaxAmount" name="SalesTaxAmount[]" value="{{$item->SalesTaxAmount}}" readonly>
                                                    </td>
                                                    <td style="width: 200px">
                                                        <input type="text" class="form-control SalesSubTotal" name="SalesSubTotal[]" value="{{$item->SalesSubTotal}}" readonly>
                                                    </td>
                                                    <td style="width: 60px">
                                                        <span class=" btn btn-sm btn-danger rounded-3 btnSpan DelProduct" value="{{$item->id}}"><i class="fas fa-times mt-2 btnI"></i></span>
                                                        <span class=" btn btn-sm btn-success rounded-3 btnSpan AddMoreProduct" style="display: none"><i class="fas fa-plus mt-2 btnI"></i></span>
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
                                                    <input type="text" class="form-control" name="TotalSubTotal" id="TotalSubTotal" placeholder="Total SubTotal" value="{{$sales_overview[0]->Total_SubTotal}}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <label style="float: right;">Total Tax Amount:</label>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" class="form-control" name="TotalTaxAmount" id="TotalTaxAmount" placeholder="Tax Amount" value="{{$sales_overview[0]->Total_Tax_Amount}}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <label style="float: right;margin-top:49px">Discount:</label>
                                                </td>
                                                <td colspan="3">
                                                    <label>Discount Percentage:</label>
                                                    <br>
                                                    <input type="text" class="form-control" name="DiscountPer" id="DiscountPer" placeholder="Discount Percentage" value="{{$sales_overview[0]->Discount_Per}}">
                                                    <label>Discount Amount:</label>
                                                    <br>
                                                    <input type="text" class="form-control" name="DiscountAmount" id="DiscountAmount" placeholder="Discount Amount" value="{{$sales_overview[0]->Discount_Amount}}" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <label style="float: right;">Total Amount:</label>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" class="form-control" name="TotalAmount" id="TotalAmount" placeholder="Total Amount" value="{{$sales_overview[0]->Total_Amount}}" readonly>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- card-2-------------------------------------------------------------------- --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 style="display: flex">Total <div id="Total" class="ml-2">{{$sales_overview[0]->Total_Amount}}</div>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="Radio">
                                <h6><b>Payment Method:</b></h6>
                                {{-- radio options --}}
                                <div class="form-group">
                                    <input type="hidden" id="Pay_Meth" name="Pay_Meth" value="{{$sales_overview[0]->Payment_Method}}">
                                    <input type="radio" value="Cash" name="Payment_Radio" class="Payment_Radio ml-4 mt-2" id="Cash_Radio" required>
                                    <label for="Cash_Radio">Cash</label>
                                    <input type="radio" value="Card" name="Payment_Radio" class="Payment_Radio ml-4 mt-2" id="Card_Radio" required>
                                    <label for="Card_Radio">Card</label>
                                    <input type="radio" value="UPI" name="Payment_Radio" class="Payment_Radio ml-4 mt-2" id="UPI_Radio" required>
                                    <label for="UPI_Radio">UPI</label>
                                    <input type="radio" value="Credit" name="Payment_Radio" class="Payment_Radio ml-4 mt-2" id="Credit_Radio" required>
                                    <label for="Credit_Radio">Credit</label>
                                </div>
                            </div>
                            <div id="Cash_Details" style="display: none">
                                <h6><b>Amount Paid:</b></h6>
                                <input type="number" min="1" class="form-control" id="Amount_Paid" name="Amount_Paid" value="{{$sales_overview[0]->Amount_Paid}}">
                                <h6><b>Returning Change</b></h6>
                                <input type="text" class="form-control" id="Returning_Change" name="Returning_Change" value="{{$sales_overview[0]->Returning_Change}}" readonly>
                            </div>
                            <div id="Card_Details" style="display: none">
                                <label for="Card_Details_BankName"><b>Bank Name:</label>
                                <input type="text" class="form-control" id="Card_Details_BankName" name="Card_Details_BankName" value="{{$sales_overview[0]->Card_BankName}}">
                                <label for="Card_Details_Name"><b>CardHolder's Name:</label>
                                <input type="text" class="form-control" id="Card_Details_Name" name="Card_Details_Name" value="{{$sales_overview[0]->Card_OwnerName}}">
                                <label for="Card_Details_Number"><b>Card Number:</label>
                                <input type="number" class="form-control" id="Card_Details_Number" name="Card_Details_Number" value="{{$sales_overview[0]->Card_Number}}">
                            </div>
                            <div id="UPI_Details" style="display: none">
                                <label for="UPI_Details_WalletName">Wallet Name:</label>
                                <input type="text" class="form-control" id="UPI_Details_WalletName"
                                    name="UPI_Details_WalletName" placeholder="Example:Gpay,PayTM,AmazonPay,PhonePe etc" value="{{$sales_overview[0]->UPI_WalletName}}">
                                <label for="UPI_Details_TransactionId">Transaction ID:</label>
                                <input type="text" class="form-control" id="UPI_Details_TransactionId" name="UPI_Details_TransactionId" value="{{$sales_overview[0]->UPI_TransactionId}}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <input type="Submit" class="btn btn-success btn-lg" id="AddSale" value="Add Sale" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            //adding contact info for preselected customer
            var contact = $('#Customer_Id :selected').data('contact');
            $('#Contact').val(contact);

            //adding contact info on selection of customer name
            $('#Customer_Id').on('change', function() {
                var contact = $('#Customer_Id :selected').data('contact');
                // console.log(contact);
                $('#Contact').val(contact);
            });

            $(document).ready(function() {
                //initialise select 2
                $('.select2').select2();

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                //remove class of red cross and add classes of green plus to the last row of tbody
                $('#Sales_Table tbody tr:last td:last .AddMoreProduct').css('display', 'inline-block');

                //final total values calculation function
                function TotalCalculate() {
                    //calculating total of sub total
                    var TotalAmount = 0;
                    $('.SalesSubTotal').each(function() {
                        if (isNaN($(this).val()) || $(this).val() == '') {
                            var pst = 0;
                            // alert("purchase subtotal is NAN");
                        } else {
                            pst = $(this).val();
                        }
                        TotalAmount = parseFloat(TotalAmount) + parseFloat(pst);
                    });
                    $('#TotalSubTotal').val("");
                    $('#TotalSubTotal').val(isNaN(TotalAmount.toFixed(2)) ? 0 : TotalAmount.toFixed(
                        2)); //add total value in tfoot

                    $('#TotalAmount').val("");
                    $('#TotalAmount').val(isNaN(TotalAmount.toFixed(2)) ? 0 : TotalAmount.toFixed(
                        2)); ///add total value in Grand_total
                    $("#Total").val('');
                    $('#Total').val(isNaN(TotalAmount.toFixed(2)) ? 0.00 : TotalAmount.toFixed(
                        2)); //add total value to second card total div

                    //calculating total tax amount
                    var TotalTaxAmount = 0;
                    $('.SalesTaxAmount').each(function() {
                        if (isNaN($(this).val()) || $(this).val() == '') {
                            var pta = 0;
                            // alert("purchase subtotal is NAN");
                        } else {
                            pta = $(this).val();
                        }
                        TotalTaxAmount = parseFloat(TotalTaxAmount) + parseFloat(pta);
                    });
                    $('#TotalTaxAmount').val("");
                    $('#TotalTaxAmount').val(isNaN(TotalTaxAmount.toFixed(2)) ? 0 : TotalTaxAmount.toFixed(2)); //add total tax value in tfoot

                    //calculate discount on change of subtotal
                    var disper = $('#DiscountPer').val();
                    var amountBeforeDis = $('#TotalSubTotal').val();
                    disAmt = parseFloat((amountBeforeDis * disper) / 100);
                    $('#DiscountAmount').val(disAmt.toFixed(2));
                    console.log("discount amount on change" + disAmt);

                    // calculate final total value
                    var dis = $('#DiscountAmount').val();
                    if (dis <= 0 || isNaN(dis)) {
                        dis = 0;
                    }
                    if (TotalAmount <= 0 || isNaN(TotalAmount)) {
                        TotalAmount = 0;
                    }
                    if (TotalTaxAmount <= 0 || isNaN(TotalTaxAmount)) {
                        TotalTaxAmount = 0;
                    }
                    var ta = parseFloat(TotalAmount) + parseFloat(TotalTaxAmount) - parseFloat(dis);
                    $('#TotalAmount').val(isNaN(ta.toFixed(2)) ? 0 : ta.toFixed(
                        2)); //set final value of total amount with tax and discount

                    //set final total value in 2nd card total div
                    $("#Total").text('');
                    $('#Total').text(isNaN(ta.toFixed(2)) ? 0.00 : ta.toFixed(2));
                    console.log("Total div"+$('#Total').text());
                }

                var count = $('#Total_Products').val(); //initialize counter variable to count number of rows/products ordered
                $(document).on('click', '.AddMoreProduct', function(e) {
                    e.preventDefault();
                    $('#Sales_Table tbody').append('<tr>\
                                                            <td>\
                                                                <input type="hidden" name="RowId[]" class="RowId" value="0">\
                                                                <div class="form-group">\
                                                                    <select name="SalesProduct[]" class="form-control select2 select2bs4 select2-danger SalesProduct" data-dropdown-css-class="select2-danger" style="width: 100%;" required>\
                                                                        <option value=\
                                                                        "">open to select product</option>\
                                                                        @foreach ($pro as $Product_Item)\
                                                                            <option value="{{ $Product_Item->id }}" data-MRP="{{ $Product_Item->MRP }}" data-TaxSlab="{{$Product_Item->TaxSlab}}">{{ $Product_Item->Name }}</option>\
                                                                        @endforeach\
                                                                    </select>\
                                                                </div>\
                                                            </td>\
                                                            <td style="width: 120px">\
                                                                <input type="number" min="1" class="form-control SalesQuantity" name="SalesQuantity[]" required>\
                                                            </td>\
                                                            <td style="width: 120px">\
                                                                <input type="number" min="0.01" step="0.01" class="form-control SalesPrice" name="SalesPrice[]" readonly>\
                                                            </td>\
                                                            <td style="width: 120px">\
                                                                <input type="number" class="form-control SalesTaxSlab" name="SalesTaxSlab[]" readonly>\
                                                            </td>\
                                                            <td style="width: 120px">\
                                                                <input type="number" class="form-control SalesTaxAmount" name="SalesTaxAmount[]" readonly>\
                                                            </td>\
                                                            <td style="width: 200px">\
                                                                <input type="text" class="form-control SalesSubTotal" name="SalesSubTotal[]" readonly>\
                                                            </td>\
                                                            <td style="width: 60px">\
                                                                <span class=" btn btn-sm btn-danger rounded-3 btnSpan DelProduct" value="0"><i class="fas fa-times mt-2 btnI"></i></span>\
                                                                <span class=" btn btn-sm btn-success rounded-3 btnSpan AddMoreProduct" style="display: none"><i class="fas fa-plus mt-2 btnI"></i></span>\
                                                            </td>\
                                                        </tr>');
                    count = parseInt(count) + 1;
                    console.log("No of rows:" + count);

                    //initialise select 2
                    $('.select2').select2();

                    //Initialize Select2 Elements
                    $('.select2bs4').select2({
                        theme: 'bootstrap4'
                    });
                    //remove class of red cross and add classes of green plus to the last row of tbody
                    $('#Sales_Table tbody tr:last td:last .AddMoreProduct').css('display', 'inline-block');
                    $(this).css('display', 'none');
                });

                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //delete row functionality with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                $(document).on('click', '.DelProduct', function (e){
                    e.preventDefault();
                    var row = $(this).closest('tr');
                    var row_id = row.find('.DelProduct').attr('value');console.log(row_id);
                    var name = row.find('.SalesProduct :selected').attr('data-name');

                    if(row_id>0)
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
                            //sweet alert
                            swal("Alert","Are You sure want to delete "+name+" sale product with id "+row_id+" !?","warning",{
                                buttons:{
                                    cancel: "Cancel",
                                    yes: "Yes! Delete"
                                }}).then((value)=>{
                                    switch(value){
                                        case "yes":
                                            $.ajax({
                                                type: "DELETE",
                                                url: "/DeleteSalesDetails/"+row_id,
                                                success: function (response) {
                                                    row.remove();
                                                    console.log("After Del Row: " + count);
                                                    swal("Great",response.message,"success",{button:"OK"});
                                                    TotalCalculate();
    
                                                    //remove class of red cross and add classes of green plus to the last row of tbody
                                                    $('#Sales_Table tbody tr:last td:last .AddMoreProduct').css('display', 'inline-block');
                                                },
                                                error: function (response) {
                                                    console.log('Error:', response);
                                                    swal("Something went wrong","warning",{button:"OK"});
                                                }
                                            });
                                            break;
                                        default: 
                                            swal(name+" Category Not Deleted!!","","warning");
                                            break;
                                    }
                                })
                        }
                    }
                    else
                    {
                        $(this).closest('tr').remove();
                        //remove class of red cross and add classes of green plus to the last row of tbody
                        $('#Sales_Table tbody tr:last td:last .AddMoreProduct').css('display', 'inline-block');
                        TotalCalculate();
                    }
                });

                //setting value of mrp and tax on change of product and calculate subtotal taxamount
                $(document).on('change', '.SalesProduct', function() {
                    var row = $(this).closest('tr');
                    // var mrp = row.find('.SalesProduct :selected').attr('data-MRP');
                    var mrp = $(this).find(':selected').attr('data-mrp');
                    // console.log("mrp"+mrp);
                    var taxslab = $(this).find(':selected').attr('data-TaxSlab');
                    // console.log(taxslab);
                    row.find('.SalesPrice').val(mrp);
                    row.find('.SalesTaxSlab').val(taxslab);

                    //calculate subtotal on entering price
                    var row = $(this).closest('tr');
                    var price = row.find('.SalesPrice').val();
                    var qty = row.find('.SalesQuantity').val();

                    var subTotal = qty * parseFloat(price);
                    console.log(qty + '\t' + price + '\t' + subTotal);
                    row.find(".SalesSubTotal").val(isNaN(subTotal.toFixed(2)) ? 0 : subTotal.toFixed(2));

                    //calculating tax amount
                    var taxslab = row.find('.SalesTaxSlab').val();
                    taxAmt = parseFloat((taxslab * price * qty) / 100);
                    row.find('.SalesTaxAmount').val(isNaN(taxAmt.toFixed(2)) ? 0 : taxAmt.toFixed(2));
                    TotalCalculate();
                });
        
                //calculate subtotal on entering quantity
                $(document).on('input', '.SalesQuantity', function() {
                    var row = $(this).closest('tr');
                    var price = row.find('.SalesPrice').val();
                    var qty = row.find('.SalesQuantity').val();

                    var subTotal = qty * parseFloat(price);
                    console.log(qty + '\t' + price + '\t' + subTotal);
                    row.find(".SalesSubTotal").val(isNaN(subTotal.toFixed(2)) ? 0 : subTotal.toFixed(2));

                    //calculating tax amount
                    var taxslab = row.find('.SalesTaxSlab').val();
                    taxAmt = parseFloat((taxslab * price * qty) / 100);
                    row.find('.SalesTaxAmount').val(isNaN(taxAmt.toFixed(2)) ? 0 : taxAmt.toFixed(2));
                    // console.log(taxAmt);
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
            });

            //making changing in inputs as per radio button values
            $('.Payment_Radio').on('click', function() {
                var radioVal = $('.Payment_Radio:checked').val();
                console.log(radioVal);
                if (radioVal == 'Card') {
                    $('#Card_Details').css('display', 'block');
                    $('#Cash_Details').css('display', 'none');
                    $('#UPI_Details').css('display', 'none');
                    
                    //making other two inputs empty
                    $('#Cash_Details input').val("");
                    $("#UPI_Details input").val("");
                    
                    //making card input fields required
                    $('#Card_Details input').attr('required',true);
                    
                    //making other input fields not required
                    $('#Cash_Details input').attr('required',false);
                    $('#UPI_Details input').attr('required',false);
                } else if (radioVal == 'UPI') {
                    $('#UPI_Details').css('display', 'block');
                    $('#Cash_Details').css('display', 'none');
                    $('#Card_Details').css('display', 'none');
                    
                    //making other two inputs empty
                    $('#Cash_Details input').val("");
                    $("#Card_Details input").val("");
                    
                    //making upi input feilds required
                    $('#UPI_Details input').attr('required',true);
                    
                    //making other input fields not required
                    $('#Cash_Details input').attr('required',false);
                    $('#Card_Details input').attr('required',false);
                }else if(radioVal== 'Cash'){
                    $('#Cash_Details').css('display', 'block');
                    $('#Card_Details').css('display', 'none');
                    $('#UPI_Details').css('display', 'none');
                    
                    //making other two inputs empty
                    $('#Card_Details input').val("");
                    $("#UPI_Details input").val("");
                    
                    //making cash input fields required
                    $('#Cash_Details input').attr('required',true);
                    
                    //making other input fields not required
                    $('#Card_Details input').attr('required',false);
                    $('#UPI_Details input').attr('required',false);
                }else {
                    //making display of all blocks none on radio val 'credit'
                    $('#Cash_Details').css('display', 'none');
                    $('#Card_Details').css('display', 'none');
                    $('#UPI_Details').css('display', 'none');

                    //making other input fields not required
                    $('#Cash_Details input').attr('required',false);
                    $('#Card_Details input').attr('required',false);
                    $('#UPI_Details input').attr('required',false);

                    //making other inputs empty
                    $('#Card_Details input').val("");
                    $("#UPI_Details input").val("");
                    $("#Cash_Details input").val("");
                }
            });

            //calculating returning amount on input of paid amount
            $(document).on('input','#Amount_Paid',function(){
                var amountPaid = $(this).val();
                var total = $('#Total').text();
                var returning = parseFloat(amountPaid) - parseFloat(total);
                console.log(amountPaid+"\t"+total+"\t"+returning);
                $('#Returning_Change').val(returning.toFixed(2));
            });

            //Edit Scripts======================================================================
            var pay_meth = $('#Pay_Meth').val();
            console.log(pay_meth);
            $('#'+pay_meth+'_Radio').attr('checked',true);
            $('#'+pay_meth+'_Details').css('display','block');
        </script>
@endsection