@extends('layouts.admin')

@section('content')

    {{-- sweetalert.js --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Credits</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Credits</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @if (Session('status'))
        <script>
            swal('Success!',"{{Session::get('status')}}",'success',{button:'OK'});
        </script>
    @endif

    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3>KhataBook</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="Total_Credit box bg-danger p-2 m-1 rounded w-15 float-right text-center">
                    Total Credit: 
                    <span class="credit_val bg-danger p-2"><span class="bg-danger p-2">{{$Total_Credit}}</span>
                </div>
                <div class="Accept_Payment btn bg-success p-2 m-1 rounded w-15 float-left text-center" data-toggle="modal" data-target="#AcceptPaymentModal">
                    <span class="ion ion-plus-circled"></span>
                    Accept Payment
                </div>
                <div class="Accept_Payment btn bg-success p-2 m-1 rounded w-15 float-left text-center" data-toggle="modal" data-target="#AddCreditModal">
                    <span class="ion ion-plus-circled"></span>
                    Add Credit
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="Credit_Table">
                        <thead>
                            <th class="text-center">#</th>
                            <th class="text-center">Customer Name</th>
                            <th class="text-center">Customer Contact</th>
                            <th class="text-center">Credit Amount</th>
                            <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @php $count=1 @endphp
                            @foreach ($cust_credit as $item)
                                @if ($item->Credit>0)           
                                    <tr>
                                        <td class="text-center">{{$count}}</td>
                                        <td class="text-center">{{$item->Customer}}(Customer-id: {{$item->cust_id}})</td>
                                        <td class="text-center">{{$item->Contact}}</td>
                                        <td class="text-center">
                                            <span class="bg-danger p-2">{{$item->Credit}}</span>
                                        </td>
                                        <td class="text-center"><a href="{{url('viewStatement/'.$item->cust_id)}}"><i class="ion ion-eye btn btn-info"> View Statement</i></a></td>
                                    </tr> 
                                    @php $count++ @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- AcceptPaymentModal ---------------------------------------------------------------- --}}
    <div class="modal" id="AcceptPaymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Accept Payment</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <form action="acceptPayment" method="POST" id="editForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Date">1)Date:</label>
                                <input type="date" name="Date" id="Date" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Customer">2)Customer</label>
                                <Select class="form-control select2 select2bs4 select2-danger" name="Customer_Details" id="Customer_Details">
                                    <option value="">open this menu to select customer</option>
                                    @foreach ($customer as $item)
                                        <option value="{{$item->id}}">({{$item->id}}) {{$item->Customer_Name}} ({{$item->Contact}})</option>
                                    @endforeach
                                </Select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Amount">3)Amount:</label>
                                <input type="number" min="0.1" step="0.1" class="form-control" name="Amount" id="Amount">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Payment_Method">4)Payment_Method:</label>
                                <div class="radio form-group">
                                    <input type="radio" class="ml-5" id="Cash" name="Payment_Method" value="Cash">
                                    <label>Cash</label>
                                    <input type="radio" class="ml-2" id="Bank" name="Payment_Method" value="Bank">
                                    <label>Bank</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Note">5)Note:</label>
                                <textarea class="form-control" name="Note" id="Note" cols="30" rows="8"></textarea>
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

    {{-- AddCreditModal ---------------------------------------------------------------- --}}
    <div class="modal" id="AddCreditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Credit</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <form action="addCredit" method="POST" id="AddCreditForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Credit_Date">1)Date:</label>
                                <input type="date" name="Credit_Date" id="Credit_Date" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Credit_Customer">2)Customer</label>
                                <Select class="form-control select2 select2bs4 select2-danger" name="Credit_Customer_Details" id="Credit_Customer_Details">
                                    <option value="">open this menu to select customer</option>
                                    @foreach ($customer as $item)
                                        <option value="{{$item->id}}">({{$item->id}}) {{$item->Customer_Name}} ({{$item->Contact}})</option>
                                    @endforeach
                                </Select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Credit_Amount">3)Amount:</label>
                                <input type="number" min="0.1" step="0.1" class="form-control" name="Credit_Amount" id="Credit_Amount">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Credit_Note">5)Note:</label>
                                <textarea class="form-control" name="Credit_Note" id="Credit_Note" cols="30" rows="8"></textarea>
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

    {{-- script to use moment.js method to get by default today's date --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#Credit_Table').DataTable();

            //setting today's date by default in date column in payment modal
            var today = moment().format('YYYY-MM-DD');
            $('#Date').val(today);
            $('#Credit_Date').val(today);

            //initialise select 2
            $('.select2').select2();
        
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4' 
            });
        });
    </script>
@endsection