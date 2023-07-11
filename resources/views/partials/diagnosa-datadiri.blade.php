<form id="diagnosa" class="form" action="{{ route('diagnosa.proses') }}" method="POST">
    @csrf
    {{-- Indicators --}}
    <div class="form-header d-flex mb-4">
        <span class="indicator__step active">Data Diri</span>
        <span class="indicator__step">Isi Pertanyaan</span>
        <span class="indicator__step">Hasil Diagnosa</span>
    </div>
    {{-- End Indicators --}}
    <div class="step">
        {{-- <div class="mb-3 form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" placeholder="Nama" name="nama" value="{{ old('nama') }}" required autofocus>
        </div> --}}
        @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="mb-3 form-group">
            <label for="no_hp">Nomor Hp</label>
            <input type="tel" class="form-control" id="no_hp" placeholder="Nomor HP/WA" name="no_hp" value="{{ old('no_hp') }}" style="width:30%" required>
            <script>
                //Mengambil elemen dengan ID "no_hp" menggunakan document.getElementById('no_hp') dan menyimpannya dalam variabel no_hp
                var no_hp = document.getElementById('no_hp');
                //Menambahkan event listener untuk event keyup pada elemen no_hp. Event ini akan terjadi saat pengguna melepaskan tombol pada keyboard setelah mengetik.
                no_hp.addEventListener('keyup', function() {
                    //Di dalam event listener, dilakukan pengecekan dengan menggunakan ekspresi reguler /\\D/g.test(this.value) untuk memeriksa apakah ada karakter selain digit (non-digit) dalam nilai input.
                    if (/\D/g.test(this.value)) {
                        //Jika ditemukan karakter non-digit, karakter tersebut dihapus dari nilai input dengan menggunakan metode replace(/\D/g, ''). Dengan demikian, hanya digit yang akan tetap ada dalam nilai input.
                        this.value = this.value.replace(/\D/g, '');
                    }
                    //dilakukan pengecekan panjang nilai input dengan menggunakan this.value.length. Jika panjang nilai input lebih dari 13 karakter, karakter yang melebihi panjang tersebut dihapus dengan menggunakan slice(0, 13)
                    if (this.value.length > 13) {
                        this.value = this.value.slice(0, 13);
                    }
                })
            </script>
        </div>
        <div class="mb-3 form-group">
            <label for="tahun_motor">Tahun Motor</label>
            <select name="tahun_motor" class="form-control" style="width:30%">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
            </select>
            
            {{-- <input type="text" class="form-control" id="tahun_motor" placeholder="Tahun Motor: 2022" name="tahun_motor" value="{{ old('tahun_motor') }}" required> --}}
        </div>
    </div>
    {{-- Submit --}}
    <div class="d-flex">
        <input type="hidden" name="step" value="1">
        <button type="submit" class="btn btn-primary">Selanjutnya</button>
    </div>
</form>