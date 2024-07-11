<?php

namespace App\Http\Controllers;

use App\Models\ArsipDokumen;
use App\Models\Divisi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ArsipDokumenController extends Controller
{
    // View
    public function view(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $arsipDoc = ArsipDokumen::where('nomor_dokumen', 'like', "%$search%")
                ->orWhere('nama_dokumen', 'like', "%$search%")
                ->orWhere('jenis_dokumen', 'like', "%$search%")
                ->orWhere('kategori', 'like', "%$search%")
                ->orWhere('deskripsi', 'like', "%$search%")
                ->orWhere('keyword', 'like', "%$search%")
                ->orWhere('file', 'like', "%$search%")
                ->orWhere('id_divisi', 'like', "%$search%")
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $arsipDoc = ArsipDokumen::orderby('created_at', 'desc')->get();
        }
        $divisi = Divisi::all();
        return view('arsipDoc', compact('arsipDoc', 'divisi'));
    }

    // Save Doc
    public function saveDoc(Request $request)
    {
        $file = $request->file('file');
        $tujuan_upload = 'dokumenArsip';
        $nama_file = "arsip_" . $file->getClientOriginalName();

        // upload file
        $file->move($tujuan_upload, $nama_file);

        $simpan = new ArsipDokumen();
        $simpan->nomor_dokumen = $request->noDoc;
        $simpan->nama_dokumen = $request->namaDoc;
        $simpan->jenis_dokumen = 'pdf';
        $simpan->kategori = $request->kategori;
        $simpan->deskripsi = $request->descdDoc;
        $simpan->keyword = $request->keywordDocx;
        $simpan->file = $nama_file;
        $simpan->id_divisi = $request->divisi;
        $simpan->created_at = $request->created_at;
        $simpan->save();

        if ($simpan) {
            Session::flash('sukses', 'Data berhasil disimpan !');
        } else {
            Session::flash('sukses', 'Data gagal disimpan.');
        }
        return redirect('/arsipdokumen');

        return redirect('/arsipdokumen');
    }

    public function viewDoc(Request $request)
    {
        $viewDoc = ArsipDokumen::findOrFail($request->get('id'));
        echo json_encode($viewDoc);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $arsipDoc = ArsipDokumen::where('nomor_dokumen', 'like', "%$search%")
            ->orWhere('nama_dokumen', 'like', "%$search%")
            ->orWhere('jenis_dokumen', 'like', "%$search%")
            ->orWhere('kategori', 'like', "%$search%")
            ->orWhere('deskripsi', 'like', "%$search%")
            ->orWhere('keyword', 'like', "%$search%")
            ->orWhere('file', 'like', "%$search%")
            ->orWhere('id_divisi', 'like', "%$search%")
            ->orderBy('created_at', 'desc')
            ->get();
        $divisi = Divisi::all();
        return view('arsipDoc', compact('arsipDoc', 'divisi'));
    }

    public function dataDoc(Request $request)
    {
        $tahun = $request->input('tahun');

        // Jika tahun diberikan dalam permintaan
        if ($tahun) {
            $chartDocCount = ArsipDokumen::whereYear('created_at', $tahun)
                ->select(
                    DB::raw('MONTHNAME(created_at) as bulan'),
                    DB::raw('COUNT(*) as jumlah_dokumen')
                )
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            // Jika tahun tidak diberikan, ambil tahun sekarang
            $tahunSekarang = Carbon::now()->year;
            $chartDocCount = ArsipDokumen::whereYear('created_at', $tahunSekarang)
                ->select(
                    DB::raw('MONTHNAME(created_at) as bulan'),
                    DB::raw('COUNT(*) as jumlah_dokumen')
                )
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('dataDoc', compact('chartDocCount'));
    }
}
