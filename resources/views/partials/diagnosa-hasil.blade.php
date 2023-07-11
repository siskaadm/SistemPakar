<form id="diagnosa" class="form">
    {{-- Indicators --}}
    <div class="form-header d-flex mb-4">
        <span class="indicator__step">Data Diri</span>
        <span class="indicator__step">Isi Pertanyaan</span>
        <span class="indicator__step active">Hasil Diagnosa</span>
    </div>
    {{-- End Indicators --}}
    
    {{-- Table Result --}}
    <div class="step">
        {{-- 
            Horizontal Table
            Nama: ,
            No. HP: ,
            Jawaban Pengguna: ,
            Hasil Diagnosa: ,
            Penyebab Kerusakan: ,
            Solusi Perbaikan: ,
            --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">Hasil Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong class="d-block">Nama</strong></td>
                        <td>{{ $nama }}</td>
                    </tr>
                    <tr>
                        <td><strong class="d-block">No. HP</strong></td>
                        <td>{{ $no_hp }}</td>
                    </tr>
                    <tr>
                        <td><strong class="d-block">Tahun Motor</strong></td>
                        <td>{{ $tahun_motor }}</td>
                    </tr>
                    <tr>
                        <td><strong class="d-block">Gejala yang Dipilih</td>
                        <td>
                            <ul>
                                @if ($gejalas)
                                    @foreach ($gejalas as $gejala)
                                        <li>{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</li>
                                    @endforeach
                                @else
                                    <li>Tidak ada gejala yang dipilih</li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td><strong class="d-block">Jumlah Potensi Kerusakan</strong></td>
                        @if ($hasil)
                            @if ($kerusakanKuat)
                                <td>Kami menemukan 1 kerusakan kuat dan {{ count($hasil) - 1 }} potensi kerusakan terkait yang mungkin terjadi pada motor anda.<br>Silahkan periksa hasil diagnosa dibawah.</td>
                            @else
                                <td>Kami tidak menemukan kerusakan kuat, tapi ada {{ count($hasil) }} potensi kerusakan yang mungkin terjadi pada motor anda.<br>Silahkan periksa hasil diagnosa dibawah.</td>
                            @endif
                        @else
                            <td>Kami tidak menemukan potensi kerusakan apapun pada motor anda.<br>Anda dapat mendiagnosa lagi untuk memastikan.</td>
                        @endif
                    </tr>
                </tbody>
            </table>

            @foreach ($hasil as $aturan)
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td>
                                <strong class="d-block">Kode Kerusakan</strong>
                                <small>Persentase Keyakinan</small>
                            </td>
                            <td>
                                @if ($aturan['kerusakan'])
                                    <strong class="d-block">{{ $aturan['kerusakan']->kode_kerusakan }} - {{ $aturan['kerusakan']->nama_kerusakan }}</strong>
                                @else
                                    <strong class="d-block">Kerusakan tidak ditemukan, mungkin motor anda baik-baik saja. <br>Anda dapat mendiagnosa lagi untuk memastikan.</strong>
                                @endif

                                <small>
                                    @if ($loop->first && $kerusakanKuat)
                                        <span class="badge bg-success">Kuat</span>
                                    @elseif ($aturan['persentase'] >= 80)
                                        <span class="badge bg-success">{{ $aturan['persentase'] }}%</span>
                                    @elseif ($aturan['persentase'] >= 50)
                                        <span class="badge bg-warning">{{ $aturan['persentase'] }}%</span>
                                    @else
                                        <span class="badge bg-danger">{{ $aturan['persentase'] }}%</span>
                                    @endif
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td><strong class="d-block">Aturan Kerusakan</strong></td>
                            @if ($aturan['gejalas'])
                                <td>
                                    <ol>
                                        @foreach ($aturan['gejalas'] as $gejala)
                                            <li>{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                            @else
                                <td><strong>-</strong></td>
                            @endif
                        </tr>
                        <tr>
                            <td><strong class="d-block">Solusi Perbaikan</strong></td>
                            @if ($aturan['solusis'])
                                <td>
                                    <ol>
                                        @foreach ($aturan['solusis'] as $solusi)
                                            <li>{{ $solusi->deskripsi_solusi }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                            @else
                                <td><strong>-</strong></td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            <a href="{{ route('page.diagnosa', ['step' => 'pertanyaan']) }}" class="btn btn-primary me-2">Diagnosa Lagi</a>
            <a href="{{ route('diagnosa.cetak') }}" class="btn btn-success" target="_blank">Cetak</a>
        </div>
    </div>
</form>

<script>
    // save string to cookie
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * (24 * 60 * 60 * 1000)));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + JSON.stringify(cvalue) + ";" + expires + ";path=/";
    }

    // get string from cookie
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookies = decodedCookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) == ' ') {
                cookie = cookie.substring(1);
            }

            if (cookie.indexOf(name) == 0) {
                return JSON.parse(cookie.substring(name.length, cookie.length));
            }
        }
        return "";
    }

    // delete cookie
    function deleteCookie(cname) {
        document.cookie = cname + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }

    setCookie('hasil', {!! $json !!}, 1);
</script>
