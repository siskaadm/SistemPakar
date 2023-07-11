<?php

namespace App\Http\Controllers\Admin;
//namespace digunakan untuk mengelompokkan kelas-kelas kontroler (controllers) 
//yang terkait dengan bagian administrasi (admin) dalam aplikasi web. 
//Namespace ini mengindikasikan bahwa kelas-kelas kontroler yang ditempatkan di dalamnya 
//berada dalam direktori "Admin" di dalam direktori "Controllers" di dalam direktori "Http" 
//di dalam namespace "App".
use App\Models\Kerusakan;
//use digunakan untuk mengimpor (import)elemen-elemen yang ada dalam namespace atau kelas 
//tertentu agar dapat digunakan dengan lebih mudah dan jelas dalam kode.
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\KategoriSolusi;
use Yajra\DataTables\DataTables;

use function Symfony\Component\String\b;
//Fungsi b() digunakan untuk membuat instansi objek String dari sebuah string, sehingga 
//memungkinkan manipulasi lebih lanjut seperti pemotongan, penggantian, pemformatan, 
//dan operasi lainnya pada string tersebut.
class KerusakanController extends Controller
//kelas kontroler digunakan dalam pola arsitektur Model-View-Controller (MVC) untuk 
//memisahkan logika bisnis dari presentasi (tampilan) dan interaksi dengan data.
//"extends Controller" menunjukkan bahwa kelas "KerusakanController" merupakan turunan (inheritance) 
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
        $terbaru = Kerusakan::latest('kode_kerusakan')->limit(1)->get();
        if ($terbaru->first()) {
            $terbaru = $terbaru->first();
            $terbaru = (int) str_replace(['k', 'K'], '', $terbaru->kode_kerusakan);
            $terbaru = 'K'.++$terbaru;
        } else {
            $terbaru = 'K01';
        }
        return view('admin.pages.kerusakan.index', [ 'terbaru'=>$terbaru,
        //untuk menghasilkan tampilan (view) dalam aplikasi web 
        //digunakan untuk mengarahkan pada file view yang terletak di direktori 'resources/views/admin/pages/kerusakan/index.blade.php'
        //['kerusakan'=>Kerusakan::all()] untuk mengirimkan data 'kerusakan' yang diperoleh dari memanggil metode all() pada model Kerusakan.
            'kerusakan'=>Kerusakan::all(),
            'kategoris' => KategoriSolusi::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()//digunakan untuk menampilkan formulir pembuatan entitas baru kepada pengguna
    {
        return view('admin.pages.kerusakan.create');//Dengan menggunakan pernyataan "return view", 
        //tampilan 'admin.pages.kerusakan.create' akan dikembalikan dengan data yang diberikan. 
        //Tampilan ini dapat menggunakan data tersebut untuk ditampilkan kepada pengguna sesuai 
        //dengan kebutuhan.
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
            'kode_kerusakan' => 'required',//'required'" menentukan bahwa field 'kode_kerusakan' harus ada (tidak boleh kosong) dalam data yang dikirim.
            'nama_kerusakan' => 'required',
            "kode_kategori" => "required",
        ]);
        
        kerusakan::create([//digunakan untuk membuat dan menyimpan data baru ke dalam tabel atau koleksi yang terhubung dengan model "kerusakan"
            'kode_kerusakan' => $request->kode_kerusakan,//menentukan bahwa field 'kode_kerusakan' pada 
            //model "Kerusakan" akan diisi dengan nilai dari property 'kode_kerusakan' yang ada dalam 
            //objek Request
            'nama_kerusakan' => $request->nama_kerusakan,
            'kode_kategori' => $request->kode_kategori,
        //Dengan menggunakan pernyataan "Kerusakan::create", data baru akan dibuat berdasarkan 
        //nilai-nilai yang diterima dari objek Request dan disimpan ke dalam tabel "kerusakan"
        ]);
        return redirect()->route('kerusakan.index');
        //"redirect()"digunakan untuk melakukan pengalihan (redirect) ke halaman lain.
        //"->route('kerusakan.index')" adalah metode chaining atau pemanggilan berantai yang 
        //mengarahkan pengguna ke rute (route) dengan nama 'kerusakan.index'.
        //"return" digunakan untuk mengembalikan respons dalam bentuk pengalihan (redirect) ke halaman lain.
        //Jadi, setelah berhasil menyimpan data menggunakan fungsi "store()", pernyataan "return 
        //redirect()->route('kerusakan.index');" akan mengarahkan pengguna kembali ke halaman indeks 
        //atau daftar kerusakan. Pengguna akan melihat daftar kerusakan yang terbaru setelah proses 
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
        $kerusakan=Kerusakan::find($id);//"$id" adalah parameter yang mewakili ID dari data yang ingin diedit. 
        return view('admin.pages.kerusakan.edit', [
            'kerusakan'=>$kerusakan,
            'kategoris' => KategoriSolusi::all(),
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
            "kode_kerusakan" => "required",
            "nama_kerusakan" => "required",
            "kode_kategori" => "required",
        ]);
        $kerusakan = Kerusakan::find($id);
        //"::find($id)" adalah metode statis dalam model "Kerusakan" yang digunakan untuk mencari 
        //dan mengambil data dengan ID yang sesuai dari basis data
        if ($request->kode_kerusakan) {
        //->kode_kerusakan adalah cara untuk mengakses nilai dari bidang "kode_kerusakan" dalam 
        //objek Request. Jika bidang "kode_kerusakan" tidak ada dalam permintaan atau memiliki 
        //nilai kosong, maka kondisi tersebut akan bernilai false. Namun, jika bidang 
        //"kode_kerusakan" ada dan memiliki nilai yang tidak kosong, maka kondisi tersebut 
        //akan bernilai true.    
        }
        $kerusakan->update([// untuk memperbarui data kerusakan yang sudah ada dalam basis data 
            //berdasarkan nilai-nilai yang diterima melalui objek Request.
            'kode_kerusakan' => $request->kode_kerusakan,//'kode_kerusakan' diupdate dengan nilai dari 
            //"$request->kode_kerusakan" (nilai yang diterima melalui objek Request).
            'nama_kerusakan' => $request->nama_kerusakan,
            'kode_kategori' => $request->kode_kategori,
        ]);

        return redirect()->route('kerusakan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//untuk menghapus data kerusakan yang ada berdasarkan ID yang diberikan
    {//"$id" adalah parameter yang mewakili ID dari data kerusakan yang ingin dihapus
        $kerusakan = Kerusakan::find($id);//digunakan untuk mencari data kerusakan berdasarkan ID yang diberikan
        $kerusakan->delete();//pernyataan yang digunakan untuk menghapus data kerusakan yang telah 
        //ditemukan sebelumnya, menggunakan metode "delete()"

        return redirect()->route('kerusakan.index');//digunakan untuk mengarahkan pengguna kembali 
        //ke halaman yang ditentukan setelah proses penghapusan berhasil
    }
    public function uplod($id)//adalah deklarasi sebuah metode dengan nama "upload" yang menerima parameter $id. 
    //Metode ini kemungkinan bertujuan untuk mengunggah file terkait kerusakan dengan menggunakan ID kerusakan yang diberikan sebagai parameter.
    {
        $kerusakan = Kerusakan::find($id);//"$kerusakan = Kerusakan::find($id);" merupakan pemanggilan metode statis "find()" pada model Kerusakan
        $kerusakan->uplod();//pemanggilan metode "upload()" pada objek $kerusakan

        return redirect()->route('kerusakan.index');//pernyataan yang mengarahkan pengguna ke rute bernama 'kerusakan.index' setelah proses unggah file berhasil dilakukan. 
    }

    public function getKerusakan(Request $request)
    {//untuk mengambil data kerusakan berdasarkan permintaan yang diterima.
        if (!$request->ajax()) {
            return '';
        //Jika permintaan bukan permintaan AJAX, maka blok kode di dalam blok "if" akan dieksekusi
        //return ''; digunakan untuk mengembalikan sebuah string kosong
        //AJAX (Asynchronous JavaScript and XML) adalah sebuah teknik dalam pengembangan web yang 
        //memungkinkan pengiriman dan penerimaan data dari server ke halaman web tanpa harus me-refresh seluruh halaman
        }

        $data = Kerusakan::OrderBy('kode_kerusakan', 'ASC')->get();
        //"Kerusakan::orderBy('kode_kerusakan', 'asc')" adalah metode yang digunakan untuk mengambil data 
        //kerusakan dari tabel "Kerusakan" dalam basis data. Metode "orderBy('kode_kerusakan', 'asc')" 
        //digunakan untuk mengurutkan data berdasarkan kolom "kode_kerusakan" secara menaik (ascending).
        //->get() adalah metode yang digunakan untuk menjalankan kueri dan mengambil semua baris data yang sesuai dari basis data
        //$data adalah variabel yang digunakan untuk menyimpan hasil pengambilan data kerusakan dari basis data. berisi koleksi objek model yang mewakili data kerusakan yang telah diurutkan.
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {//digunakan untuk menambahkan kolom 'action' pada tabel yang dikonfigurasi menggunakan DataTables. 
            //Fungsi anonim atau closure dimulai di sini untuk menentukan logika penampilan nilai kolom 'action' berdasarkan data yang ada dalam setiap baris.
                $editBtn = '<a href="' . route('kerusakan.edit', $row) . '" class="btn btn-md btn-info mr-2 mb-2 mb-lg-0"><i class="far fa-edit"></i> Edit</a>';
                //"$editBtn" adalah variabel yang digunakan untuk menyimpan string HTML yang merepresentasikan tombol Edit. 
                //Pada contoh yang diberikan, string tersebut memiliki atribut href yang menuju ke rute 'kerusakan.edit' 
                //dengan parameter $row sebagai id. Tombol Edit ditampilkan dalam elemen <a> dengan kelas CSS dan ikon Font Awesome yang sesuai.
                $deleteBtn = '<a href="' . route('kerusakan.destroy', $row) . '/delete" onclick="notificationBeforeDelete(event, this)" class="btn btn-md btn-danger btn-delete"><i class="fas fa-trash"></i> Hapus</a>';
                //"$deleteBtn" adalah variabel yang digunakan untuk menyimpan string HTML yang merepresentasikan tombol Hapus. 
                //Pada contoh yang diberikan, string tersebut memiliki atribut href yang menuju ke rute 'kerusakan.destroy' 
                //dengan parameter $row sebagai id, dan menggunakan fungsi JavaScript "notificationBeforeDelete(event, this)" untuk memberikan notifikasi sebelum menghapus data. 
                //Tombol Hapus ditampilkan dalam elemen <a> dengan kelas CSS dan ikon Font Awesome yang sesuai.
                return $editBtn . $deleteBtn;//menggabungkan string dari variabel $editBtn dan $deleteBtn, sehingga menghasilkan string HTML yang berisi kedua tombol Edit dan Hapus pada kolom 'action' 
            })
            ->rawColumns(['kode_kerusakan', 'action'])//untuk memberikan informasi kepada DataTables 
            //bahwa kolom 'kode_kerusakan' dan 'action' tidak perlu melalui proses penyaringan HTML 
            //yang biasanya dilakukan oleh DataTables.
            ->make(true);//untuk menghasilkan respons JSON dari objek DataTables yang telah dikonfigurasi
            //Dengan menggunakan pernyataan ini, pengaturan dan konfigurasi DataTables telah selesai, 
            //dan objek DataTables akan menghasilkan respons JSON yang berisi data yang telah 
            //diproses dan siap ditampilkan dalam tampilan web.
    }
}
