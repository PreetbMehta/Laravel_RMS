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
                <form action={{ route('categories.store') }} method="post">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>
                                    <h5>Title</h5>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="Name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="align-content: center">
                        <input type="Submit" class="btn btn-info" value="Add Category">
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                            <th style="text-align: center">#</th>
                            <th style="display: none">ID</th>
                            <th style="text-align: center">Name</th>
                            <th style="text-align: center">Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    @php
                        $count=1;
                    @endphp
                    @foreach ($showCategory as $cat_item)
                        <tbody>
                            <tr>
                                <td style="text-align: center">{{$count}}</td>
                                <td style="display: none">{{$cat_item->id}}</td>
                                <td style="text-align: center">{{ $cat_item->Name }}</td>
                                <td style="text-align: center">
                                    <a class="btn btn-xs btn-info editBtn" href="#" data-toggle="modal"
                                        data-target="#EditCategoryModal">
                                        <span class="btn-label"><i class="fa fa-edit"></i></span>
                                        Edit
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <form action="{{ url('categories/' . $cat_item->id) }}" method="POST">
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
                        @php
                            $count++;
                        @endphp
                    @endforeach
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
                <form action="/categories" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Name">
                                    <b>1)Category Name:</b>
                                </label>
                                <input type="text" name="Name" id="Name" 
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
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <!--JQUERY DATATABLE SCRIPT-->
    <script>
        $(document).ready(function() {
            $('#Category-Table').DataTable();
        });

        $('.editBtn').on('click',function(e){
            e.preventDefault();//to stop anchor tag to redirect to href

            //fetching data in edit modal
            var id =  $(this).parent().parent().children().eq(1).text()
            console.log(id);
            var C =  $(this).parent().parent().children().eq(2).text()
            $('#Name').val(C);
            console.log(C);

            $('#editForm').attr('action','/categories/'+id);
        })
    </script>
@endsection
