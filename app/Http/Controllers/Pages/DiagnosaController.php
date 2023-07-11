<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\KategoriSolusi;
use App\Models\Kerusakan;
use App\Models\Laporan;
use App\Models\RekomendasiSolusi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class DiagnosaController extends Controller
{
	public function index(Request $request)
	{//Fungsi index merupakan bagian dari sebuah kontroler dan digunakan untuk mengatur tindakan atau logika yang dilakukan saat mengakses halaman atau URL tertentu.
	//Fungsi tersebut menerima sebuah objek Request sebagai parameter, yang digunakan untuk mengakses data yang dikirim oleh pengguna melalui permintaan HTTP.
		$step = $request->get('step', 'datadiri');
		//Variabel $step akan mendapatkan nilai dari parameter 'step' yang dikirim dalam permintaan HTTP. Jika parameter tidak ada, nilai default 'datadiri' akan digunakan.
		$gejalas = Gejala::all();//Mengambil semua data gejala dari model Gejala dan menyimpannya dalam variabel $gejalas.
		$kerusakans = Kerusakan::all();
		return view('pages.diagnosa', compact('gejalas', 'kerusakans', 'step'));
		//Mengembalikan tampilan (view) dengan nama 'pages.diagnosa' dan mengirimkan data-data $gejalas, $kerusakans, dan $step ke tampilan tersebut menggunakan fungsi compact.
	}

	public function proses(Request $request)
	{//Fungsi proses merupakan bagian dari sebuah kontroler dan digunakan untuk mengatur tindakan atau logika yang dilakukan saat memproses suatu permintaan yang dikirim oleh pengguna melalui metode POST.
		$step = $request->post('step', '1');

		if ($step == '1') {
			$request->validate([
				// 'nama' => 'required',
				'no_hp' => 'required|digits_between:10,13|numeric',
				'tahun_motor' => 'required|numeric',
			]);//untuk memproses data yang diterima dari permintaan POST. Pada tahap pertama (step 1)

			$request->session()->put('nama', auth()->user()->name);//Menyimpan nama pengguna yang diotentikasi saat ini ke dalam sesi dengan key 'nama'
			$request->session()->put('no_hp', $request->post('no_hp'));
			$request->session()->put('tahun_motor', $request->post('tahun_motor'));

			return redirect()->route('page.diagnosa', ['step' => 'pertanyaan']);
		}

		if ($step == '2') {
			$request->validate([
				'gejala' => 'required',
			]);
		//pada tahap kedua ($step == '2'), validasi dilakukan untuk memastikan bahwa field 'gejala' tidak boleh kosong. Jika validasi gagal, maka akan dikembalikan pesan kesalahan kepada pengguna.

			$step = 'hasil';
			$nama = auth()->user()->name ?: '';
			$no_hp = $request->session()->get('no_hp') ?: '';
			$tahun_motor = $request->session()->get('tahun_motor') ?: '';
			// Ambil semua pilihan ya/tidak gejala dari user
			$pilihan_gejalas = $request->post('gejala') ?: [];
			$kerusakanKuat = false;
			
			// Filter yang nilai pilihannya itu ya/1, selain itu dibuang
			$pilihan_gejalas = array_filter($pilihan_gejalas, function ($checkbox) {
				return $checkbox == 1;
			});
			// Ekstrak kata kunci saja
			$pilihan_gejalas = array_keys($pilihan_gejalas);
			// Ambil semua aturan yang ada
			$aturans = Aturan::all();

			$hasil = [];
			// Metode chaining forward dengan perulangan per aturan untuk mengecek apakah
			// daftar kata kunci pilihan gejala user yaitu $pilihan_gejalas
			// terkandung di dalam kode gejala milik aturan yang di cek
			// kemudian dihitung persentase kemungkinannya berdasarkan total yang terkandung
			// di dalam aturan dan total kode gejala aturan
			foreach ($aturans as $aturan) {
				// Ambil daftar kode gejala dari aturan
				$kode_gejala = $aturan->kode_gejala;
				// Filter untuk membuang kode gejala yang kosong atau tak bernilai dari daftar
				$kode_gejala = array_filter($kode_gejala, function ($kode) {
					return $kode != '';
				});
				// Cari daftar pilihan gejala yang terkandung di dalam daftar $kode_gejala
				$gejala_ditemukan = array_intersect($pilihan_gejalas, $kode_gejala);
				// Hitung persentase kemungkinan berdasarkan total yang terkandung / total daftar gejala aturan
				$persentase = count($gejala_ditemukan) / count($kode_gejala);
				// Masukkan ke dalam hasil apabila kemungkinannya di atas 0%
				if ($persentase > 0) {
					// Membulatkan persentase
					$aturan['persentase'] = round($persentase * 100, 2);//2 adalah jumlah angka dibelakang koma
					// Memasukkan aturan yang valid ke dalam hasil
					$hasil[] = $aturan;
				}
			}

			//melakukan pengecekan apakah data gejala yang dipilih atau hasil diagnosa sudah tersedia atau valid
			$gejalas = Gejala::whereIn('kode_gejala', $pilihan_gejalas)->get();

			if (!$gejalas || !$hasil || count($gejalas) < 1) {
				return view('pages.diagnosa', [
					'nama' => $nama,
					'no_hp' => $no_hp,
					'tahun_motor' => $tahun_motor,
					'gejalas' => $gejalas,
					'hasil' => $hasil,
					'step' => $step,
					'json' => '',
					'kerusakanKuat' => $kerusakanKuat,
				]);
			}

			//untuk mengurutkan presentase tertinggi ke terendah
			usort($hasil, function ($aturan1, $aturan2) {
				return $aturan2['persentase'] <=> $aturan1['persentase'];
			});

			//jika presentase lebih dari 60% maka dinyakatan kerusakan kuat
			if ($hasil[0]['persentase'] > 60) {
				$kerusakanKuat = true;
			}

			//membuat sebuah objek Laporan baru dengan properti yang diisi sesuai dengan data yang diberikan, dan kemudian menyimpannya ke dalam database.
			$laporan = new Laporan([
				'user_id' => auth()->user()->id,
				'no_hp' => $no_hp,
				'tahun_motor' => $tahun_motor,
				'pilihan_gejalas' => $pilihan_gejalas,
			]);
			$laporan->save();

			//perulangan foreach untuk mengiterasi melalui setiap elemen dalam array $hasil. array $hasil direpresentasikan oleh variabel $aturan. Pada setiap iterasi, variabel $aturan akan berisi satu elemen array.
			foreach ($hasil as &$aturan) {
				$kode_kerusakan = $aturan->kerusakans->kode_kerusakan;//Variabel $kode_kerusakan diisi dengan nilai 'kode_kerusakan' dari relasi kerusakans pada objek $aturan.
				$kerusakan = Kerusakan::where
				('kode_kerusakan', $kode_kerusakan)->first();//berdasarkan kerusakan yang didapat sebelumnya
				$kode_kategori = $kerusakan->kode_kategori;//Variabel $kode_kategori diisi dengan nilai 'kode_kategori' dari objek $kerusakan.
				$kategori = KategoriSolusi::where('kode_kategori', $kode_kategori)->first();
				$solusisIds = $kategori->solusis;
				$solusis = RekomendasiSolusi::whereIn('kode_solusi', $solusisIds)->get();
				$aturan_gejalas = Gejala::whereIn('kode_gejala', $aturan->kode_gejala)->get();

				$aturan['kode_kerusakan'] = $kode_kerusakan;
				$aturan['kerusakan'] = $kerusakan;
				$aturan['solusis'] = $solusis;
				$aturan['gejalas'] = $aturan_gejalas;

				//Objek $laporan (yang telah dibuat sebelumnya) menggunakan metode details() untuk membuat relasi baru dengan model DetailLaporan dan menyimpan data terkait dengan elemen saat ini dalam perulangan.
				$laporan->details()->create([
					'kode_aturan' => $aturan->kode_aturan,
					'kode_kerusakan' => $kode_kerusakan,
					'kode_kategori' => $kode_kategori,
					'persentase' => $aturan['persentase'],
				]);
			}

			//langkah-langkah untuk membuat dan menyimpan cache hasil diagnosa.
			$id = time() . rand(100, 99999);//Variabel $id diisi dengan gabungan dari waktu saat ini dan bilangan acak antara 100 dan 99999. Ini digunakan sebagai identifikasi unik untuk cache.
			$tanggal = date('d-m-Y H:i:s');
			$cache = array_merge($hasil, [
				'id' => $id,
				'tanggal' => $tanggal,
				'nama' => $nama,
				'no_hp' => $no_hp,
				'tahun_motor' => $tahun_motor,
				'gejalas' => $gejalas,
				'kerusakanKuat' => $kerusakanKuat,
			]);
			Cache::put('hasil-diagnosa-' . $id, $cache, 60 * 60 * 1);//digunakan untuk menyimpan data $cache ke dalam cache dengan kunci 'hasil-diagnosa-' ditambahkan dengan nilai $id. Data tersebut akan disimpan dalam cache selama 1 jam (60 * 60 * 1 detik).
			$json = json_encode($id);//Variabel $json diisi dengan hasil pengkodean JSON dari nilai $id. Ini digunakan untuk mengirimkan nilai $id sebagai data JSON ke view.

			//mengembalikan view 'pages.diagnosa' dengan variabel-variabel yang telah diisi sebelumnya
			return view('pages.diagnosa', compact('nama', 'no_hp', 'tahun_motor', 'gejalas', 'hasil', 'step', 'json', 'kerusakanKuat'));
		}
	}

	//bagian dari fungsi cetak yang digunakan untuk menghasilkan file PDF dari hasil diagnosa.
	public function cetak(Request $request)
	{
		$id = $_COOKIE['hasil'] ?? '';
		$id = json_decode($id);
		$hasil = Cache::get('hasil-diagnosa-' . $id);
		$kerusakanKuat =  $hasil['kerusakanKuat'] ?: false;
		//Variabel $hasil diisi dengan nilai dari cache 'hasil-diagnosa-' ditambah dengan nilai $id. Jika tidak ada hasil yang ditemukan dalam cache, fungsi akan mengarahkan pengguna kembali ke halaman diagnosa.
		if (!$hasil) {
			return redirect()->route('page.diagnosa');
		}

		$id = $hasil['id'] ?: '';
		$tanggal = $hasil['tanggal'] ?: '';
		$nama = $hasil['nama'] ?: '';
		$no_hp = $hasil['no_hp'] ?: '';
		$tahun_motor = $hasil['tahun_motor'] ?: '';
		$gejalas = $hasil['gejalas'] ?: [];
		//Jika jumlah gejala lebih dari 3, array gejala akan dibagi menjadi dua bagian. Jika tidak, array gejala akan tetap dalam satu bagian.
		$gejalas = count($gejalas) > 3 ? $gejalas->split(2) : [$gejalas];
		//Elemen-elemen yang tidak diperlukan seperti 'id', 'tanggal', 'nama', 'no_hp', 'tahun_motor', 'gejalas', dan 'kerusakanKuat' dihapus dari array $hasil.
		unset($hasil['id']);
		unset($hasil['tanggal']);
		unset($hasil['nama']);
		unset($hasil['no_hp']);
		unset($hasil['tahun_motor']);
		unset($hasil['gejalas']);
		unset($hasil['kerusakanKuat']);

		//Objek PDF diinisialisasi menggunakan view 'pages.diagnosa-cetak' dengan variabel-variabel yang telah diisi sebelumnya.
		$pdf = Pdf::loadView('pages.diagnosa-cetak', compact('id', 'tanggal', 'nama', 'no_hp', 'tahun_motor', 'gejalas', 'hasil', 'kerusakanKuat'));
		$pdf->setPaper('A4', 'potrait');//Ukuran kertas PDF diatur menjadi 'A4' dan orientasi menjadi 'portrait'.
		return $pdf->stream('hasil-diagnosa.pdf');//engembalikan file PDF dengan nama 'hasil-diagnosa.pdf
	}
}
