@extends('admin.layouts.app', [
  'elementActive' => 'edit'
])

@section('content')
    <!-- Main content -->
    <section class="content">
    
              <div class="col-12 col-md-4">
                <section class="container-fluid">
              <div class="card card-default color-palette-box">
              <div class="card-header">
                  <h3 class="card-title">
                    Edit 
                  </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{route('user.update',$user)}}"enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Username</label>
                      <input value="{{ $user->username ?? old('username') }}"
                      type="text" name='username' class="form-control" id="exampleInputEmail1" placeholder="username">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name</label>
                      <input value="{{ $user->name ?? old('name') }}"
                      type="text" name='name' class="form-control" id="exampleInputEmail1" placeholder="name">
                    </div>
                    <div class="form-group">
                      <label>Level</label>
                      <select name="level" class="form-control">
                          @foreach ($levels as $level)
                              <option value="{{ $level }}" {{ $user->level == $level ? 'selected' : '' }}>{{ $level }}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Password</label>
                      <input type="password" name='password' class="form-control" id="exampleInputEmail1" placeholder="password">
                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-success mt-4">Simpan</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>


          </div>
        </div>
    </section>
@endsection
<script src="{{ asset('vendor/adminlte') }}/dist/js/pages/dashboard.js"></script>
<!-- <script>
    function previewImageUpdate() {
      document.getElementById("image-preview-update").style.display = "block";
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("image-source-update").files[0]);
  
      oFReader.onload = function(oFREvent) {
        document.getElementById("image-preview-update").src = oFREvent.target.result;
      };
    };
</script> -->