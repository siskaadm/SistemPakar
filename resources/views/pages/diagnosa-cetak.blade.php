{{-- dompdf --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Diagnosa</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
        }
        th {
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .d-block {
            display: block;
        }
        .badge {
            border-radius: 0.375rem;
            color: #fff;
            display: inline-block;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            padding: 0.35em 0.65em;
            text-align: center;
            vertical-align: baseline;
            white-space: nowrap;
        }
        .bg-success {
            background-color: #28a745;
        }
        .bg-warning {
            background-color: #ffc107;
        }
        .bg-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="table-responsive">
        <table id="hasil" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="2" class="text-center" style="font-size: 1.5rem; text-transform: uppercase;">Hasil Diagnosa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="50%" valign="top" style="border-right: none">
                        {{-- <div>
                            <strong>ID : </strong>
                            {{ $id }}
                        </div> --}}
                        <div>
                            <strong>Tanggal : </strong>
                            {{ $tanggal }}
                        </div>
                    </td>
                    <td valign="top" style="border-left: none">
                        <div>
                            <strong>Nama : </strong>
                            {{ $nama }}
                        </div>
                        <div>
                            <strong>No. HP : </strong>
                            {{ $no_hp }}
                        </div>
                        <div>
                            <strong>Tahun Motor : </strong>
                            {{ $tahun_motor }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-bottom: none;">
                        <div>
                            <strong class="d-block">Gejala yang Dipilih : </strong>
                        </div>
                    </td>
                </tr>
                <tr>
                    @if ($gejalas)
                        <td style="border-right: none; border-top: none;">
                            <ul>
                                @foreach ($gejalas[0] as $gejala)
                                    <li>{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td style="border-left: none; border-top: none;">
                            <ul>
                                @if (isset($gejalas[1]))
                                    @foreach ($gejalas[1] as $gejala)
                                        <li>{{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                    @else
                        <ul>
                            <li>Tidak ada gejala yang dipilih</li>
                        </ul>
                    @endif
                </tr>
                <tr>
                    <td colspan="2">
                        <strong class="d-block">Jumlah Potensi Kerusakan :</strong>
                        @if ($hasil)
                            @if ($kerusakanKuat)
                                <p>Kami menemukan 1 kerusakan kuat dan {{ count($hasil) - 1 }} potensi kerusakan terkait yang mungkin terjadi pada motor anda.<br>Silahkan periksa hasil diagnosa dibawah.</p>
                            @else
                                <p>Kami tidak menemukan kerusakan kuat, tapi ada {{ count($hasil) }} potensi kerusakan yang mungkin terjadi pada motor anda.<br>Silahkan periksa hasil diagnosa dibawah.</p>
                            @endif
                        @else
                            <p>Kami tidak menemukan potensi kerusakan apapun pada motor anda.<br>Anda dapat mendiagnosa lagi untuk memastikan.</p>
                        @endif
                    </td>
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
</body>
</html>