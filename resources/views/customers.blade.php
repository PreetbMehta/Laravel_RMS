@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    {{-- add customer-------------------------------------------------------------------- --}}
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3>Add Customer</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div id="error_message"></div>
            <form action="" method="post" id="AddCustomerForm">
                {{-- card-body --}}
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="Customer_Name">
                                1)Customer Name:
                            </label>
                            <input type="text" name="Customer_Name" id="Customer_Name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Contact">
                                2)Contact:
                            </label>
                            <input type="number" id="Contact" name="Contact" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Email_Id">
                                3)Email id:
                            </label>
                            <input type="email" id="Email_Id" name="Email_Id" class="form-control" required>
                        </div>
                    </div>
                </div>
                {{-- card-footer --}}
                <div class="card-footer">
                    <button type="Submit" class="btn btn-success btn-lg" id="Add_Customer">Add customer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- customer-table--------------------------------------------------------------------- --}}
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Customer List</h3>

                <div class="card-tools">
                    <button class="btn btn-tool" data-card-widget="collapse" tittle="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="Customer-Table">
                    <thead>
                        <tr>
                            <th>Customer Id</th>
                            <th>Customer Name</th>
                            <th>Contact</th>
                            <th>Email id</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- #EditCustomerModal ---------------------------------------------------------------------------- --}}
    <div class="modal" tabindex="-1" id="EditCustomerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="edit_error_message"></div>
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="Edit_id">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Edit_Customer_Name">
                                    <b>1)Customer Name:</b>
                                </label>
                                <input type="text" name="Edit_Customer_Name" id="Edit_Customer_Name" 
                                    class="form-control" required>              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Edit_Contact">
                                    <b>1)Contact:</b>
                                </label>
                                <input type="text" name="Edit_Contact" id="Edit_Contact" 
                                    class="form-control" required>              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Edit_Email_Id">
                                    <b>1)Email Id:</b>
                                </label>
                                <input type="text" name="Edit_Email_Id" id="Edit_Email_Id" 
                                    class="form-control" required>              
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

    <script>
        $(function() {

            //sweet-alert-library
            function Success_Sweet_Alert(response_alert) {
                swal("Great Job", response_alert, "success", {
                    button: 'OK'
                });
            }

            //ajax-setup>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ajax fetch>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            var table = $('#Customer-Table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('customers.index') }}",
                columns : [
                    {data:'id',name:'id',orderable:false,searchable:false},
                    {data:'Customer_Name',name:'Customer_Name'},
                    {data: 'Contact',name: 'Contact'},
                    {data: 'Email_Id',name: 'Email_Id'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                // order: [ [0, 'desc'] ]
            });

            // ajax-store data>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $('#Add_Customer').on('click', function(e) {
                e.preventDefault();
                $(this).html('Sending...');

                var data_to_store = {
                    'Customer_Name': $('#Customer_Name').val(),
                    'Contact': $('#Contact').val(),
                    'Email_Id': $('#Email_Id').val()
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('customers.store') }}",
                    data: data_to_store,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) 
                        {
                            $('#error_message').html('');
                            $('#error_message').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#error_message').append('<li>' + err_values +
                                    '</li>');
                            });
                            $('#Add_Customer').html('Add customer');
                        } 
                        else
                        {
                            $('#error_message').html('');
                            $('#error_message').removeClass('alert alert-danger');
                            $('#AddCustomerForm').trigger('reset');
                            table.draw();
                            $('#Add_Customer').html('Add customer');
                            Success_Sweet_Alert(response.message);
                        }
                    }
                });
            });

            // update data with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $('#EditChanges').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
                var customer_id = $('#Edit_id').val();
            
                var data_to_update = {
                    'Customer_Name':$('#Edit_Customer_Name').val(),
                    'Contact':$('#Edit_Contact').val(),
                    'Email_Id':$('#Edit_Email_Id').val(),
                }
                $.ajax({
                    type: "PUT",
                    url: "customers/"+ customer_id,
                    data: data_to_update,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 400) 
                        {
                            $('#edit_error_message').html('');
                            $('#edit_error_message').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#edit_error_message').append('<li>' + err_values +
                                    '</li>');
                            });
                            $('#EditChanges').html('Edit customer');
                        } 
                        else
                        {
                            $('#editForm').trigger("reset");
                            $('#EditCustomerModal').modal('hide');
                            table.draw(false);
                            Success_Sweet_Alert(response.message);
                            $('#EditChanges').html('Save Changes');
                        }
                    },
                    error: function (response) {
                        console.log('Error:',response);
                        swal("Something went wrong","warning",{button:"OK"});
                        $('#EditChanges').html('Save Changes');
                    }
                });
            });

            //delete data with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $(document).on('click', '.deleteBtn', function (){
            var customer_id = $(this).val();
            var name = $(this).parent().parent().children().eq(1).text();
            //sweet alert
            swal("Are You sure want to delete "+name+" category with id "+customer_id+" !?","","warning",{
                buttons:{
                    cancel: "Cancel",
                    yes: "Yes! Delete"
                }}).then((value)=>{
                    switch(value){
                        case "yes":
                            $.ajax({
                                type: "DELETE",
                                url: "customers/"+customer_id,
                                success: function (response) {
                                    Success_Sweet_Alert(response.message);
                                    table.draw(false);
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
            });

            //fetch data in edit modal
            $(document).on('click','.editBtn',function(e){
                e.preventDefault(e);

                var id = $(this).val();
                console.log(id);
                $('#Edit_id').val(id);

                var name = $(this).parent().parent().children().eq(1).text();
                $('#Edit_Customer_Name').val(name);

                var contact = $(this).parent().parent().children().eq(2).text();
                $('#Edit_Contact').val(contact);

                var email = $(this).parent().parent().children().eq(3).text();
                $('#Edit_Email_Id').val(email);

            });
        });
    </script>
@endsection
