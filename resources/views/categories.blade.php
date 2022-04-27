@extends('layouts.admin')

@section('content')

    <style>
        #Category-Table td, th{
            text-align: center;
        }
    </style>

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
                <table class="table table-bordered table-striped dataTable dtr-inline" id="Category-Table">
                    <thead>
                        <tr>
                            <th style="text-align: center">#</th>
                            <th style="text-align:center">Name</th>
                            <th style="text-align:center">Active Status</th>
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
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
                        <div class="row">
                            <label for="">10)Active Status:</label>
                            <div class="form-group radio">
                                <input type="radio" name="Active_Status" class="ml-3" id="Active" value="1">
                                <label for="Active">Active</label>
                                <input type="radio" name="Active_Status" class="ml-3" id="InActive" value="0">
                                <label for="InActive">InActive</label>
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
                dom: "<'row'<'col-sm-12 col-md-4' B><'col-sm-12 col-md-4 text-center'l><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

                    buttons: [

                        {
                            extend: 'print',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            exportOptions: {
                                columns: ':visible'
                            },
                            customize: function (win) {
                                $(win.document.body).css('font-size', '9pt').css('color', '#000000');
                                $(win.document.body).css('background', '#FFFFFF');
                                $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                            },
                            text : "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-printer' viewBox='0 0 16 16'><path d='M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z'/><path d='M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z'/></svg> Print"
                        },

                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            exportOptions: {
                                columns: ':visible'
                            },
                            
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':visible'
                            },
                            text : "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-spreadsheet' viewBox='0 0 16 16'><path d='M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v4h10V2a1 1 0 0 0-1-1H4zm9 6h-3v2h3V7zm0 3h-3v2h3v-2zm0 3h-3v2h2a1 1 0 0 0 1-1v-1zm-4 2v-2H6v2h3zm-4 0v-2H3v1a1 1 0 0 0 1 1h1zm-2-3h2v-2H3v2zm0-3h2V7H3v2zm3-2v2h3V7H6zm3 3H6v2h3v-2z'/></svg> Excel"
                        },
                        {
                            extend: 'colvis',
                            exportOptions: {
                                columns: ':visible'
                            },
                            text : "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-list' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z'/></svg> Column Visible"
                        }
                    ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                columns : [
                    {data:'id',name:'id',orderable:false,searchable:false},
                    {data:'Name',name:'Name'},
                    {data:'Active_Status',name:'Active_Status'},
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
                    'Name':$('#Edit_Name').val(),
                    'Active_Status':$('input[name="Active_Status"]:checked').val()
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

                var status = $(this).parent().parent().children().eq(2).text();
                console.log("Status:"+status);
                if(status == '1'){
                    $('#Active').attr('checked','checked');
                }
                else{
                    $('#InActive').attr('checked','checked');
                }

                // var test = $(".side_Nav_Category").addClass('active');
                // if(test){console.log("success");}
            });
        });
    </script>
@endsection
