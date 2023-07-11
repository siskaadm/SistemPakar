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
                <form method="POST" action="{{route('kerusakan.update',$kerusakan)}}"enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Kode Kerusakan</label>
                      <input value="{{ $kerusakan->kode_kerusakan ?? old('kode_kerusakan') }}"
                      type="text" name='kode_kerusakan' class="form-control" id="exampleInputEmail1" placeholder="kode_kerusakan">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Kerusakan</label>
                      <input value="{{ $kerusakan->nama_kerusakan ?? old('nama_kerusakan') }}"
                      type="text" name='nama_kerusakan' class="form-control" id="exampleInputEmail1" placeholder="nama_kerusakan">
                    </div>
                    <div class="form-group">
                      <label>Kode Kategori</label>
                      <select name="kode_kategori" class="form-control">
                          @foreach ($kategoris as $kategori)
                              <option value="{{ $kategori->kode_kategori }}" {{ $kategori->kode_kategori == $kategori->kode_kategori ? 'selected' : '' }}>{{ $kategori->kode_kategori . ' - ' . implode(', ', $kategori->solusis) }}
                          @endforeach
                      </select>
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