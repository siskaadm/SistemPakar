<?php //tag pembuka yang digunakan dalam bahasa pemrograman PHP.

namespace App\Http\Controllers\Admin;
//namespace digunakan untuk mengelompokkan kelas-kelas kontroler (controllers) 
//yang terkait dengan bagian administrasi (admin) dalam aplikasi web. 
//Namespace ini mengindikasikan bahwa kelas-kelas kontroler yang ditempatkan di dalamnya 
//berada dalam direktori "Admin" di dalam direktori "Controllers" di dalam direktori "Http" 
//di dalam namespace "App".
use App\Http\Controllers\Controller;
//use digunakan untuk mengimpor (import)elemen-elemen yang ada dalam namespace atau kelas 
//tertentu agar dapat digunakan dengan lebih mudah dan jelas dalam kode.
use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\KategoriSolusi;
use App\Models\Kerusakan;
use App\Models\RekomendasiSolusi;
use Illuminate\Http\Request;
//mengimpor kelas Request dari namespace Illuminate\Http.
use Yajra\DataTables\Facades\DataTables;
//Dengan menggunakan DataTables, dapat dengan mudah mengkonfigurasi dan mengelola tabel 
//yang interaktif dengan fitur-fitur seperti pencarian, penyaringan, pengurutan, dan sebagainya.
class AturanController extends Controller
//kelas kontroler digunakan dalam pola arsitektur Model-View-Controller (MVC) untuk 
//memisahkan logika bisnis dari presentasi (tampilan) dan interaksi dengan data.
//"extends Controller" menunjukkan bahwa kelas "AturanController" merupakan turunan (inheritance) 
//dari kelas "Controller". Kelas "Controller" sendiri adalah kelas dasar yang biasanya disediakan 
//oleh framework Laravel untuk memberikan fitur dan fungsionalitas yang umum digunakan dalam 
//pengembangan aplikasi web, seperti penanganan permintaan HTTP, validasi data, pengelolaan sesi, dll.
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    //deklarasi sebuah metode atau fungsi dengan nama "index()" yang dideklarasikan sebagai "public".
    //"public" adalah sebuah kata kunci aksesibilitas (visibility) yang mengindikasikan bahwa 
    //metode tersebut dapat diakses dan dipanggil dari bagian kode lainnya. Artinya, metode "index()" 
    //dapat diakses dari luar objek atau kelas yang mendefinisikannya.
    //"function" menandakan bahwa ini adalah deklarasi sebuah fungsi atau metode.
    //"index()" adalah nama fungsi atau metode yang diberikan.
    {
        $terbaru = Aturan::latest('kode_aturan')->limit(1)->get();
        //"Aturan" adalah sebuah model atau kelas yang mewakili tabel atau koleksi dalam basis data. 
        //Dalam hal ini, pernyataan tersebut mengacu pada model "Aturan" yang digunakan untuk 
        //berinteraksi dengan data terkait aturan.
        //"::latest('kode_aturan')" adalah metode statis dalam model "Aturan" yang digunakan untuk 
        //mengurutkan data berdasarkan kolom "kode_aturan" secara menurun (descending). 
        //Metode "latest" akan menghasilkan data dengan urutan terbaru berdasarkan kolom 
        //yang ditentukan.
        //"->limit(1)" adalah metode lanjutan yang digunakan untuk membatasi jumlah data yang akan 
        //diambil dari hasil pengurutan sebelumnya. Dalam hal ini, metode "limit" mengambil 
        //hanya 1 data terbaru dari hasil pengurutan.
        //"->get()" adalah metode terakhir yang mengambil hasil data dari kueri yang dibentuk 
        //sebelumnya dan mengembalikan koleksi atau kumpulan objek yang sesuai dengan aturan tersebut.
        //secara keseluruhan berarti kita mengambil 1 data terbaru dari model "Aturan" dengan 
        //mengurutkan berdasarkan kolom "kode_aturan". Data tersebut akan disimpan dalam 
        //variabel "$terbaru" untuk digunakan dalam bagian selanjutnya dari kode.
        if ($terbaru->first()) { //pernyataan kondisional yang memeriksa apakah ada data yang 
            //ditemukan dalam objek "$terbaru". Pernyataan ini mengasumsikan bahwa "$terbaru" 
            //adalah sebuah objek koleksi atau hasil query yang mengandung data aturan.
            $terbaru = $terbaru->first();//pernyataan yang menugaskan data pertama dari objek 
            //"$terbaru" ke variabel "$terbaru". Dalam konteks ini, kita mengambil data pertama 
            //dari koleksi untuk mendapatkan aturan terbaru yang telah diambil sebelumnya.
            $terbaru = (int) str_replace(['r', 'R'], '', $terbaru->kode_aturan);
            //pernyataan yang menghapus karakter "r" atau "R" dari string "$terbaru->kode_aturan" 
            //dan mengonversinya menjadi tipe data integer. Ini diasumsikan bahwa "kode_aturan" 
            //adalah properti atau kolom pada objek "$terbaru" yang berisi kode aturan dalam 
            //bentuk string.
            $terbaru = 'R'.++$terbaru;//pernyataan yang menambahkan prefiks "R" ke 
            //nilai "$terbaru" yang telah diperbarui. Pernyataan ini menggunakan operator 
            //increment "++" untuk menambahkan 1 ke nilai "$terbaru" dan kemudian menugaskan 
            //nilai tersebut kembali ke variabel "$terbaru" dengan prefiks "R" di depannya.
            //--> jadi langkah-langkah di atas berfungsi untuk memeriksa dan memodifikasi 
            //data terbaru dari objek "$terbaru". Jika ada data yang ditemukan, maka 
            //langkah-langkah tersebut akan dijalankan untuk mengubah kode aturan terbaru 
            //menjadi format yang diinginkan, yaitu dengan menambahkan prefiks "R" dan 
            //menaikkan nilai sebelumnya.
        } else {
            $terbaru = 'R1';
        }//blok "else" ini memberikan tindakan yang akan diambil ketika tidak ada data yang 
        //ditemukan dalam objek "$terbaru", yaitu menginisialisasi "$terbaru" dengan string 'R1'.
        return view('admin.pages.aturan.index', [//berfungsi untuk memuat tampilan dengan nama 
        //'admin.pages.aturan.index'dan mengirimkan data ke tampilan tersebut melalui array yang diberikan.
            'terbaru'=>$terbaru,//Data yang dikirimkan adalah variabel "$terbaru" yang mungkin berisi informasi tentang data aturan terbaru
            'aturan'=>Aturan::all(), //hasil dari pemanggilan metode "all()" pada model "Aturan"
            'gejalas' => Gejala::all(),//pemanggilan metode "all()" pada model "Gejala"
            'kerusakans' => Kerusakan::all(),//hasil dari pemanggilan metode "all()" pada model "Kerusakan"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//digunakan untuk menampilkan formulir pembuatan entitas baru kepada pengguna
    {
        $terbaru = Aturan::latest('kode_aturan')->limit(1)->get();//kita mengambil 1 data terbaru 
        //dari model "Aturan" dengan mengurutkan berdasarkan kolom "kode_aturan". 
        //Data tersebut akan disimpan dalam variabel "$terbaru" sebagai sebuah koleksi objek.
        //"::latest('kode_aturan')" adalah metode statis dalam model "Aturan" yang digunakan untuk 
        //mengurutkan data berdasarkan kolom "kode_aturan" secara menurun (descending).
        //"->limit(1)" adalah metode lanjutan yang digunakan untuk membatasi jumlah data yang akan 
        //diambil dari hasil pengurutan sebelumnya.
        //"->get()" adalah metode terakhir yang mengambil hasil data dari kueri yang dibentuk 
        //sebelumnya dan mengembalikan koleksi atau kumpulan objek yang sesuai dengan aturan tersebut.
        if ($terbaru->first()) {//langkah-langkah ini berfungsi untuk memeriksa dan memodifikasi data terbaru dari objek "$terbaru"
            $terbaru = $terbaru->first();//menugaskan data pertama dari objek "$terbaru" 
            //ke variabel "$terbaru". kita mengambil data pertama dari koleksi untuk mendapatkan aturan terbaru yang telah diambil sebelumnya.
            $terbaru = (int) str_replace(['r', 'R'], '', $terbaru->kode_aturan);
            //pernyataan yang menghapus karakter "r" atau "R" dari string "$terbaru->kode_aturan" dan mengonversinya menjadi tipe data integer
            $terbaru = 'R'.++$terbaru;//Pernyataan ini menggunakan operator increment "++" untuk menambahkan 1 ke nilai "$terbaru"
        } else {
            $terbaru = 'R1';//tindakan yang akan diambil ketika tidak ada data yang ditemukan 
            //dalam objek "$terbaru" atau jika objek tersebut kosong, yaitu menginisialisasi 
            //"$terbaru" dengan string 'R1'.
        }
        return view('admin.pages.aturan.create', [//Dengan menggunakan pernyataan "return view", 
        //tampilan 'admin.pages.aturan.create' akan dikembalikan dengan data yang diberikan. 
        //Tampilan ini dapat menggunakan data tersebut untuk ditampilkan kepada pengguna sesuai 
        //dengan kebutuhan.
            'terbaru'=>$terbaru,
            'aturan'=>Aturan::all(),
            'gejalas' => Gejala::all(),
            'kerusakans' => Kerusakan::all(),
            'solusis' => RekomendasiSolusi::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    //Fungsi "store()" ini sering digunakan dalam implementasi CRUD (Create, Read, Update, Delete) 
    //untuk menyimpan data yang dikirim oleh pengguna melalui formulir ke dalam database atau 
    //melakukan tindakan penyimpanan data lainnya.
    {
        $request->validate([//metode yang digunakan untuk memvalidasi data yang diterima dari objek Request
            'kode_aturan' => 'required',//'required'" menentukan bahwa field 'kode_aturan' harus ada (tidak boleh kosong) dalam data yang dikirim.
            'kode_gejala' => 'required',
            'kode_kerusakan' => 'required',
        ]);
 
        Aturan::create([//digunakan untuk membuat dan menyimpan data baru ke dalam tabel atau koleksi yang terhubung dengan model "Aturan"
            'kode_aturan' => $request->kode_aturan,//menentukan bahwa field 'kode_aturan' pada 
            //model "Aturan" akan diisi dengan nilai dari property 'kode_aturan' yang ada dalam 
            //objek Request
            'kode_gejala' => $request->kode_gejala,
            'kode_kerusakan' => $request->kode_kerusakan,
        //Dengan menggunakan pernyataan "Aturan::create", data baru akan dibuat berdasarkan 
        //nilai-nilai yang diterima dari objek Request dan disimpan ke dalam tabel "Aturan"
        ]);

        return redirect()->route('aturan.index');
        //"redirect()"digunakan untuk melakukan pengalihan (redirect) ke halaman lain.
        //"->route('aturan.index')" adalah metode chaining atau pemanggilan berantai yang 
        //mengarahkan pengguna ke rute (route) dengan nama 'aturan.index'.
        //"return" digunakan untuk mengembalikan respons dalam bentuk pengalihan (redirect) ke halaman lain.
        //Jadi, setelah berhasil menyimpan data menggunakan fungsi "store()", pernyataan "return 
        //redirect()->route('aturan.index');" akan mengarahkan pengguna kembali ke halaman indeks 
        //atau daftar aturan. Pengguna akan melihat daftar aturan yang terbaru setelah proses 
        //penambahan data berhasil dilakukan.
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)//untuk menampilkan data spesifik berdasarkan ID yang diberikan
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//untuk memungkinkan pengguna mengedit data yang ada.
    {
        $aturan=Aturan::find($id);//"$id" adalah parameter yang mewakili ID dari data yang ingin diedit. 
        return view('admin.pages.aturan.edit', [
            'aturan' => $aturan,
            'gejalas' => Gejala::all(),
            'kerusakans' => Kerusakan::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    //untuk memproses permintaan update yang dikirimkan oleh pengguna untuk mengubah data yang ada.
    {
        $request->validate([
        //"$request" mengacu pada objek Request yang digunakan untuk mengelola permintaan HTTP yang diterima oleh aplikasi.
        //->validate([ adalah metode yang dipanggil pada objek Request untuk menerapkan validasi pada data yang dikirimkan dalam permintaan.
            'kode_aturan' => 'required',
            'kode_gejala' => 'required',
            'kode_kerusakan' => 'required',
        ]);

        $aturan = Aturan::find($id);
        //"::find($id)" adalah metode statis dalam model "Aturan" yang digunakan untuk mencari 
        //dan mengambil data dengan ID yang sesuai dari basis data
        $aturan->update([// untuk memperbarui data aturan yang sudah ada dalam basis data 
            //berdasarkan nilai-nilai yang diterima melalui objek Request.
            'kode_aturan' => $request->kode_aturan,//'kode_aturan' diupdate dengan nilai dari 
            //"$request->kode_aturan" (nilai yang diterima melalui objek Request).
            'kode_gejala' => $request->kode_gejala,
            'kode_kerusakan' => $request->kode_kerusakan,
        ]);

        return redirect()->route('aturan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//untuk menghapus data aturan yang ada berdasarkan ID yang diberikan
    {//"$id" adalah parameter yang mewakili ID dari data aturan yang ingin dihapus
        $aturan = Aturan::find($id);//digunakan untuk mencari data aturan berdasarkan ID yang diberikan
        $aturan->delete();//pernyataan yang digunakan untuk menghapus data aturan yang telah 
        //ditemukan sebelumnya, menggunakan metode "delete()"

        return redirect()->route('aturan.index');//digunakan untuk mengarahkan pengguna kembali 
        //ke halaman yang ditentukan setelah proses penghapusan berhasil
    }

    public function getAturan(Request $request)
    {//untuk mengambil data aturan berdasarkan permintaan yang diterima.
        if (!$request->ajax()) {
            return '';
        //Jika permintaan bukan permintaan AJAX, maka blok kode di dalam blok "if" akan dieksekusi
        //return ''; digunakan untuk mengembalikan sebuah string kosong
        //AJAX (Asynchronous JavaScript and XML) adalah sebuah teknik dalam pengembangan web yang 
        //memungkinkan pengiriman dan penerimaan data dari server ke halaman web tanpa harus me-refresh seluruh halaman
        }

        $data =  Aturan::orderBy('kode_aturan', 'asc')->get();
        //"Aturan::orderBy('kode_aturan', 'asc')" adalah metode yang digunakan untuk mengambil data 
        //aturan dari tabel "Aturan" dalam basis data. Metode "orderBy('kode_aturan', 'asc')" 
        //digunakan untuk mengurutkan data berdasarkan kolom "kode_aturan" secara menaik (ascending).
        //->get() adalah metode yang digunakan untuk menjalankan kueri dan mengambil semua baris data yang sesuai dari basis data
        //$data adalah variabel yang digunakan untuk menyimpan hasil pengambilan data aturan dari basis data. berisi koleksi objek model yang mewakili data aturan yang telah diurutkan.
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_gejala', function ($row) {
                $hasil = [];//deklarasi variabel "$hasil" sebagai array kosong.Variabel ini akan digunakan untuk menyimpan hasil pengolahan data pada setiap iterasi dalam perulangan.
                //metode yang digunakan untuk menambahkan kolom 'nama_gejala' pada tabel yang dikonfigurasi menggunakan DataTables.
                foreach ($row->kode_gejala as $kode) {//perulangan foreach yang digunakan untuk mengiterasi setiap elemen dalam properti berisi kode gejala
                    $nama = Gejala::select('nama_gejala')->where('kode_gejala', $kode)->get();
                    //query untuk mengambil data 'nama_gejala' dari tabel Gejala berdasarkan kondisi 'kode_gejala' yang sesuai dengan nilai kode yang sedang diiterasi.
                    $nama = $nama->first();//digunakan untuk mendapatkan objek pertama dari hasil query yang mengandung data 'nama_gejala'.
                    $hasil[] = "$kode - $nama->nama_gejala";//pernyataan yang menambahkan string dalam format "kode - nama_gejala" ke dalam array "$hasil" pada setiap iterasi perulangan.
                }

                return join("\n", $hasil);//menggabungkan semua elemen dalam array "$hasil" dengan menggunakan karakter baris baru ("\n") sebagai pemisah.
            })
            ->addColumn('nama_kerusakan', function ($row) {
                $kode = $row->kode_kerusakan;
                $nama = Kerusakan::select('nama_kerusakan')->where('kode_kerusakan', $kode)->get();
                $nama = $nama->first();

                return "$kode - $nama->nama_kerusakan";
            })
            ->addColumn('action', function ($row) {//digunakan untuk menambahkan kolom 'action' pada tabel yang dikonfigurasi menggunakan DataTables. 
            //Fungsi anonim atau closure dimulai di sini untuk menentukan logika penampilan nilai kolom 'action' berdasarkan data yang ada dalam setiap baris.
                $editBtn = '<a href="' . route('aturan.edit', $row) . '" class="btn btn-md btn-info mr-2 mb-2 mb-lg-0"><i class="far fa-edit"></i> Edit</a>';
                //"$editBtn" adalah variabel yang digunakan untuk menyimpan string HTML yang merepresentasikan tombol Edit. 
                //Pada contoh yang diberikan, string tersebut memiliki atribut href yang menuju ke rute 'aturan.edit' 
                //dengan parameter $row sebagai id. Tombol Edit ditampilkan dalam elemen <a> dengan kelas CSS dan ikon Font Awesome yang sesuai.
                $deleteBtn = '<a href="' . route('aturan.destroy', $row) . '/delete" onclick="notificationBeforeDelete(event, this)" class="btn btn-md btn-danger btn-delete"><i class="fas fa-trash"></i> Hapus</a>';
                //"$deleteBtn" adalah variabel yang digunakan untuk menyimpan string HTML yang merepresentasikan tombol Hapus. 
                //Pada contoh yang diberikan, string tersebut memiliki atribut href yang menuju ke rute 'aturan.destroy' 
                //dengan parameter $row sebagai id, dan menggunakan fungsi JavaScript "notificationBeforeDelete(event, this)" untuk memberikan notifikasi sebelum menghapus data. 
                //Tombol Hapus ditampilkan dalam elemen <a> dengan kelas CSS dan ikon Font Awesome yang sesuai.
                return $editBtn . $deleteBtn;//menggabungkan string dari variabel $editBtn dan $deleteBtn, sehingga menghasilkan string HTML yang berisi kedua tombol Edit dan Hapus pada kolom 'action' 
            })
            ->rawColumns(['kode_aturan', 'action'])//untuk memberikan informasi kepada DataTables 
            //bahwa kolom 'kode_aturan' dan 'action' tidak perlu melalui proses penyaringan HTML 
            //yang biasanya dilakukan oleh DataTables. 
            ->make(true);//untuk menghasilkan respons JSON dari objek DataTables yang telah dikonfigurasi
            //Dengan menggunakan pernyataan ini, pengaturan dan konfigurasi DataTables telah selesai, 
            //dan objek DataTables akan menghasilkan respons JSON yang berisi data yang telah 
            //diproses dan siap ditampilkan dalam tampilan web.
    }
}
