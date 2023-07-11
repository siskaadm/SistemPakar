<?php

namespace App\Http\Controllers\Admin;//folder

use App\Http\Controllers\Controller;//use adalah library/alat alat 
use App\Models\Kerusakan;
use App\Models\Laporan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index(Request $request)
	{// fungsi index  digunakan untuk menampilkan halaman laporan dan mengambil data laporan dari database.
		if ($request->ajax()) {//Jika request yang diterima adalah AJAX request, maka fungsi akan mengambil data laporan dari database dan melakukan beberapa pengolahan pada data tersebut.
            $data = Laporan::get();

			foreach ($data as &$laporan) {
				$kerusakan = Kerusakan::where('kode_kerusakan', $laporan->kode_kerusakan)->first();
				$laporan->nama = (User::where('id', $laporan->user_id)->first())->name;
				// Dalam pengolahan data, setiap laporan akan diiterasi dan diubah beberapa atributnya. Misalnya, atribut 'nama' akan diisi dengan nama pengguna yang sesuai berdasarkan user_id yang terkait dengan laporan tersebut.
			}

			//Setelah itu, atribut 'pilihan_gejalas' akan diubah menjadi string dengan memisahkan nilai-nilainya menggunakan koma.
			$laporan->pilihan_gejalas = implode(', ', $laporan->pilihan_gejalas);
			//Fungsi akan mengembalikan response dalam format DataTables dengan menggunakan library DataTables. Data yang dikirimkan ke DataTables adalah data laporan yang telah diproses.
            return DataTables::of($data)
				->addColumn('aksi', function(Laporan $row) {
                	$detailBtn = '<button type="button" class="btn btn-md btn-info mr-2 mb-2 mb-lg-0" data-id="' . $row->id . '" data-toggle="modal" data-target="#modalLaporanDetails"><i class="far fa-eye"></i> Details</button>';

					return $detailBtn;
				})
				->rawColumns(['aksi'])//rawColumns untuk memberitahu DataTables agar tidak melakukan escape pada kolom 'aksi'.
				->make(true);
        }

		//Jika request bukan AJAX request, maka fungsi akan mengambil semua laporan dan tahun-tahun unik dari laporan untuk digunakan dalam tampilan halaman laporan.
		$laporans = Laporan::all();
		$tahuns = Laporan::selectRaw('extract(year from created_at) as year')
			->distinct()
			->orderBy('year', 'desc')
			->get()
			->pluck('year')
			->toArray();

		return view('admin.pages.laporan.index', compact('laporans', 'tahuns'));
	}

	//fungsi export digunakan untuk mengekspor laporan dalam rentang tanggal tertentu.
	public function export()
	{
		Request()->validate([//melakukan validasi terhadap inputan 'from' dan 'to' yang diterima.
			'from' => 'required',
			'to' => 'required'
		]);
		//Jika tanggal awal (from) lebih besar dari tanggal akhir (to), maka fungsi akan mengembalikan kembali ke halaman sebelumnya dengan pesan error.
		if (Request()->from > Request()->to) {
			return back()->with('error', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
		}
		//Jika tanggal awal (from) sama dengan tanggal akhir (to), maka fungsi akan mengembalikan kembali ke halaman sebelumnya dengan pesan error.
		if (Request()->from == Request()->to) {
			return back()->with('error', 'Tanggal awal tidak boleh sama dengan tanggal akhir');
		}
		//Jika tanggal awal (from) atau tanggal akhir (to) kosong, maka fungsi akan mengembalikan kembali ke halaman sebelumnya dengan pesan error.
		if (Request()->from == null || Request()->to == null) {
			return back()->with('error', 'Tanggal awal dan akhir tidak boleh kosong');
		}
		//Jika validasi berhasil, fungsi akan mengambil data laporan dari database yang memiliki tanggal pembuatan (created_at) di antara rentang tanggal 'from' dan 'to'.
		$laporans = Laporan::whereBetween('created_at', [Request()->from, Request()->to])->get();
		//Fungsi akan mengembalikan view 'admin.pages.laporan.export' dengan variabel 'laporans' yang berisi data laporan yang sesuai dengan rentang tanggal yang dipilih.
		return view('admin.pages.laporan.export', compact('laporans'));
	}

	public function grafik(Request $request)
	{// fungsi grafik digunakan untuk menghasilkan data grafik berdasarkan laporan yang dibuat pada tahun tertentu.
		//mengambil tahun dari input 'tahun' yang diterima, atau menggunakan tahun saat ini jika tidak ada input yang diberikan.
		$tahun = $request->tahun ?: Carbon::now()->year;

		# Grafik Total Tahun Motor
		//mengambil data laporan dengan menggunakan query builder. Query ini akan menghitung jumlah laporan (total), 
		//bulan pembuatan laporan (bulan), dan tahun motor dari tabel laporan. Data tersebut diambil hanya untuk 
		//tahun yang sesuai dengan input 'tahun'.
		$laporans = Laporan::selectRaw('count(*) as total, monthname(created_at) as bulan, tahun_motor')
			->whereYear('created_at', $tahun)
			->groupBy(['bulan', 'tahun_motor'])
			->orderBy('bulan', 'desc')
			->get();
		//Hasil data laporan akan dikelompokkan berdasarkan bulan dan tahun motor, kemudian diurutkan berdasarkan bulan secara menurun.
		//Variabel $totalTahunMotor dan $totalKerusakan diinisialisasi sebagai array kosong.
		$totalTahunMotor = array();
		$totalKerusakan = array();
		//Variabel $data diinisialisasi sebagai array yang berisi $totalTahunMotor dan $totalKerusakan
		$data = array(
			'totalTahunMotor' => $totalTahunMotor,
			'totalKerusakan' => $totalKerusakan
		);
		$labels = array();
		$datasets = array();
		//Di dalam $datasets, diberikan konfigurasi untuk dataset 'total' yang akan digunakan dalam grafik. Label dataset diatur sebagai 'Total' dan jenis grafiknya adalah 'line'.
		$datasets['total']['label'] = 'Total';
		$datasets['total']['type'] = 'line';

		if (!$laporans) {
			//Variabel $labels dan $datasets yang berisi struktur data untuk grafik disimpan dalam variabel $data.
			//Mengatur $labels dan $datasets ke dalam array $data.
			$data['labels'] = $labels;
			$data['datasets'] = $datasets;
			return response()->json($data);//Mengembalikan respons JSON yang berisi data dalam format $data
		}

		//perulangan foreach digunakan untuk mengolah data laporan yang ditemukan dalam variabel $laporans.
		foreach ($laporans as $laporan) {
			//$laporan->bulan digunakan sebagai kunci untuk memperbarui array $labels dengan menambahkan entri 
			//dengan nilai yang sama. Hal ini bertujuan untuk mengumpulkan label bulan yang unik untuk digunakan dalam grafik.
			$labels[$laporan->bulan] = $laporan->bulan;
			//Variabel $laporan->tahun_motor digunakan sebagai kunci untuk mengakses array $datasets. Di dalam array tersebut, 
			//terdapat entri yang menyimpan label dan data terkait dengan tahun motor tersebut.
			$datasets[$laporan->tahun_motor]['label'] = 'Tahun Motor '.$laporan->tahun_motor;
			$datasets[$laporan->tahun_motor]['data'][$laporan->bulan] = $laporan->total ?? 0;
			//$laporan->total ditambahkan ke dalam entri $datasets[$laporan->tahun_motor]['data'][$laporan->bulan]. 
			//Ini bertujuan untuk menyimpan jumlah total laporan pada bulan dan tahun motor tertentu.
			$jumlah = $datasets['total']['data'][$laporan->bulan] ?? 0;
			//menyimpan jumlah total laporan pada bulan tertentu, tidak tergantung pada tahun motor.
			$datasets['total']['data'][$laporan->bulan] = $jumlah + $laporan->total;
		}

		//mengolah variabel $labels dan $datasets untuk mempersiapkannya dalam format yang sesuai dengan struktur data yang digunakan dalam grafik.
		$labels = array_values($labels);//mengambil nilai-nilai dari array $labels dan mengembalikannya dalam bentuk array baru. 
		//Langkah ini dilakukan untuk menghapus kunci asosiatif dan mengatur ulang indeks array menjadi berurutan.
		//mengambil nilai-nilai dari array $datasets['total']['data'] dan mengembalikannya dalam bentuk array baru
		//Ini dilakukan untuk menghapus kunci asosiatif dan mengatur ulang indeks array menjadi berurutan.
		$datasets['total']['data'] = array_values($datasets['total']['data']);
		$datasets = array_values($datasets);// mengambil nilai-nilai dari array $datasets dan mengembalikannya dalam bentuk array baru
		//Nilai-nilai yang telah diatur ulang ini kemudian digunakan untuk mengisi array $totalTahunMotor dengan entri baru. 
		//['labels'] akan diisi dengan nilai dari $labels yang sudah diatur ulang, 
		//sedangkan ['datasets'] akan diisi dengan nilai dari $datasets yang sudah diatur ulang.
		$totalTahunMotor['labels'] = $labels;
		$totalTahunMotor['datasets'] = $datasets;

		# Grafik Total Kerusakan
		//Kueri selectRaw() digunakan untuk mengambil kolom-kolom tertentu dan melakukan penghitungan dengan fungsi agregat count(*) untuk menghitung jumlah laporan yang memenuhi kondisi.
		$laporans = Laporan::selectRaw('count(*) as total, monthname(created_at) as bulan, detail.kode_kerusakan')
			//Klausa join() digunakan untuk melakukan join antara tabel laporans dan laporan_details berdasarkan kunci asing dan kunci primer.
			->join('laporan_details as detail', 'detail.laporan_id', '=', 'laporans.id')
			->whereYear('created_at', $tahun)//memfilter laporan berdasarkan tahun yang diinginkan.
			->groupBy(['bulan', 'detail.kode_kerusakan'])//mengelompokkan data berdasarkan bulan dan kode kerusakan.
			->orderBy('bulan', 'desc')//mengurutkan data berdasarkan bulan secara menurun (desc).
			->get();//mengeksekusi kueri dan mengambil hasilnya
		//variabel $labels dan $datasets diinisialisasi sebagai array kosong yang akan digunakan untuk memuat data yang akan diolah lebih lanjut.
		$labels = array();
		$datasets = array();
		// $datasets['total']['label'] = 'Persentase';
		// $datasets['total']['type'] = 'line';

		//mengecek apakah variabel $laporans kosong atau tidak. Jika variabel tersebut kosong, artinya tidak ada data yang ditemukan sesuai dengan kueri yang dijalankan sebelumnya.
		if (!$laporans) {
			$data['totalTahunMotor'] = $totalTahunMotor;
			$data['totalKerusakan'] = $totalKerusakan;
			return response()->json($data);
		}

		foreach ($laporans as $laporan) {//dilakukan perulangan foreach untuk setiap $laporan dalam $laporans
			//Mencari informasi kerusakan terkait dengan kode kerusakan dalam variabel $laporan.Hasilnya disimpan dalam variabel $kerusakan
			$kerusakan = Kerusakan::where('kode_kerusakan', $laporan->kode_kerusakan)->first();
			//Menambahkan nilai $laporan->bulan ke dalam array $labels sebagai label.
			$labels[$laporan->bulan] = $laporan->bulan;
			//Mengisi data dalam array $datasets untuk setiap kerusakan. 
			//Setiap kerusakan memiliki label yang terdiri dari "Kerusakan [kode_kerusakan] - [nama_kerusakan]". 
			//Data kerusakan ditambahkan ke dalam array $datasets[$laporan->kode_kerusakan]['data'][] dengan nilai $laporan->total. 
			//Data kerusakan untuk setiap kerusakan akan ditambahkan ke dalam array tersebut.
			$datasets[$laporan->kode_kerusakan]['label'] = 'Kerusakan '.$laporan->kode_kerusakan . ' - ' . $kerusakan->nama_kerusakan;
			$datasets[$laporan->kode_kerusakan]['data'][] = $laporan->total;

			// $jumlah = $datasets['total']['data'][$laporan->bulan] ?? 0;
			// $datasets['total']['data'][$laporan->bulan] = $jumlah + $laporan->total;
		}
		//engubah array $labels menjadi array yang hanya berisi nilai-nilai dengan menggunakan fungsi array_values()
		//Hasilnya disimpan kembali dalam variabel $labels.
		$labels = array_values($labels);
		//Mengubah array $datasets menjadi array yang hanya berisi nilai-nilai dengan menggunakan fungsi array_values(). 
		//Hasilnya disimpan kembali dalam variabel $datasets.
		$datasets = array_values($datasets);
		//Membuat array $totalKerusakan dengan menyimpan $labels sebagai nilai untuk kunci 'labels' dan $datasets sebagai nilai untuk kunci 'datasets'.
		$totalKerusakan['labels'] = $labels;
		$totalKerusakan['datasets'] = $datasets;

		$data['totalTahunMotor'] = $totalTahunMotor;//Menyimpan array $totalTahunMotor dalam kunci 'totalTahunMotor' dalam array $data
		$data['totalKerusakan'] = $totalKerusakan;

		return response()->json($data);//Mengembalikan respons JSON dengan mengirimkan array $data
	}

	public function detail($id)
	{
		//Mencari laporan berdasarkan ID yang diberikan menggunakan metode find() pada model Laporan. Hasilnya disimpan dalam variabel $laporan.
		$laporan = Laporan::find($id);
		$laporanDetails = $laporan->details;//Mengakses relasi details pada $laporan untuk mendapatkan detail laporan. 
		//Melakukan pengulangan foreach untuk setiap objek $laporanDetail dalam $laporanDetails.
		foreach ($laporanDetails as &$laporanDetail) {
			//menggabungkan kode kerusakan dengan nama kerusakan dari objek Kerusakan yang terkait dengan menggunakan relasi kerusakan. Hasilnya disimpan kembali dalam atribut $laporanDetail->kode_kerusakan.
			$laporanDetail->kode_kerusakan .= ' - ' . $laporanDetail->kerusakan->nama_kerusakan;
			$laporanDetail->persentase .= '%';
		}

		return response()->json($laporanDetails);
	}

}
