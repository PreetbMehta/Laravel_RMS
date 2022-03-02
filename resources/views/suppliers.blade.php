@extends('layouts.admin')

@section('content')
    <!-- JQuery DataTables css-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    {{-- Session Message --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('status') }}
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
                    <h1 class="m-0">Suppliers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Suppliers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Add supplier form--------------------------------------------------------------------------------->
    <div class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3>Add Supplier</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="server_message"></div>
            <div class="card-body">
                <form action={{ route('suppliers.store') }} method="POST" id="add_supplier_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="SupplierName">
                                <b>1) Supplier Name:</b>
                            </label>
                            <input type="text" name="Supplier_Name" id="Supplier_Name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="BrandName">
                                <b>2) Brand Name:</b>
                            </label>
                            <input type="text" name="Brand_Name" id="Brand_Name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Address">
                                <b>3) Address:</b>
                            </label>
                            <input type="text" name="Address" id="Address" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Contact">
                                <b>4) Contact:</b>
                            </label>
                            <input type="number" name="Contact" id="Contact" class="form-control" required>
                            @error('Contact')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="GSTNO">
                                <b>5) GST No:</b>
                            </label>
                            <input type="text" name="GST_No" id="GST_No" class="form-control" required>
                            @error('GST_No')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="EmailId">
                                <b>6) Email_Id:</b>
                            </label>
                            <input type="email" name="Email_Id" id="Email_Id" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="AccountNO">
                                <b>7)AccounT No:</b>
                            </label>
                            <input type="text" name="Account_No" id="Account_No" class="form-control" required>
                            @error('Account_No')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="IFSCCode">
                                <b>8) IFSC Code:</b>
                            </label>
                            <input type="text" name="IFSC_Code" id="IFSC_Code" class="form-control" required>
                            @error('IFSC_Code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="Submit" class="btn btn-success btn-lg" id="add_Supplier">Add Supplier</button>
            </div>
            <!-- /.card-footer-->
            </form>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.content -->

    <!-- Fetch and display suppliers------------------------------------------------------------------------------>
    <div class="content">
        <div class="card">
            {{-- <div class="card-header"><a href="#" class="btn btn-dark" style="float: right" data-toggle="modal" data-target="#Add-Supplier-Modal"><i class="fa fa-plus">Add Supplier</i></a></div> --}}
            <div class="card-header">
                <h3 class="mb-0">Supplier List</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="Supplier-Table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Supplier_id</th>
                            <th>Supplier Name</th>
                            <th>Brand Name</th>
                            <th>Address</th>
                            <th>Contact no.</th>
                            <th>Email id</th>
                            <th>GST no.</th>
                            <th>Account no.</th>
                            <th>IFSC code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="Sup_Tab_Body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- #EditSupModal ---------------------------------------------------------------------------- --}}
    <div class="modal" tabindex="-1" id="EditSupplierModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div id="error_messages"></div>
                <!--server error messages-->
                <form action="" method="POST" id="EditForm">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="SupplierName">
                                    <b>1) Supplier Name:</b>
                                </label>
                                <input type="text" name="Edit_Supplier_Name" id="Edit_Supplier_Name" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="BrandName">
                                    <b>2) Brand Name:</b>
                                </label>
                                <input type="text" name="Edit_Brand_Name" id="Edit_Brand_Name" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Address">
                                    <b>3) Address:</b>
                                </label>
                                <input type="text" name="Edit_Address" id="Edit_Address" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Contact">
                                    <b>4) Contact:</b>
                                </label>
                                <input type="text" name="Edit_Contact" id="Edit_Contact" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="GSTNO">
                                    <b>5) GST No:</b>
                                </label>
                                <input type="text" name="Edit_GST_No" id="Edit_GST_No" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="EmailId">
                                    <b>6) Email_Id:</b>
                                </label>
                                <input type="email" name="Edit_Email_Id" id="Edit_Email_Id" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AccountNO">
                                    <b>7)Account No:</b>
                                </label>
                                <input type="text" name="Edit_Account_No" id="Edit_Account_No" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="IFSCCode">
                                    <b>8) IFSC Code:</b>
                                </label>
                                <input type="text" name="Edit_IFSC_Code" id="Edit_IFSC_Code" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="UpdateChanges" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Scripts-------------------------------------------------------------------------- --}}

    <!-- JQuery DataTable JS-->
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <!--JQUERY DATATABLE SCRIPT-->
    <script>
        function Success_Sweet_Alert(response_alert) {
            swal("Great Job", response_alert, "success", {
                button: "OK"
            });
        }
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"').attr('content')
                }
            });
            //ajax fetch data>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            var table = $('#Supplier-Table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('suppliers.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Supplier_Name',
                        name: 'Supplier_Name'
                    },
                    {
                        data: 'Brand_Name',
                        name: 'Brand_Name'
                    },
                    {
                        data: 'Address',
                        name: 'Address'
                    },
                    {
                        data: 'Contact',
                        name: 'Contact'
                    },
                    {
                        data: 'Email_Id',
                        name: 'Email_Id'
                    },
                    {
                        data: 'GST_No',
                        name: 'GST_No'
                    },
                    {
                        data: 'Account_No',
                        name: 'Account_No'
                    },
                    {
                        data: 'IFSC_Code',
                        name: 'IFSC_Code'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                // order: [ [0, 'desc'] ]
            });

            //ajax add-data>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $('#add_Supplier').on('click', function(e) {
                e.preventDefault();
                $('.server_message').html("");
                $('.server_message').removeClass('alert alert-danger');
                var data = {
                    'Supplier_Name': $('#Supplier_Name').val(),
                    'Brand_Name': $('#Brand_Name').val(),
                    'Address': $('#Address').val(),
                    'Contact': $('#Contact').val(),
                    'Email_Id': $('#Email_Id').val(),
                    'GST_No': $('#GST_No').val(),
                    'Account_No': $('#Account_No').val(),
                    'IFSC_Code': $('#IFSC_Code').val()
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('suppliers.store') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 400) {
                            $('.server_message').html("");
                            $('.server_message').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('.server_message').append('<li>' + err_values +
                                    '</li>');
                            });
                        } else {
                            $('#add_supplier_form').trigger('reset');
                            table.draw();
                            Success_Sweet_Alert(response.message);
                        }
                    },
                    error: function(response) {
                        console.log('Error: ', response);
                        swal("Something went wrong", "warning", {
                            button: "OK"
                        });
                    }
                });

            });

            //ajax update data>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $(document).on('click', '#UpdateChanges', function(e) {
                e.preventDefault();
                $(this).html('Sending...')

                var sup_id = $('.editBtn').val();
                var Up_data = {
                    'Supplier_Name': $('#Edit_Supplier_Name').val(),
                    'Brand_Name': $('#Edit_Brand_Name').val(),
                    'Address': $('#Edit_Address').val(),
                    'Contact': $('#Edit_Contact').val(),
                    'Email_Id': $('#Edit_Email_Id').val(),
                    'GST_No': $('#Edit_GST_No').val(),
                    'Account_No': $('#Edit_Account_No').val(),
                    'IFSC_Code': $('#Edit_IFSC_Code').val()
                }
                $.ajax({
                    type: "PUT",
                    url: "suppliers/" + sup_id,
                    data: Up_data,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 400) {

                            $('#error_messages').html("");
                            $('#error_messages').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#error_messages').append('<li>' + err_values +
                                    '</li>');
                            });
                            $('#UpdateChanges').html('Save Changes');
                        } else {
                            // $('.server_suc_message').html("");
                            $('#EditForm').trigger('reset');
                            $('#EditSupplierModal').modal('hide');
                            table.draw(false);
                            Success_Sweet_Alert(response.message);
                            $('#UpdateChanges').html('Save Changes');
                        }
                    }
                });
            });

            //ajax Delete data>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $(document).on('click', '.deleteBtn', function() {
                var Supplier_id = $(this).val();
                var Sup_Name = $(this).parent().parent().children().eq(1).text();
                swal("Are You sure want to delete " + Sup_Name + " with id number" + Supplier_id + "?", "",
                    "warning", {
                        buttons: {
                            cancel: "cancel",
                            yes: "Yes! Delete"
                        }
                    }).then((value) => {
                    switch (value) {
                        case "yes":
                            $.ajax({
                                type: "DELETE",
                                url: "suppliers/" + Supplier_id,
                                success: function(response) {
                                    Success_Sweet_Alert(response.message);
                                    table.draw(false);
                                },
                                error: function(response) {
                                    console.log('Error:', response);
                                    swal("Something went wrong", "warning", {
                                        button: "OK"
                                    });
                                }
                            });
                            break;
                        default:
                            swal(Sup_Name + " not Deleted","","warning");
                            break;
                    }
            });
        });
        //fetch data in edit modal
        $(document).on('click', '.editBtn', function(e) {
            e.preventDefault(); //to stop anchor tag to redirect to href

            //fetching data in edit modal
            var id = $(this).parent().parent().children().eq(0).text(); //getting supllier-id
            $('#Edit_Item_Id').val(id);
            // console.log(id);

            var sup_name = $(this).parent().parent().children().eq(1).text();
            $('#Edit_Supplier_Name').val(sup_name); //getting supplier name
            // console.log(sup_name);

            var brand_name = $(this).parent().parent().children().eq(2).text();
            $('#Edit_Brand_Name').val(brand_name); //getting brand name
            // console.log(brand_name);

            var address = $(this).parent().parent().children().eq(3).text();
            $('#Edit_Address').val(address); //getting Address
            // console.log(address);

            var Contact = $(this).parent().parent().children().eq(4).text();
            $('#Edit_Contact').val(Contact); //getting supplier contact
            // console.log(Contact);

            var email = $(this).parent().parent().children().eq(5).text();
            $('#Edit_Email_Id').val(email); //getting supplier email
            // console.log(email);

            var gst = $(this).parent().parent().children().eq(6).text();
            $('#Edit_GST_No').val(gst); //getting supplier gst
            // console.log(gst);

            var account = $(this).parent().parent().children().eq(7).text();
            $('#Edit_Account_No').val(account); //getting supplier account
            // console.log(account);

            var IFSC = $(this).parent().parent().children().eq(8).text();
            $('#Edit_IFSC_Code').val(IFSC); //getting supplier ifsc
            // console.log(IFSC);
        });
        });
    </script>

@endsection
