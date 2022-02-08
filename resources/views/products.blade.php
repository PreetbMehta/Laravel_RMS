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

    <!-- Add Purchase --------------------------------------------------------------------------------->
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
                <form action={{ route('products.store') }} method="POST" enctype="multipart/form-data">
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
                            <input type="text" name="Name" id="Name" class="form-control"
                                required>
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
                            <input type="number" min="1" step="1" name="Quantity" id="Quantity" class="form-control"
                                required>
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
                                <option value="1">Pieces</option>
                                <option value="2">KiloGram(Kg)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label for="Short_Desc">
                                7)Short Description:
                            </label>
                            <textarea name="Short_Desc" id="Short_Desc" class="form-control" rows="5" placeholder="Mention Size', 'Color', 'Material',etc attributes if any" required></textarea>
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
                <button type="Submit" class="btn btn-success btn-lg">Add Product</button>
            </div>
            <!-- /.card-footer-->
            </form>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.content -->

    <!-- /.content-header -->
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
                <table id="Purchase-Table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Reference_id</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Short Description</th>
                            <th>MRP</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @php $count = 1; @endphp
                    @foreach ($showProduct as $pro_item)
                        <tbody>
                            <tr>
                                <td>{{ $count }}</td>
                                <td>
                                    <img src="{{ asset('Uploads/Product_Pics/' . $pro_item->Picture) }}" width="100px"
                                        height="100px" alt="Image" id="Image1">
                                </td>
                                <td>{{ $pro_item->Name }}</td>
                                <td>{{ $pro_item->Reference_Id }}</td>
                                <td>{{ $pro_item->Category }}</td>
                                <td>{{ $pro_item->Quantity }}</td>
                                <td>{{ $pro_item->Unit }}</td>
                                <td>{{ $pro_item->Short_Desc }}</td>
                                <td>{{ $pro_item->MRP }}</td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="#" data-toggle="modal"
                                        data-target="#EditProductModal{{ $pro_item->id }}">
                                        <span class="btn-label"><i class="fa fa-edit"></i></span>
                                        Edit
                                    </a>
                                    <form action="{{ url('products/' . $pro_item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            <span class="btn-label"><i class="fa fa-trash"></i></span>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        {{-- #EditProductModal ---------------------------------------------------------------------------- --}}
                        <div class="modal" tabindex="-1" id="EditProductModal{{ $pro_item->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Product</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('products/' . $pro_item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Picture">
                                                        <b>1)Picture:</b>
                                                    </label>
                                                    <input type="file" name="Picture" class="Picture1" class="form-control ">
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <img alt="Preview Image" id="Preview1"
                                                        value="{{ asset('Uploads/Product_Pics/' . $pro_item->Picture) }}"
                                                        style="height: 200px;width:200px;"> --}}
                                                        <img src="{{asset('Uploads/Product_Pics/'.$pro_item->Picture)}}" alt="Product Image" height="200px" width="200px" class="Preview1">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <label for="Reference_Id">
                                                        <b>2) Reference Id:</b>
                                                    </label>
                                                    <input type="text" name="Reference_Id" id="Reference_Id"
                                                        class="form-control" value="{{ $pro_item->Reference_Id }}"
                                                        required>
                                                </div>
                                                <div class="col-md">
                                                    <label for="Category">
                                                        3)Category
                                                    </label>
                                                    <select name="Category" id="Category" class="form-control" required>
                                                        <option>Open this select menu</option>
                                                        @foreach ($Cat_Select as $Cat_item)
                                                            <option value="{{ $Cat_item->Name }}">
                                                                {{ $Cat_item->Name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Cost_Price">
                                                        <b>4)Cost Price:</b>
                                                    </label>
                                                    <input type="number" min="1" step="1" name="Cost_Price" id="Cost_Price"
                                                        class="form-control" value="{{ $pro_item->Cost_Price }}"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="MRP">
                                                        <b>5) MRP:</b>
                                                    </label>
                                                    <input type="number" min="1" step="1" name="MRP" id="MRP"
                                                        class="form-control" value="{{ $pro_item->MRP }}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Purchase_no">
                                                        <b>6)Purchase no:</b>
                                                    </label>
                                                    <input type="text" name="Purchase_no" id="Purchase_no"
                                                        class="form-control" value="{{ $pro_item->Purchase_no }}"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Quantity">
                                                        <b>7) Quantity:</b>
                                                    </label>
                                                    <input type="number" min="1" step="1" name="Quantity" id="Quantity"
                                                        class="form-control" value="{{ $pro_item->Quantity }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <label for="Short_Desc">
                                                        8)Short Description:
                                                    </label>
                                                    <textarea name="Short_Desc" id="Short_Desc" class="form-control"
                                                        rows="5">{{ $pro_item->Short_Desc }}</textarea>
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
                        @php $count++; @endphp
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{-- Scripts-------------------------------------------------------------------------- --}}

    <!-- JQuery DataTable JS-->
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script>
        // <!--JQUERY DATATABLE SCRIPT-->
        $(document).ready(function() {
            $('#Product-Table').DataTable();
        });

        //file validations for i/p image in js
        function fileValidation() {
            var fileInput =
                document.getElementById('Picture');

            var filePath = fileInput.value;

            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.jpeg|\.png)$/i;

            if (!allowedExtensions.exec(filePath)) {
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

        //imge preview
        $(document).ready(function(e) {


            $('Picture1').change(function() {

                let reader = new FileReader();

                reader.onload = (e) => {

                    $('.Preview1').attr('src', e.target.result);
                    console.log($('.Preview1'));
                }

                reader.readAsDataURL(this.files[0]);

            });

        });
    </script>
@endsection
