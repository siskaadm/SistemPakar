@extends('admin.layouts.app', [
'elementActive' => 'laporan'
])
@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <h1>Laporan<h1>
        </div>
        <div class="col-md-12 mb-4">
        {{-- Ini adalah elemen <div> dengan kelas "col-md-12 mb-4". Ini menunjukkan bahwa elemen tersebut 
        akan memiliki lebar kolom 12 dari sistem grid yang digunakan (dalam hal ini, menggunakan 
        sistem grid Bootstrap). Kelas "mb-4" menambahkan margin bawah dengan ukuran 4 ke elemen tersebut. --}}
            <div class="container-fluid bg-white p-4">
            {{-- Ini adalah elemen <div> dengan kelas "container-fluid bg-white p-4". Ini menunjukkan 
            bahwa elemen tersebut akan memiliki lebar penuh (container fluid) dan latar belakang putih 
            (bg-white). Kelas "p-4" menambahkan padding sebesar 4 ke elemen tersebut. --}}
                <div class="row">{{-- Ini adalah elemen <div> dengan kelas "row". Ini digunakan untuk membuat baris dalam sistem grid. --}}
                    <div class="col-sm-6">{{-- memiliki lebar kolom 6 dari sistem grid pada perangkat dengan ukuran layar kecil (small screen). --}}
                        <div class="form-group">{{-- digunakan untuk mengelompokkan elemen-elemen dalam sebuah form. --}}
                            <label for="tahun_grafik">Tahun Periode</label>
                            {{-- Ini adalah elemen <label> yang menampilkan teks "Tahun Periode". Atribut for="tahun_grafik" 
                            menunjukkan bahwa label ini terhubung dengan elemen <select> yang memiliki id "tahun_grafik". --}}
                            <select name="tahun_grafik" id="tahun_grafik" class="form-control">
                            {{--  Ini adalah elemen <select> yang digunakan untuk membuat dropdown atau pilihan 
                            dalam bentuk daftar. Atribut name="tahun_grafik" digunakan untuk mengidentifikasi 
                            nilai yang dipilih saat formulir dikirimkan ke server. Atribut id="tahun_grafik" 
                            digunakan untuk menghubungkan elemen ini dengan label sebelumnya. Kelas "form-control" 
                            menambahkan styling pada elemen tersebut. --}}
                                @foreach ($tahuns as $tahun)
                                {{-- Ini adalah perintah Blade untuk melakukan loop atau perulangan. Variabel $tahuns adalah array atau 
                                objek yang berisi daftar tahun. Variabel $tahun adalah variabel iterasi yang akan berisi setiap 
                                elemen dalam $tahuns saat perulangan dilakukan. --}}
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                    {{--  Ini adalah elemen <option> di dalam elemen <select>. Ini menampilkan setiap tahun dalam 
                                    dropdown sebagai pilihan. Nilai yang akan dikirimkan ke server saat pilihan ini dipilih adalah 
                                    nilai dari variabel $tahun. Teks yang ditampilkan dalam pilihan ini juga menggunakan nilai dari variabel $tahun. --}}
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <canvas id="tahunMotor" height="140"></canvas>
                <canvas id="tahunKerusakan" height="140"></canvas>
                {{-- Ini adalah elemen <canvas> yang digunakan untuk membuat elemen grafik menggunakan JavaScript. 
                Setiap elemen <canvas> memiliki id yang unik dan tinggi sebesar 140 piksel. --}}
            </div>

            <div class="modal fade" id="modalTambahBarang" tabindex="-1"
                aria-labelledby="modalTambahBarang" aria-hidden="true">
            {{-- Ini adalah elemen <div> yang mewakili modal. Modal ini memiliki kelas "fade" yang memberikan efek 
                transisi saat muncul dan menghilang. Modal ini memiliki id "modalTambahBarang" yang dapat digunakan 
                untuk menghubungkannya dengan elemen lain. Atribut tabindex="-1" menunjukkan bahwa elemen ini tidak 
                dapat diakses dengan menggunakan tombol tab keyboard. Atribut aria-labelledby="modalTambahBarang" 
                menunjukkan bahwa elemen ini memiliki label dengan id "modalTambahBarang". Atribut aria-hidden="true" 
                menunjukkan bahwa elemen ini awalnya tersembunyi. --}}
                <div class="modal-dialog">{{-- digunakan untuk mengatur tata letak dan ukuran modal. --}}
                    <div class="modal-content">{{--  berisi semua elemen yang akan ditampilkan dalam modal. --}}
                        <div class="modal-header">{{-- berisi judul modal dan tombol close. --}}
                            <h5 class="modal-title">Detail Laporan</h5>{{-- elemen <h5> yang menampilkan judul modal, dalam hal ini "Detail Laporan". --}}
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>{{-- Ini adalah elemen <span> yang menampilkan tanda "x" sebagai 
                                ikon untuk tombol close. Atribut aria-hidden="true" menunjukkan bahwa elemen ini tidak terlihat oleh pembaca layar. --}}
                            </button>
                            {{-- Ini adalah elemen <button> yang berfungsi sebagai tombol close untuk modal. 
                            Atribut data-dismiss="modal" digunakan untuk menutup modal saat tombol ini diklik. 
                            Atribut aria-label="Close" memberikan deskripsi aksesibilitas untuk tombol close. --}}
                        </div>
                        <div class="modal-body">{{-- Ini adalah elemen <div> yang mewakili isi atau konten dari modal. Elemen ini berisi elemen-elemen lain yang ingin ditampilkan dalam modal. --}}
                            <div class="w-100">{{-- Kelas ini memberikan lebar 100% pada elemen ini. --}}
                                <table class="table table-bordered">{{-- digunakan untuk membuat tabel --}}
                                    <thead>{{-- digunakan untuk mendefinisikan kepala tabel. Bagian ini biasanya berisi baris dengan judul kolom tabel --}}
                                        <tr>{{-- digunakan untuk mendefinisikan baris dalam tabel. --}}
                                            <th>Kode Aturan</th>{{-- elemen <th> yang digunakan untuk mendefinisikan sel header dalam tabel. Masing-masing elemen ini berisi teks yang menjadi judul kolom. --}}
                                            <th>Kode Kerusakan</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>{{--  elemen <tbody> yang digunakan untuk mendefinisikan tubuh tabel. Bagian ini biasanya berisi baris-baris data dalam tabel. --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">{{-- lebar kolom 12 --}}
            <div class="container-fluid bg-white p-4">
            {{-- Kelas "container-fluid" memberikan padding di sekitar elemen dan memenuhi lebar penuh dari 
            container. Kelas "bg-white" memberikan latar belakang putih pada elemen. Kelas "p-4" memberikan 
            padding 4 satuan pada semua sisi elemen. --}}
                <div class="mb-4">{{-- margin bawah 4 satuan --}}
                    <table>{{-- membuat tabel --}}
                        <div class="container-small">
                            <div class="row">{{-- Kelas "row" digunakan untuk mengelompokkan kolom-kolom dalam grid sistem Bootstrap. --}}
                                <div class="w-100">{{-- memberikan lebar 100% --}}
                                    {{-- tampilan tabel dengan judul kolom (Tanggal, Nama, No HP, Tahun Motor, Pilihan Gejala, Aksi) yang dapat diisi dengan data. --}}
                                    <table class="table table-bordered yajra-datatable">
                                    {{-- Ini adalah elemen <table> dengan beberapa kelas, yaitu "table", "table-bordered", dan "yajra-datatable". 
                                    Kelas "table" memberikan gaya default pada tabel, kelas "table-bordered" menambahkan garis tepi pada setiap 
                                    sel dalam tabel, dan "yajra-datatable" mungkin merujuk pada penggunaan library atau plugin DataTables. --}}
                                        <thead>{{-- kepala tabel, berisi baris dengan judul kolom --}}
                                            <tr>{{-- digunakan untuk mendefinisikan baris dalam tabel. --}}
                                                <th>Tanggal</th>
                                                <th>Nama</th>
                                                <th>No HP</th>
                                                <th>Tahun Motor</th>
                                                <th>Pilihan Gejala</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>{{-- digunakan untuk mendefinisikan tubuh tabel. Bagian ini biasanya berisi baris-baris data dalam tabel. --}}
                                    </table>
                                </div>

                                <form action="" id="delete-form" method="post">
                                    @method('delete')
                                    @csrf{{-- melindungi dari serangan cross-site request forgery --}}
                                </form>{{-- kode tersebut membuat sebuah form dengan id "delete-form" yang menggunakan metode "POST" 
                                dan mengandung directive Blade @method('delete') dan @csrf. Form ini dapat digunakan untuk mengirimkan 
                                permintaan "DELETE" melalui AJAX dengan menggunakan JavaScript. --}}

                                @section('javascript'){{-- menentukan awal dari sebuah blok JavaScript pada halaman --}}
                                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
                                {{--  Ini adalah elemen <script> dalam HTML yang mengimpor library Chart.js ke halaman. Chart.js adalah library untuk membuat grafik dan bagan dengan menggunakan HTML5 Canvas. --}}
                                <script>
                                    $(function() {
                                        var table = $('.yajra-datatable').DataTable({
                                            processing: true,//Properti ini mengaktifkan indikator proses untuk menunjukkan bahwa data sedang dalam proses pengolahan. Ini berguna ketika memuat data secara asynchronous.
                                            serverSide: true,//Properti ini mengaktifkan mode server-side processing pada plugin DataTables. Dalam mode ini, tabel akan meminta data dari server menggunakan AJAX dan melakukan pengolahan data di sisi server. Hal ini memungkinkan penanganan yang efisien untuk jumlah data yang besar.
                                            responsive: true,//Properti ini mengaktifkan responsivitas pada tabel, sehingga tabel akan menyesuaikan diri dengan ukuran layar atau kontainer yang lebih kecil.
                                            ajax: "{{ route('laporan.index') }}",//Properti ini menentukan URL dari mana tabel akan memuat data. 

                                            columns: [
                                                {data: 'created_at', name: 'created_at'},
                                                {data: 'nama', name: 'nama'},
                                                {data: 'no_hp', name: 'no_hp'},
                                                {data: 'tahun_motor', name: 'tahun_motor'},
                                                {data: 'pilihan_gejalas', name: 'pilihan_gejalas'},
                                                {data: 'aksi', name: 'aksi'},
                                            ]
                                        });

                                        $('body').on('click', '[data-id]', function() {// Ketika ada klik pada elemen dengan atribut data-id
                                            var id = $(this).data('id');//Mendapatkan nilai dari data-id pada elemen yang diklik
                                            var url = "{{ route('laporan.detail', ':id') }}";//Mendefinisikan URL dengan parameter :id yang akan digantikan nanti
                                            url = url.replace(':id', id);// Mengganti ':id' dalam URL dengan nilai id yang didapatkan dari elemen yang diklik
                                            $.getJSON(url, function(data) {//Mengirimkan permintaan AJAX menggunakan $.getJSON untuk mengambil data dari URL yang sudah disiapkan
                                                //Ketika data berhasil diambil, lakukan pengolahan data
                                                var html = '';//Siapkan variabel html yang akan digunakan untuk menyusun tampilan data
                                                //Loop melalui data yang diterima dari permintaan AJAX dan susun tampilan dalam bentuk tabel
                                                $.each(data, function(key, value) {
                                                    html += '<tr>';
                                                    html += '<td>' + value.kode_aturan + '</td>';
                                                    html += '<td>' + value.kode_kerusakan + '</td>';
                                                    html += '<td>' + value.persentase + '</td>';
                                                    html += '</tr>';
                                                });
                                                //Tampilkan modal dengan id 'modalTambahBarang' dan isi tbody-nya dengan tampilan data yang telah disusun
                                                $('#modalTambahBarang').modal('show');
                                                $('#modalTambahBarang tbody').html(html);
                                            });
                                        });

                                        var tahunMotorEl = document.getElementById('tahunMotor').getContext('2d');
                                        //Mengambil elemen dengan ID tahunMotor dan mendapatkan konteks 2D untuk elemen tersebut. 
                                        //tahunMotorEl akan digunakan sebagai elemen tempat untuk menggambar grafik batang.
                                        var tahunMotorChart = null;//Mendeklarasikan variabel tahunMotorChart dengan nilai awal null. 
                                        //Variabel ini akan digunakan untuk menyimpan instance Chart.js setelah grafik dibuat.
                                        var dataTahunMotor = $.getJSON("{{ route('laporan.grafik') }}", function(data) {
                                        //Menggunakan jQuery $.getJSON untuk mengambil data dari URL yang didefinisikan dengan 
                                        //menggunakan template {{ route('laporan.grafik') }}. Data tersebut kemudian akan diproses 
                                        //dalam fungsi callback yang menerima parameter data.
                                            tahunMotorChart = new Chart(tahunMotorEl, {
                                                type: 'bar',//jenis grafik adalah 'bar' (grafik batang).
                                                data: {
                                                    labels: data.totalTahunMotor.labels,//Data untuk grafik berasal dari objek data.totalTahunMotor.
                                                    //labels adalah array yang berisi label-label untuk sumbu X.
                                                    datasets: data.totalTahunMotor.datasets//datasets adalah array yang berisi data untuk setiap batang dalam grafik
                                                },
                                                options: {
                                                    responsive: true,//mengizinkan grafik menyesuaikan ukuran secara responsif dengan ukuran elemen tempatnya.
                                                    //Opsi konfigurasi plugins digunakan untuk mengatur legend dan judul grafik.
                                                    plugins: {
                                                        legend: {//menempatkan legenda di atas grafik.
                                                            position: 'top',
                                                        },
                                                        title: {//menampilkan judul grafik di bagian atas.
                                                            display: true,
                                                            text: 'Grafik Laporan Tahun Ini'
                                                        }
                                                    }
                                                }
                                            })
                                        });

                                        var tahunKerusakanEl = document.getElementById('tahunKerusakan').getContext('2d');
                                        var tahunKerusakanChart = null;
                                        var datatahunKerusakan = $.getJSON("{{ route('laporan.grafik') }}", function(data) {
                                            tahunKerusakanChart = new Chart(tahunKerusakanEl, {
                                                type: 'bar',
                                                data: {
                                                    labels: data.totalKerusakan.labels,
                                                    datasets: data.totalKerusakan.datasets
                                                },
                                                options: {
                                                    responsive: true,
                                                    plugins: {
                                                        legend: {
                                                            position: 'top',
                                                        },
                                                        title: {
                                                            display: true,
                                                            text: 'Grafik Laporan Kerusakan Tahun Ini'
                                                        }
                                                    }
                                                }
                                            })
                                        });

                                        $('#tahun_grafik').on('change', function() {
                                            var tahun = this.value;
                                            tahunMotorChart.destroy();
                                            tahunKerusakanChart.destroy();

                                            var data = $.getJSON("{{ route('laporan.grafik') }}?tahun=" + tahun, function(data) {
                                                tahunMotorChart = new Chart(tahunMotorEl, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: data.totalTahunMotor.labels,
                                                        datasets: data.totalTahunMotor.datasets
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        plugins: {
                                                            legend: {
                                                                position: 'top',
                                                            },
                                                            title: {
                                                                display: true,
                                                                text: 'Grafik Laporan Tahun ' + tahun
                                                            }
                                                        }
                                                    }
                                                })

                                                tahunKerusakanChart = new Chart(tahunKerusakanEl, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: data.totalKerusakan.labels,
                                                        datasets: data.totalKerusakan.datasets
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        plugins: {
                                                            legend: {
                                                                position: 'top',
                                                            },
                                                            title: {
                                                                display: true,
                                                                text: 'Grafik Laporan Kerusakan Tahun ' + tahun
                                                            }
                                                        }
                                                    }
                                                })
                                            });
                                        });
                                    });
                                </script>
                                @endsection
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
