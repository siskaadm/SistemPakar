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
                <form method="POST" action="{{route('rekomendasisolusi.update',$rekomendasisolusi)}}"enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                      <div class="form-group">
                        <label>Kode Rekomendasi Solusi</label>
                        <input type="text" name="kode_rekomendasisolusi" class="form-control"
                            placeholder="" value="{{ $rekomendasisolusi->kode_solusi ?? old('kode_rekomendasisolusi') }}">
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Solusi</label>
                        <textarea name="deskripsi_rekomendasisolusi" class="form-control" rows="5">{{ $rekomendasisolusi->deskripsi_solusi ?? old('deskripsi_rekomendasisolusi') }}</textarea>
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