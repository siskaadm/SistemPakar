<form id="diagnosa" class="form" action="{{ route('diagnosa.proses') }}" method="POST">
    @csrf
    {{-- Indicators --}}
    <div class="form-header d-flex mb-4">
        <span class="indicator__step">Data Diri</span>
        <span class="indicator__step active">Isi Pertanyaan</span>
        <span class="indicator__step">Hasil Diagnosa</span>
    </div>
    {{-- End Indicators --}}
    
    {{-- Table Checkboxes --}}
    <div class="step">
        <div class="table-responsive">
            <div class="alert alert-primary">
                <strong>Perhatian!</strong> <br>Silahkan pilih <strong>Ya</strong> atau <strong>Tidak</strong> pada kolom <strong>Ya</strong> atau <strong>Tidak</strong> untuk setiap gejala dibawah.
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Inisial</th>
                        <th>Nama Gejala</th>
                        <th>Ya</th>
                        <th>Tidak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gejalas as $gejala)
                        <tr>
                            {{-- <td>) dibuat untuk menampilkan data. --}}
                            <td>{{ $loop->iteration }}</td>{{-- menampilkan nomor iterasi dari perulangan, dimulai dari 1. --}}
                            <td>{{ $gejala->kode_gejala }}</td>
                            <td>{{ $gejala->nama_gejala }}</td>
                            <td>
                                
                                {{-- pilihan ya --}}
                                <input type="radio" name="gejala[{{ $gejala->kode_gejala }}]" value="1">
                            </td>
                            <td>
                                {{-- pilihan tidak --}}
                                <input type="radio" name="gejala[{{ $gejala->kode_gejala }}]" value="0">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex">
            <input type="hidden" name="step" value="2">
            <a href="{{ route('page.diagnosa') }}" class="btn btn-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-primary">Cek Hasil</button>
        </div>
    </div>
</form>