@extends('layouts.admin')

@section('content')

    <!-- JQuery DataTables css-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Categories</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    {{-- Add Category---------------------------------------------------------------------- --}}
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3>Add Category</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="error_message"></div>
                <form action={{ route('categories.store') }} method="post" id="addCatForm">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>
                                    <h5>Title</h5>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="Name" id="Name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="align-content: center">
                        <input type="Submit" class="btn btn-info" value="Add Category" id="AddCategory">
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Category table-------------------------------------------------------------------- --}}
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Category List</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="Category-Table">
                    <thead>
                        <tr>
                            <th style="text-align: center">Id</th>
                            <th style="text-align:center">Name</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- #EditCategoriesModal ---------------------------------------------------------------------------- --}}
    <div class="modal" tabindex="-1" id="EditCategoryModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div id="Edit_error_message"></div>
                        <div class="row">
                            <input type="hidden" name="id" id="Edit_id">
                            <div class="col-md-6">
                                <label for="Edit_Name">
                                    <b>1)Category Name:</b>
                                </label>
                                <input type="text" name="Edit_Name" id="Edit_Name" 
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

    {{-- Scripts-------------------------------------------------------------------------- --}}

    <!-- JQuery DataTable JS-->
    {{-- <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script> --}}

    <!--JQUERY DATATABLE SCRIPT-->
    <script>
        $(function(){
            function Success_Sweet_Alert(response_alert)
            {
                swal("Great Job",response_alert,"success",{button:"OK"});
            }
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //fetchData through ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            var table = $('#Category-Table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                columns : [
                    {data:'id',name:'id',orderable:false,searchable:false},
                    {data:'Name',name:'Name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                // order: [ [0, 'desc'] ]
            });

             //store data with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
             $('#AddCategory').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
            
                var data_to_store = {
                    'Name':$('#Name').val()
                }
                $.ajax({
                    type: "POST",
                    url: "{{route('categories.store')}}",
                    data: data_to_store,
                    dataType: 'json',
                    success: function (response) {
                        if(response.status==400)
                        {
                            $('#error_message').html("");
                            $('#error_message').addClass("alert alert-danger");
                            $.each(response.errors, function (key, err_values) { 
                                $('#error_message').append("<li>"+err_values+"</li>");
                            });
                        }
                        else
                        {
                            $('#error_message').html("");
                            $('#error_message').removeClass("alert alert-danger");
                            $('#addCatForm').trigger("reset");
                            table.draw();
                            $('#AddCategory').html('Add Category');
                            Success_Sweet_Alert(response.message);
                        }
                    },
                    error: function (response) {
                        console.log('Error:', response);
                        swal("Something went wrong","warning",{button:"OK"});
                        $('#AddCategory').html('Save Changes');
                    }
                });
            });

            //update data with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $('#EditChanges').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
                var product_id = $('#Edit_id').val();
            
                var data_to_update = {
                    'id' : $('#Edit_id').val(),
                    'Name':$('#Edit_Name').val()
                }
                $.ajax({
                    type: "PUT",
                    url: "categories/"+ product_id,
                    data: data_to_update,
                    dataType: 'json',
                    success: function (response) {
                        if(response.status==400)
                        {
                            $('#Edit_error_message').html("");
                            $('#Edit_error_message').addClass("alert alert-danger");
                            $.each(response.errors, function (key, err_values) { 
                                $('#Edit_error_message').append("<li>"+err_values+"</li>");
                            });
                        }
                        else
                        {
                            $('#Edit_error_message').html("");
                            $('#Edit_error_message').removeClass("alert alert-danger");
                            $('#editForm').trigger("reset");
                            $('#EditCategoryModal').modal('hide');
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
            var category_id = $(this).val();
            var name = $(this).parent().parent().children().eq(1).text();
            //sweet alert
            swal("Are You sure want to delete "+name+" category with id "+category_id+" !?","","warning",{
                buttons:{
                    cancel: "Cancel",
                    yes: "Yes! Delete"
                }}).then((value)=>{
                    switch(value){
                        case "yes":
                            $.ajax({
                                type: "DELETE",
                                url: "categories/"+category_id,
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

            //fetch data in edit modal-----------------------------------------------------------
            $(document).on('click','.editBtn',function(e){
                e.preventDefault();//to stop anchor tag to redirect to href
                //fetching data in edit modal
                var id =  $(this).parent().parent().children().eq(0).text();
                $('#Edit_id').val(id);
                // console.log(id);
                var C =  $(this).parent().parent().children().eq(1).text();
                $('#Edit_Name').val(C);
                // console.log(C);

                var test = $(".side_Nav_Category").addClass('active');
                if(test){console.log("success");}
            });
        });
    </script>
@endsection
