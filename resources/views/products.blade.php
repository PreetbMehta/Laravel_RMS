@extends('layouts.admin')

@section('content')

    <style>
        #Product-Table td,th{
            text-align: center;
        }
    </style>

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
            <form action="" method="POST" id="AddProductForm" enctype="multipart/form-data">
            <div class="card-body">
                <div id="error_message"></div>
                @csrf
                    <div class="card-body">
                        <div id="error_message"></div>
                        <div class="row">
                            <div class="col-md">
                                <label for="Category">
                                    1)Category
                                </label>
                                <select name="Category" id="Category" class="form-control select2 select2bs4 select2-danger" required>
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
                            {{-- <div class="col-md-4">
                                <label for="Quantity">
                                    <b>4) Quantity:</b>
                                </label>
                                <input type="number" min="1" step="1" name="Quantity" id="Quantity" class="form-control" >
                            </div> --}}
                            <div class="col-md-6">
                                <label for="Alert_Quantity">
                                    <b>4) Alert Quantity:</b>
                                </label>
                                <input type="number" min="1" step="1" name="Alert_Quantity" id="Alert_Quantity" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="MRP">
                                    <b>5) MRP:</b>
                                </label>
                                <input type="number" min="1" step="1" name="MRP" id="MRP" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Unit">
                                    <b>6)Unit:</b>
                                </label>
                                <select name="Unit" id="Unit" class="form-control select2 select2bs4 select2-danger">
                                    <option value="">Open this select menu</option>
                                    <option value="pcs">Pieces(pcs)</option>
                                    <option value="kg">KiloGram(Kg)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="TaxSlab">
                                    <b>7)TaxSlab:</b>
                                </label>
                                <select name="TaxSlab" id="TaxSlab" class="form-control select2 select2bs4 select2-danger" required>
                                    <option value="">Open this select menu</option>
                                    @foreach ($taxSlab as $taxSlab_item)
                                        <option value="{{ $taxSlab_item->TaxPercentage }}">{{ $taxSlab_item->TaxPercentage }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label for="Short_Desc">
                                    8)Short Description:
                                </label>
                                <textarea name="Short_Desc" id="Short_Desc" class="form-control" rows="5"
                                    placeholder="Mention Size', 'Color', 'Material',etc attributes if any"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Picture">
                                    <b>9)Picture:</b>
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
            </div>
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
            <div class="card-body table-responsive">
                <table id="Product-Table" class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Reference id</th>
                            <th>Category</th>
                            {{-- <th>Quantity</th> --}}
                            <th>Alert_Quantity</th>
                            <th>Unit</th>
                            <th>TaxSlab</th>
                            <th>MRP</th>
                            <th>Short Description</th>
                            <th>Active Status</th>
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
    <div class="modal" id="EditProductModal">
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
                                <select name="Category" id="Edit_Category" class="form-control select2 select2bs4 select2-danger" required>
                                    <option>Open this select menu</option>
                                    @foreach ($Cat_Select as $Cat_item)
                                        <option value="{{ $Cat_item->Name }}">
                                            {{ $Cat_item->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="MRP">
                                    <b>6) MRP:</b>
                                </label>
                                <input type="number" min="1" step="1" name="MRP" id="Edit_MRP" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-6">
                                <label for="Quantity">
                                    <b>5) Quantity:</b>
                                </label>
                                <input type="number" min="1" step="1" name="Quantity" id="Edit_Quantity" class="form-control" required>
                            </div> --}}
                            <div class="col-md-12">
                                <label for="Alert_Quantity">
                                    <b>5) Alert Quantity:</b>
                                </label>
                                <input type="number" min="1" step="1" name="Alert_Quantity" id="Edit_Alert_Quantity" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Unit">
                                    <b>7)Unit:</b>
                                </label>
                                <select name="Unit" id="Edit_Unit" class="form-control select2 select2bs4 select2-danger" required>
                                    <option value="">open this select menu</option>
                                    <option value="pcs">Pieces(pcs)</option>
                                    <option value="kg">KiloGram(Kg)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="TaxSlab">
                                    <b>8)TaxSlab:</b>
                                </label>
                                <select name="TaxSlab" id="Edit_TaxSlab" class="form-control select2 select2bs4 select2-danger" required>
                                    <option>open this select menu</option>
                                    @foreach ($taxSlab as $taxSlab_item)
                                        <option value="{{ $taxSlab_item->TaxPercentage }}">{{ $taxSlab_item->TaxPercentage }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label for="Short_Desc">
                                    9)Short Description:
                                </label>
                                <textarea name="Short_Desc" id="Edit_Short_Desc" class="form-control" rows="5"></textarea>
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

    <script>
        // <!--JQUERY DATATABLE SCRIPT-->
        $(function() {
            //sweet alert funcction
            function Success_Sweet_Alert(response_alert) {
                swal("Great Job", response_alert, "success", {
                    button: "OK"
                });
            }

            //initialise select 2
            $('.select2').select2();
            
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4' 
            });

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //fetch data in datatable with ajax>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            var table = $('#Product-Table').DataTable({
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
                ajax: "{{route('products.index')}}",
                columns: [
                    {data: 'id',name: 'id',orderable:false,searchable:true},
                    {data: 'Picture',name: 'Picture'},
                    {data: 'Name',name: 'Name'},
                    {data: 'Reference_Id',name: 'Reference_Id'},
                    {data: 'Category',name: 'Category'},
                    // {data: 'Quantity',name: 'Quantity'},
                    {data: 'Alert_Quantity',name: 'Alert_Quantity'},
                    {data: 'Unit',name: 'Unit'},
                    {data: 'TaxSlab',name: 'TaxSlab'},
                    {data: 'MRP',name: 'MRP'},
                    {data: 'Short_Desc',name: 'Short_Desc'},
                    {data: 'Active_Status',name:'Active_Status'},
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
                            $('#AddProductForm .select2').trigger('change')//to reset select menus
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

                // var Quantity = $(this).parent().parent().children().eq(5).text();
                // console.log("Quantity"+Quantity);
                // $('#Edit_Quantity').val(Quantity);

                var AlertQuantity = $(this).parent().parent().children().eq(5).text();
                console.log("Alert-Quantity"+AlertQuantity);
                $('#Edit_Alert_Quantity').val(AlertQuantity);

                var Unit = $(this).parent().parent().children().eq(6).text();
                console.log("Unit"+Unit);
                $('#Edit_Unit').val(Unit);

                var taxslab = $(this).parent().parent().children().eq(7).text();
                console.log("taxslab"+taxslab);
                $("#EditProductModal #Edit_TaxSlab option[value="+taxslab+"]").attr('selected', 'selected');

                var MRP = $(this).parent().parent().children().eq(8).text();
                console.log("MRP"+MRP);
                $('#Edit_MRP').val(MRP);

                var Short_Desc = $(this).parent().parent().children().eq(9).text();
                console.log("SD"+Short_Desc);
                $('#Edit_Short_Desc').val(Short_Desc);

                var status = $(this).parent().parent().children().eq(10).text();
                console.log("Status:"+status);
                if(status == '1'){
                    $('#Active').attr('checked','checked');
                }
                else{
                    $('#InActive').attr('checked','checked');
                }

                //initialise select 2
                $('.select2').select2();
                
                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4' 
                });
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
