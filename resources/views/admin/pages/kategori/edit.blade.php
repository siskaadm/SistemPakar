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
                <form method="POST" action="{{route('kategori.update',$kategori)}}"enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Kode Kategori</label>
                      <input value="{{ $kategori->kode_kategori ?? old('kode_kategori') }}"
                      type="text" name='kode_kategori' class="form-control" id="exampleInputEmail1" placeholder="kode_kategori">
                    </div>
                    <div class="form-group">
                      <label>Daftar Solusi</label>
                      <select name="solusis[]" class="select2bs4 select2-multiple form-control" multiple>
                          @foreach ($solusis as $solusi)
                              <option value="{{ $solusi->kode_solusi }}" {{ in_array($solusi->kode_solusi, $kategori->solusis) ? 'selected' : '' }}>{{ $solusi->kode_solusi . ' - ' . $solusi->nama_solusi }}</option>
                          @endforeach
                      </select>
                  </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-success mt-4">Submit</button>
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
@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(function() {
      $('.select2-multiple').select2({
          dropdownParent: $('#modalTambahBarang'),
          width: '100%',
      })
  });
</script>
@endsection