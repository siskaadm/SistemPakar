@extends('admin.layouts.app', [//perintah Blade untuk memperluas atau meng-extend template 'admin.layouts.app'
  'elementActive' => 'edit'
  //Parameter ini dapat digunakan dalam template untuk memberikan nilai atau status tertentu kepada 
  //elemen atau bagian halaman yang aktif atau sedang digunakan.
])

@section('content')
{{-- adalah perintah Blade untuk mendefinisikan sebuah bagian atau section 
  dengan nama 'content'. Bagian ini biasanya digunakan untuk menempatkan konten unik atau spesifik untuk halaman yang sedang diperluas. --}}
    <!-- Main content -->
    <section class="content">
      {{-- <section>: Ini adalah elemen HTML yang digunakan untuk menandai sebuah bagian dalam dokumen HTML
      lass="content": Ini adalah atribut class yang diberikan pada elemen <section>. Dalam hal ini, 
      diberikan kelas (class) CSS "content" kepada elemen tersebut. Kelas ini dapat digunakan untuk 
      menerapkan gaya atau aturan tertentu pada elemen dengan menggunakan CSS atau framework CSS tertentu.--}}
    
              <div class="col-12 col-md-4">
              {{-- <div class="col-12 col-md-4">: Ini adalah elemen <div> dengan kelas (class) CSS "col-12 col-md-4". 
              Elemen ini biasanya digunakan dalam framework CSS seperti Bootstrap untuk mengatur tata letak (layout) 
              responsif dalam grid. Dalam hal ini, elemen tersebut akan memiliki lebar kolom penuh pada layar kecil 
              (12 kolom) dan lebar kolom 4 pada layar medium (md). --}}
                <section class="container-fluid">
                {{-- Ini adalah elemen <section> dengan kelas (class) CSS "container-fluid". 
                Elemen ini biasanya digunakan dalam framework CSS seperti Bootstrap untuk mengelompokkan 
                konten dan memberikan tampilan penuh lebar (full-width) pada konten tersebut. --}}
              <div class="card card-default color-palette-box">
              {{-- Ini adalah elemen <div> dengan kelas (class) CSS "card card-default color-palette-box". 
              Elemen ini mungkin digunakan dalam framework CSS seperti Bootstrap untuk membuat sebuah
              kotak (card) dengan gaya dan tampilan yang konsisten dengan tema warna..  --}}
              <div class="card-header">
              {{-- untuk menyediakan bagian header (kepala) dari sebuah kotak (card).  --}}
                  <h3 class="card-title">
                  {{-- untuk menampilkan judul (title) dalam sebuah kotak (card) atau elemen lainnya. 
                  Dalam hal ini, elemen <h3> ini berisi teks "Edit" yang mungkin merupakan judul 
                  untuk konten yang akan diedit. --}}
                    Edit 
                  </h3> {{-- judul tingkat 3 --}}
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{route('aturan.update',$aturan)}}"enctype="multipart/form-data">
                {{-- method="POST": Menentukan metode HTTP yang akan digunakan saat form dikirimkan. 
                Dalam hal ini, metode POST digunakan. Ini berarti data form akan dikirimkan dalam body permintaan HTTP. --}}
                {{-- action="{{route('aturan.update',$aturan)}}": Menentukan URL atau rute yang akan 
                dituju ketika form dikirimkan. Dalam hal ini, rute yang ditentukan adalah 'aturan.update' 
                dengan parameter $aturan. Route ini akan diproses oleh metode update pada controller terkait.
                enctype="multipart/form-data": Menentukan tipe encoding yang akan digunakan saat mengirimkan 
                data form yang berisi file. Dalam hal ini, multipart/form-data digunakan karena form ini mungkin 
                mengandung file yang diunggah. --}}
                    @csrf {{-- adalah directive Blade pada framework Laravel yang menghasilkan field CSRF (Cross-Site Request Forgery) pada form. 
                      Field CSRF ini digunakan untuk melindungi form dari serangan CSRF. --}}
                    @method('PUT') {{-- Field _method ini digunakan untuk menentukan metode HTTP yang 
                    sebenarnya saat mengirimkan form, karena HTML form hanya mendukung metode GET dan 
                    POST secara default. Dalam hal ini, nilai PUT digunakan untuk menunjukkan bahwa metode HTTP yang sebenarnya adalah PUT. --}}

                    <div class="card-body"> {{-- untuk menyediakan konten utama dalam sebuah kotak (card). --}}
                      <div class="form-group"> {{-- digunakan untuk mengelompokkan elemen-elemen dalam sebuah form --}}
                        <label>kode_aturan</label>{{-- digunakan untuk menampilkan label atau penjelasan terkait dengan input field. Dalam hal ini, label tersebut berisi teks "kode_aturan --}}
                        <input type="text" name="kode_aturan" class="form-control"
                            placeholder="" value="{{ $aturan->kode_aturan ?? old('kode_aturan') }}">
                        {{-- elemen <input> dalam HTML yang digunakan untuk menerima input teks dari pengguna. 
                          type="text": Menunjukkan bahwa input ini akan menerima teks.
                          name="kode_aturan": Menentukan nama (name) untuk input ini. Nama ini akan digunakan saat mengirimkan data form ke server.
                          class="form-control": Menentukan kelas (class) untuk input ini.
                          placeholder="": Menentukan teks placeholder yang akan ditampilkan di dalam input field sebelum pengguna memasukkan nilai.
                          value="{{ $aturan->kode_aturan ?? old('kode_aturan') }}": Menentukan nilai awal (default value) 
                          untuk input field. Nilai ini diambil dari variabel $aturan->kode_aturan, dan jika tidak ada nilai 
                          yang tersedia, maka akan menggunakan nilai dari old('kode_aturan') (nilai yang dikirimkan sebelumnya jika ada). --}}
                    </div>

                    <div class="form-group">
                        <label>kode_gejala</label>
                        <select name="kode_gejala[]" class="select2bs4 select2-multiple form-control" multiple>
                            @foreach ($gejalas as $gejala)
                                <option value="{{ $gejala->kode_gejala }}" {{ in_array($gejala->kode_gejala, $aturan->kode_gejala) ? 'selected' : '' }}>{{ $gejala->kode_gejala . ' - ' . $gejala->nama_gejala }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>kode_kerusakan</label>
                        <select name="kode_kerusakan" class="form-control">
                            @foreach ($kerusakans as $kerusakan)
                                <option value="{{ $kerusakan->kode_kerusakan }}" {{ $aturan->kode_kerusakan == $kerusakan->kode_kerusakan ? 'selected' : '' }}>{{ $kerusakan->kode_kerusakan . ' - ' . $kerusakan->nama_kerusakan }}
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
  @section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(function() {
        $('.select2-multiple').select2({
            width: '100%',
        })
      });
    </script>
  @endsection
@endsection
<script src="{{ asset('vendor/adminlte') }}/dist/js/pages/dashboard.js"></script>