@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Purchase</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><a href={{ route('viewPurchase.index') }}>View Purchase</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @if (session('status'))
        <script>
            swal('Success!',"{{Session('status')}}",'success',{button:'OK'});
        </script>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!--card-->
    <div class="content">
        <div class="card">
            {{-- <div class="card-header">
                <h3 class="mb-0">View Purchase</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div> --}}
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped dtr-inline" id="ViewPurTable">
                    <thead>
                        <tr>
                            <th style="text-align: center">Id</th>
                            <th style="text-align:center">Date Of Purchase</th>
                            <th style="text-align: center">Supplier Name</th>
                            <th style="text-align: center">Brand Name</th>
                            <th style="text-align: center; width:20px">Total Products</th>
                            <th style="text-align: center">SubTotal</th>
                            <th style="text-align: center">Total Tax Amount</th>
                            <th style="text-align: center">Total Discount</th>
                            <th style="text-align: center">Total Amount</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        @foreach ($showPur as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->Date_Of_Purchase }}</td>
                                <td>{{ $item->Supplier_Name }}<input type="hidden" value="{{$item->Supplier_Id}}" id="sup_id"></td>
                                <td>{{ $item->Brand_Name }}</td>
                                <td>{{ $item->Total_Products }}</td>
                                <td>{{ $item->Sub_Total }}</td>
                                <td>{{ $item->Total_Tax_Amount }}</td>
                                <td>{{ $item->Discount_Amount }}</td>
                                <td>{{ $item->Total_Amount }}</td>
                                <td style="display:flex">
                                    <a href="ViewPurchaseDetails/{{ $item->id }}"
                                        class="btn btn-primary btn-l m-2 viewPurchase" data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="EditPurchase/{{$item->id}}" class="btn btn-primary btn-l m-2 editPurchase" data-id="{{ $item->id }}" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ url('viewPurchase/' . $item->id) }}" method="POST" onsubmit="return DelValidation()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-l m-2 delPurchase" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#ViewPurTable').DataTable({
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
                order: [
                    ['0', 'desc']
                ]
            });
            // //initialise select 2
            // $('.select2').select2();
            
            // //Initialize Select2 Elements
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4' 
            // });
        });

        //validation function for delete functionality
        function DelValidation()
        {
            var c = confirm("Are you sure you want to delete this Purchase?");
            if(c)
            {return true;}
            else
            {
                alert("Purchase Not Deleted");
                return false;
            }
        }
       
    </script>
@endsection
