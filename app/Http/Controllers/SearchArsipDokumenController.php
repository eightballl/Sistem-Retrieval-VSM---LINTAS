<?php

namespace App\Http\Controllers;

use App\Models\ArsipDokumen;
use App\Models\Divisi;
use Illuminate\Http\Request;

class SearchArsipDokumenController extends Controller
{
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
        return view('arsipSearch', compact('arsipDoc', 'divisi'));
    }
}
