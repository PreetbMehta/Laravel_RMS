@extends('layouts.admin')

@section('content')

    <style>
        #StockReport_Table td,th{
            text-align: center;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stock Report</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><a href="#">Stock Report</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="card">
            <div class="card-body">
                <h3>Filter by Fields</h3>
                <div class="row">
                    {{-- <input type="number" name="Total_Products" min="1" step="1" id="Total_Products" class="form-control col-md-3 m-1" placeholder="No Of Products Greater than or equal to">
                    <input type="number" name="Amount" min="1" step="1" id="Amount" class="form-control col-md-3 m-1" placeholder="Amount Greater than or equal to"> --}}
                    <input type="text" name="Product_Id" id="Product_Id" class="form-control col-md-3 m-1" placeholder="Product id">
                    <input type="text" name="Product_Name" id="Product_Name" class="form-control col-md-3 m-1" placeholder="Product Name">
                    <input type="button" class="btn btn-primary form-control col-md-1 m-1" value="Refresh" id="refresh">
                </div>
                <table class="table table-bordered table-striped dataTable dtr-inline" id="StockReport_Table">
                    <thead>
                        <th>id</th>
                        <th>Product Name</th>
                        <th>Stock Left</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            load_data();
            function load_data()
            {
                //fetch data with ajax
                var table = $('#StockReport_Table').DataTable({
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
                    ajax: {
                        url:"{{ route('StockReport.index') }}",
                    },
                    columns : [
                        {data:'Product_Id',name:'Product_Id'},
                        {data:'Name',name:'Name'},
                        {data: 'Stock_Left', name: 'Stock_Left'},
                    ],
                    // order: [ [0, 'desc'] ],
                    // "responsive": true, 
                    // "buttons": ["excel", "pdf", "print", "colvis"]
                });
                //filtering table values on search
                $('#Product_Name').keyup(function(){
                    var pro = $(this).val();
                    // console.log(custFil);
                    table.column(1).search(pro).draw();
                });
                $('#Product_Id').keyup(function(){
                    var proid = $(this).val();
                    // console.log(custFil);
                    table.column(0).search(proid).draw();
                });
            }
            $('#refresh').click(function(){
                $('#Product_Name').val('');
                $('#Product_Id').val('');
                $('#StockReport_Table').DataTable().clear().destroy();
                load_data();
            });
        });
            
    </script>
@endsection