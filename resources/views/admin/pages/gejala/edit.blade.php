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
                <form method="POST" action="{{route('gejala.update',$gejala)}}"enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Kode Gejala</label>
                      <input value="{{ $gejala->kode_gejala ?? old('kode_gejala') }}"
                      type="text" name='kode_gejala' class="form-control" id="exampleInputEmail1" placeholder="kode_gejala">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Gejala</label>
                      <input value="{{ $gejala->nama_gejala ?? old('nama_gejala') }}"
                      type="text" name='nama_gejala' class="form-control" id="exampleInputEmail1" placeholder="nama_gejala">
                    </div>

                  </div>
                  {{-- <p>{{ $gejala->kode_gejala->}}</p> --}}
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