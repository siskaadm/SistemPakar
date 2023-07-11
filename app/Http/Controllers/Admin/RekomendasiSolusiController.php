<?php

namespace App\Http\Controllers\Admin;

use App\Models\RekomendasiSolusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\KategoriSolusi;
use Yajra\DataTables\DataTables;

use function Symfony\Component\String\b;

class RekomendasiSolusiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terbaru = RekomendasiSolusi::latest('kode_solusi')->limit(1)->get();
        if ($terbaru->first()) {
            $terbaru = $terbaru->first();
            $terbaru = (int) str_replace(['s', 'S'], '', $terbaru->kode_solusi);
            $terbaru = 'S'.++$terbaru;
        } else {
            $terbaru = 'S01';
        }
        return view('admin.pages.rekomendasisolusi.index', ['terbaru'=>$terbaru,
            'rekomendasisolusi'=>RekomendasiSolusi::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.rekomendasisolusi.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_rekomendasisolusi' => 'required',
            'deskripsi_rekomendasisolusi' => 'required',
        ]);

        RekomendasiSolusi::create([
            'kode_solusi' => $request->kode_rekomendasisolusi,
            'deskripsi_solusi' => $request->deskripsi_rekomendasisolusi,
        ]);
        return redirect()->route('rekomendasisolusi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rekomendasisolusi=RekomendasiSolusi::find($id);
        return view('admin.pages.rekomendasisolusi.edit', [
            'rekomendasisolusi'=>$rekomendasisolusi,
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
    {
        $request->validate([
            "kode_rekomendasisolusi" => "required",
            "deskripsi_rekomendasisolusi" => "required",
        ]);
        $rekomendasisolusi = RekomendasiSolusi::find($id);

        // $kode_rekomendasisolusi = !empty($nama_rekomendasisolusi->rekomendasisolusi) ? true : false;

        if ($request->kode_rekomendasisolusi) {
            
        }
        $rekomendasisolusi->update([
            'kode_solusi' => $request->kode_rekomendasisolusi,
            'deskripsi_solusi' => $request->deskripsi_rekomendasisolusi,
        ]);

        return redirect()->route('rekomendasisolusi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rekomendasisolusi = RekomendasiSolusi::find($id);
        $rekomendasisolusi->delete();

        return redirect()->route('rekomendasisolusi.index');
    }
    public function uplod($id)
    {
        $rekomendasisolusi = RekomendasiSolusi::find($id);
        $rekomendasisolusi->uplod();

        return redirect()->route('rekomendasisolusi.index');
    }

    public function getRekomendasiSolusi(Request $request)
    {
        if (!$request->ajax()) {
            return '';
        }

        $data = RekomendasiSolusi::OrderBy('kode_solusi', 'ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('rekomendasisolusi.edit', $row) . '" class="btn btn-md btn-info mr-2 mb-2 mb-lg-0"><i class="far fa-edit"></i> Edit</a>';
                $deleteBtn = '<a href="' . route('rekomendasisolusi.destroy', $row) . '/delete" onclick="notificationBeforeDelete(event, this)" class="btn btn-md btn-danger btn-delete"><i class="fas fa-trash"></i> Hapus</a>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['kode_rekomendasisolusi', 'action'])
            ->make(true);
    }
}
