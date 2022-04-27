@extends('layouts.admin')

@section('content')
     <!-- Content Header (Page header) -->
     <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Settings</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Settings</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

        @if (Session('status'))
            <script>
                swal('Success!',"{{Session('status')}}",'success',{button:'OK'});
            </script>
        @endif
      <div class="content">
          <div class="card">
              <div class="card-body">
                    <form action="{{route('addSettings')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Logo">
                                    <b>Company Logo:</b>
                                </label>
                                <input type="file" name="Logo" id="Logo" class="form-control"
                                    onchange="return fileValidation()" required>
                            </div>
                            <div class="col-md-6">
                                <img alt="" id="Preview" style="height: 200px;width:200px;margin-top:15px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Company_Name">Company Name:</label>
                                <input type="text" name="Company_Name" id="Company_Name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Mobile_No">Company Mobile number:</label>
                                <input type="text" name="Mobile_No" id="Mobile_No" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Email_Id">Company Email Id:</label>
                                <input type="text" name="Email_Id" id="Email_Id" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <label for="Address">Company Address:</label>
                            <textarea name="Address" id="Address" cols="30" rows="5" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success m-2">Submit</button>
                    </form>
              </div>
          </div>
      </div>

      <script>
            //file validations for i/p image in js
            function fileValidation() {
                console.log("inside validation function");
                var fileInput =
                    document.getElementById('Logo');

                var filePath = fileInput.value;

                // Allowing file type
                var allowedExtensions =
                    /(\.jpg|\.jpeg|\.png)$/i;

                if (!allowedExtensions.exec(filePath)) {
                    console.log("insideif");
                    alert('Invalid file type' + '\n' + 'Choose Image files with extension "jpg","jpeg","png" only');
                    fileInput.value = '';
                    $('#Preview').attr('src','');
                    return false;
                }
            }

             //imge preview
            $(document).ready(function(e) {
                $('#Logo').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#Preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });
            });
      </script>
@endsection