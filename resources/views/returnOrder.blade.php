@extends('layouts.admin')

@section('content')

    <style>
        #OrderReturn_Table {
            table-layout: fixed;
            width: 100%;
            overflow: hidden;
            text-align: center;
        }
        #OrderReturn_Table th,td{
            overflow: hidden;
            text-align: center;
        }
        /* .DelProduct:focus, */
        .DelProduct:hover{
            transform: scale(1.25);
            margin: 1px;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Order</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><a href="#">Return Order</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <form action="{{route('returnOrder.store')}}" method="POST" id="SalesFrom">
        @csrf
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
                            <input type="hidden" value="{{$sales_overview[0]->id}}" name="Sales_Id" id="Sales_Id">
                            <div class="col-md-4">
                                <label for="Date_Of_Return">
                                    <b>Date Of Return:</b>
                                    <span style="color: red">*</span>
                                </label>
                                <input type="date" name="Date_Of_Return" id="Date_Of_Return" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="Customer_Name">
                                    <b>Customer Name:</b>
                                    <span style="color: red">*</span>
                                </label>
                                <input type="text" name="Customer_Name" id="Customer_Name" class="form-control" value='{{$sales_overview[0]->Customer_Name}}' readonly/>
                                <input type="hidden" name="Customer_Id" id="Customer_Id" class="form-control" value='{{$sales_overview[0]->Customer_Id}}' readonly/>
                            </div>
                            <div class="col-md-4">
                                <label for="Contact">
                                    <b>Contact No:</b>
                                </label>
                                <input type="text" name="Contact" id="Contact" class="form-control" value="{{$sales_overview[0]->Contact}}" readonly>
                            </div>
                        </div>
                        <div class="card mt-2 p-0">
                            <div class="card-body p-3 table-responsive">
                                <!-- table for adding ordered products -->
                                <table class="table table-bordered table-striped m-1 dtr-inline" id="OrderReturn_Table">
                                    <thead>
                                        <tr>
                                            <th>Product <span style="color: red">*</span></th>
                                            <th style="width: 100px">Quantity <span style="color: red">*</span></th>
                                            <th style="width: 120px">MRP <span style="color: red">*</span></th>
                                            <th style="width: 85px">Tax Slab(%)</th>
                                            <th style="width: 120px">Tax Amount</th>
                                            <th style="width: 120px">SubTotal</th>
                                            <th style="width: 60px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales_detail as $item)    
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" name="SalesProduct[]"
                                                            class="form-control SalesProduct" value="{{$item->Name}}" readonly/>
                                                        <input type="hidden" name="SalesProductId[]"
                                                            class="form-control SalesProduct" value="{{$item->Sales_Product}}" readonly/>
                                                    </div>
                                                </td>
                                                <td style="width: 120px">
                                                    <input type="number" min="1" class="form-control SalesQuantity"
                                                    name="SalesQuantity[]" value="{{$item->Sales_Quantity}}" min="1" max="{{$item->Sales_Quantity}}" required>
                                                    <input type="hidden" id="hiddenQuantity" value="{{$item->Sales_Quantity}}">
                                                </td>
                                                <td style="width: 120px">
                                                    <input type="number" min="0.01" step="0.01" class="form-control SalesPrice" name="SalesPrice[]" value="{{$item->Sales_Price}}" required>
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
                                                    <a tabindex="0" class=" btn btn-sm btn-danger rounded-3 btnSpan DelProduct" value="{{$item->id}}"><i class="fas fa-times mt-2 btnI"></i></a>
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
                                                <input type="text" class="form-control" name="DiscountPer" id="DiscountPer" placeholder="Discount Percentage" value="{{($sales_overview[0]->Discount_Per)?$sales_overview[0]->Discount_Per:0}}" readonly>
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
                        <h3 style="display: flex">Total 
                            <div id="Total" class="ml-2">{{ceil($sales_overview[0]->Total_Amount)}}</div>
                            <input type="hidden" name="Total" value="{{ceil($sales_overview[0]->Total_Amount)}}">
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="Radio">
                            <h6><b>Payment Method:</b></h6>
                            {{-- radio options --}}
                            <div class="form-group">
                                <input type="hidden" id="Pay_Meth" value="{{$sales_overview[0]->Payment_Method}}">
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
                            <input type="number" min="1" class="form-control" id="Amount_Paid" value="{{$sales_overview[0]->Amount_Paid}}" readonly>
                            <h6><b>Returning Change</b></h6>
                            <input type="text" class="form-control" id="Returning_Change"  value="{{$sales_overview[0]->Returning_Change}}" readonly>
                        </div>
                        <div id="Card_Details" style="display: none">
                            <label for="Card_Details_BankName"><b>Bank Name:</label>
                            <input type="text" class="form-control" id="Card_Details_BankName" value="{{$sales_overview[0]->Card_BankName}}" readonly>
                            <label for="Card_Details_Name"><b>CardHolder's Name:</label>
                            <input type="text" class="form-control" id="Card_Details_Name" value="{{$sales_overview[0]->Card_OwnerName}}">
                            <label for="Card_Details_Number"><b>Card Number:</label>
                            <input type="number" class="form-control" id="Card_Details_Number" value="{{$sales_overview[0]->Card_Number}}" readonly>
                        </div>
                        <div id="UPI_Details" style="display: none">
                            <label for="UPI_Details_WalletName">Wallet Name:</label>
                            <input type="text" class="form-control" id="UPI_Details_WalletName" placeholder="Example:Gpay,PayTM,AmazonPay,PhonePe etc" value="{{$sales_overview[0]->UPI_WalletName}}" readonly>
                            <label for="UPI_Details_TransactionId">Transaction ID:</label>
                            <input type="text" class="form-control" id="UPI_Details_TransactionId" value="{{$sales_overview[0]->UPI_TransactionId}}" readonly>
                        </div>
                        <div id="Return_div">
                            <label for="Return">Amount to be returned:</label>
                            <input type="text" name="Return" class="form-control" id="Return" value="{{ceil($sales_overview[0]->Total_Amount)}}" readonly>
                            <label for="Return_Amount">Amount Returned</label>
                            <input type="number" min="1" step="1" name="Return_Amount" id='Return_Amount' class="form-control" value="{{ceil($sales_overview[0]->Total_Amount)}}" required>
                            <h6><b>Return Method:</b></h6>
                            <div class="form-group">
                                <input type="radio" value="Cash" name="Return_Payment_Radio" class="Return_Payment_Radio ml-4 mt-2" id="Cash_Radio" required>
                                <label for="Cash_Radio">Cash</label>
                                <input type="radio" value="Bank" name="Return_Payment_Radio" class="Return_Payment_Radio ml-4 mt-2" id="Bank_Radio" required>
                                <label for="Card_Radio">Bank</label>
                                <input type="radio" value="Credit_Return" name="Return_Payment_Radio" class="Return_Payment_Radio ml-4 mt-2" id="CreditReturn_Radio" required>
                                <label for="CreditReturn_Radio">Credit Return</label>
                            </div>
                        </div>
                        <div class="Notes">
                            <label for="Notes">Note:</label>
                            <textarea name="Notes" id="Notes" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <input type="Submit" class="btn btn-success btn-lg" id="ReturnOrder" value="Return Order" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- script to use moment.js method to get by default today's date --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    <script>
        // using moment.js method to get by default today's date
        var today = moment().format('YYYY-MM-DD');
        $('#Date_Of_Return').val(today);

        $(document).ready(function() {

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
                    $('#Return').val(isNaN(TotalAmount) ? 0.00 : TotalAmount); //add total value to second card total div
                    $("#Return_Amount").val(isNaN(TotalAmount) ? 0.00 : TotalAmount);

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
                // var disper = $('#DiscountPer').val();
                //     var amountBeforeDis = $('#TotalSubTotal').val();
                //     disAmt = parseFloat((amountBeforeDis * disper) / 100);
                //     $('#DiscountAmount').val(disAmt.toFixed(2));
                //     console.log("discount amount on change" + disAmt);

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
                    2)); //set final value of total amount with tax

                //set final total value in 2nd card total div
                var tot = Math.ceil(ta.toFixed(2));
                $('#Return').val(isNaN(tot) ? 0.00 : tot);
                $("#Return_Amount").val(isNaN(tot) ? 0.00 : tot);
            
                // console.log("Total div"+$('#Total').text());
            }

            var count = $('#Total_Products').val(); //initialize counter variable to count number of rows/products ordered

            //delete row functionality>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $(document).on('click', '.DelProduct', function (e){
                e.preventDefault();
                var row = $(this).closest('tr');
                var row_id = row.find('.DelProduct').attr('value');console.log(row_id);
                var name = row.find('.SalesProduct :selected').attr('data-name');

                count-=1;
                console.log(count);
                if(count<=0)
                {
                    alert("All rows Can't be Deleted \n Minimum one row should be there");
                    count += 1;
                }
                else
                {
                    $(this).closest('tr').remove();
                    console.log("After Del Row: " + count);
                    TotalCalculate();
                }
            });
    
            //calculate subtotal on entering quantity
            $(document).on('input', '.SalesQuantity', function() {
                var row = $(this).closest('tr');
                var price = row.find('.SalesPrice').val();
                var qty = parseInt(row.find('.SalesQuantity').val());
                var maxqty = parseInt(row.find('.SalesQuantity').attr('max'));

                if(qty>maxqty)
                {
                    swal("Alert!","You have buyed only "+maxqty+" units of this so you can return that much only, Not more than that!","warning")
                    var oldQty = $('#hiddenQuantity').val();
                    row.find('.SalesQuantity').val(oldQty);
                }
                else
                {
                    var subTotal = qty * parseFloat(price);
                    console.log(qty + '\t' + price + '\t' + subTotal);
                    row.find(".SalesSubTotal").val(isNaN(subTotal.toFixed(2)) ? 0 : subTotal.toFixed(2));
    
                    //calculating tax amount
                    var taxslab = row.find('.SalesTaxSlab').val();
                    taxAmt = parseFloat((taxslab * price * qty) / 100);
                    row.find('.SalesTaxAmount').val(isNaN(taxAmt.toFixed(2)) ? 0 : taxAmt.toFixed(2));
                    // console.log(taxAmt);
                    TotalCalculate();
                }

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
            } else if(radioVal== 'Cash'){
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
        $('#'+pay_meth+'_Radio').attr('checked',true);//checking the radio as per val in db
        $('#'+pay_meth+'_Details').css('display','block');//making display block asper radio checked
        $('#Radio :radio:not(:checked)').attr('disabled', true);//disabling radios not checked
        //check credit return in Return method if payment method prior was credit
        if(pay_meth=='Credit')
        {
            $('#CreditReturn_Radio').attr('checked',true);
        }
    </script>
@endsection