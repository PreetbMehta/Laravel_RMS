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
                    <h1 class="m-0">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Add Product------------------------------------------------------------------------------>
    <div class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3>Add Product</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="error_message"></div>
                <form action="" method="POST" id="AddProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md">
                            <label for="Category">
                                1)Category
                            </label>
                            <select name="Category" id="Category" class="form-control" required>
                                <option value="">Open this select menu</option>
                                @foreach ($Cat_Select as $Cat_item)
                                    <option value="{{ $Cat_item->Name }}">{{ $Cat_item->Name }}</option>
                                @endforeach
                                {{-- <option value="2">Two</option>
                                <option value="3">Three</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Name">
                                <b>2)Name:</b>
                            </label>
                            <input type="text" name="Name" id="Name" class="form-control" required>
                        </div>
                        <div class="col-md">
                            <label for="Reference_Id">
                                <b>3) Reference Id:</b>
                            </label>
                            <input type="text" name="Reference_Id" id="Reference_Id" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Quantity">
                                <b>4) Quantity:</b>
                            </label>
                            <input type="number" min="1" step="1" name="Quantity" id="Quantity" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="MRP">
                                <b>5) MRP:</b>
                            </label>
                            <input type="number" min="1" step="1" name="MRP" id="MRP" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label for="Unit">
                                <b>6)Unit:</b>
                            </label>
                            <select name="Unit" id="Unit" class="form-control" required>
                                <option value="">open this select menu</option>
                                <option value="pcs">Pieces(pcs)</option>
                                <option value="kg">KiloGram(Kg)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label for="Short_Desc">
                                7)Short Description:
                            </label>
                            <textarea name="Short_Desc" id="Short_Desc" class="form-control" rows="5"
                                placeholder="Mention Size', 'Color', 'Material',etc attributes if any" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Picture">
                                <b>8)Picture:</b>
                            </label>
                            <input type="file" name="Picture" id="Picture" class="form-control"
                                onchange="return fileValidation()">
                        </div>
                        <div class="col-md-6">
                            <img alt="" id="Preview" style="height: 200px;width:200px;margin-top:15px;">
                        </div>
                    </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="Submit" class="btn btn-success btn-lg" id="Add_Product">Add Product</button>
            </div>
            <!-- /.card-footer-->
            </form>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.content -->

    <!-- /.datatable -->
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Product List</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="Product-Table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Reference id</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>MRP</th>
                            <th>Short Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- #EditProductModal ---------------------------------------------------------------------------- --}}
    <div class="modal" tabindex="-1" id="EditProductModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="EditProductForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div id="Edit_error_message"></div>
                        <input type="hidden" id="Edit_id">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Picture">
                                    <b>1)Picture:</b>
                                </label>
                                <input type="file" name="Picture" id="Edit_Picture" class="form-control ">
                            </div>
                            <div class="col-md-6">
                                <img src="" height="200px" width="200px" name="Edit_Preview" id="Edit_Preview">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Name">
                                    <b>2)Name:</b>
                                </label>
                                <input type="text" name="Name" id="Edit_Name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Reference_Id">
                                    <b>3) Reference Id:</b>
                                </label>
                                <input type="text" name="Reference_Id" id="Edit_Reference_Id" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Category">
                                    4)Category
                                </label>
                                <select name="Category" id="Edit_Category" class="form-control" required>
                                    <option>Open this select menu</option>
                                    @foreach ($Cat_Select as $Cat_item)
                                        <option value="{{ $Cat_item->Name }}">
                                            {{ $Cat_item->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="Quantity">
                                    <b>5) Quantity:</b>
                                </label>
                                <input type="number" min="1" step="1" name="Quantity" id="Edit_Quantity"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="MRP">
                                    <b>6) MRP:</b>
                                </label>
                                <input type="number" min="1" step="1" name="MRP" id="Edit_MRP" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="Unit">
                                    <b>7)Unit:</b>
                                </label>
                                <select name="Unit" id="Edit_Unit" class="form-control" required>
                                    <option>open this select menu</option>
                                    <option value="pcs">Pieces(pcs)</option>
                                    <option value="kg">KiloGram(Kg)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label for="Short_Desc">
                                    8)Short Description:
                                </label>
                                <textarea name="Short_Desc" id="Edit_Short_Desc" class="form-control" rows="5"></textarea>
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
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script>
        // <!--JQUERY DATATABLE SCRIPT-->
        $(function() {
            //sweet alert funcction
            function Success_Sweet_Alert(response_alert) {
                swal("Great Job", response_alert, "success", {
                    button: "OK"
                });
            }

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //fetch data in datatable with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            var table = $('#Product-Table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('products.index')}}",
                columns: [
                    {data: 'id',name: 'id',orderable:false,searchable:true},
                    {data: 'Picture',name: 'Picture'},
                    {data: 'Name',name: 'Name'},
                    {data: 'Reference_Id',name: 'Reference_Id'},
                    {data: 'Category',name: 'Category'},
                    {data: 'Quantity',name: 'Quantity'},
                    {data: 'Unit',name: 'Unit'},
                    {data: 'MRP',name: 'MRP'},
                    {data: 'Short_Desc',name: 'Short_Desc'},
                    {data: 'action',name: 'action',orderable:false,searchable:false},
                ]
            });

            //store data with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $(document).on('submit','#AddProductForm',function(e){
                e.preventDefault();
                $('#Add_Product').html('Sending..');
                var b = new FormData(this);
                console.log(b);
                $.ajax({
                    type: "POST",
                    url: "{{route('products.store')}}",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 400) {

                            $('#error_message').html("");
                            $('#error_message').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#error_message').append('<li>' + err_values +
                                '</li>');
                            });
                            $('#Add_Product').html('Add Product');
                        }
                        else
                        {
                            $('#error_message').html("");
                            $('#error_message').removeClass('alert alert-danger');
                            $('#AddProductForm').trigger("reset");
                            $('#Preview').attr('src','');
                            table.draw();//table.ajax.reload():can also be used here***
                            $('#Add_Product').html('Add Product');
                            Success_Sweet_Alert(response.message);
                        }
                    },
                    error: function (response) {
                        console.log('Error:', response);
                        swal("Something went wrong","","warning",{button:"OK"});
                        $('#Add_Product').html('Add Product');
                    }
                });
            });

            //Update data with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            $(document).on('submit','#EditProductForm',function(e){
                e.preventDefault();
                $('#EditChanges').html('Sending..');
            
                var Product_id = $('#Edit_id').val();
                console.log(Product_id);
                var Editdata= new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "products/"+Product_id,
                    data: Editdata,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 400) {

                            $('#Edit_error_message').html("");
                            $('#Edit_error_message').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#Edit_error_message').append('<li>' + err_values +
                                '</li>');
                            });
                            $('#EditChanges').html('Save Changes');
                        }
                        else
                        {
                            $('#Edit_error_message').html("");
                            $('#Edit_error_message').removeClass('alert alert-danger');
                            $('#EditProductForm').trigger("reset");
                            $('#Edit_Preview').attr('src','');
                            $('#EditProductModal').modal('hide');
                            table.draw();//table.ajax.reload():can also be used here***
                            $('#EditChanges').html('Save Changes');
                            Success_Sweet_Alert(response.message);
                        }
                    },
                    error: function (response) {
                        console.log('Error:', response);
                        swal("Something went wrong","","warning",{button:"OK"});
                        $('#EditChanges').html('Save Changes');
                    }
                });
            });

             //delete data with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
             $(document).on('click', '.deleteBtn', function (){
            var product_id = $(this).val();
            var product_name = $(this).parent().parent().children().eq(2).text();
            //sweet alert
            swal("Are You sure want to delete "+product_name+" product with id "+product_id+" !?","","warning",{
                buttons:{
                    cancel: "Cancel",
                    yes: "Yes! Delete"
                }}).then((value)=>{
                    switch(value){
                        case "yes":
                            $.ajax({
                                type: "DELETE",
                                url: "products/"+product_id,
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
                            swal(product_name + " product not Deleted","","warning");
                            break;
                    }
                })
            });

            //Fetch data in edit modal
            $(document).on('click','.editBtn', function(e) {
                e.preventDefault();

                var id = $(this).parent().parent().children().eq(0).text();
                console.log('Id: '+id);
                $('#Edit_id').val(id);

                var row = $(this).parent().parent().closest("tr");
                var pic = row.children().eq(1).children().attr('src');
                console.log("pre:"+pic);
                $('#Edit_Preview').attr('src', pic);

                var Name = $(this).parent().parent().children().eq(2).text();
                console.log("Name"+Name);
                $('#Edit_Name').val(Name);

                var Ref_Id = $(this).parent().parent().children().eq(3).text();
                console.log("Ref_Id"+Ref_Id);
                $('#Edit_Reference_Id').val(Ref_Id);

                var category = $(this).parent().parent().children().eq(4).text();
                console.log("category"+category);
                $("#EditProductModal #Edit_Category option[value="+category+"]").attr('selected', 'selected');

                var Quantity = $(this).parent().parent().children().eq(5).text();
                console.log("Quantity"+Quantity);
                $('#Edit_Quantity').val(Quantity);

                var Unit = $(this).parent().parent().children().eq(6).text();
                console.log("Unit"+Unit);
                $('#Edit_Unit').val(Unit);

                var MRP = $(this).parent().parent().children().eq(7).text();
                console.log("MRP"+MRP);
                $('#Edit_MRP').val(MRP);

                var Short_Desc = $(this).parent().parent().children().eq(8).text();
                console.log("SD"+Short_Desc);
                $('#Edit_Short_Desc').val(Short_Desc);
            });
        });
    
            //file validations for i/p image in js
            function fileValidation() {
                console.log("inside validation function");
                var fileInput =
                    document.getElementById('Picture');

                var filePath = fileInput.value;

                // Allowing file type
                var allowedExtensions =
                    /(\.jpg|\.jpeg|\.png)$/i;

                if (!allowedExtensions.exec(filePath)) {
                    console.log("insideif");
                    alert('Invalid file type' + '\n' + 'Choose Image files with extension "jpg","jpeg","png" only');
                    fileInput.value = '';
                    return false;
                }
            }

            //imge preview
            $(document).ready(function(e) {


                $('#Picture').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#Preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });

            });

            //edit image preview
            $(document).ready(function(e) {

                // $('.Preview1').attr('src',"");
                $('#Edit_Picture').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#Edit_Preview').attr('src', e.target.result);
                        // console.log($('#Edit_Preview'));
                    }

                    reader.readAsDataURL(this.files[0]);

                });
            });
    </script>
@endsection
