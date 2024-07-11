<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Surat;
use Hash;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $suratt = Surat::all();
        $suratMasuk = Surat::where('id_kategori', 1)->orderby('created_at', 'desc')->get();
        $suratKeluar = Surat::where('id_kategori', 2)->orderby('created_at', 'desc')->get();
        $suratselesai = Surat::where('status_disposisi', [3])->orderby('created_at', 'desc')->get();
        $surattSelesai = Surat::orderby('created_at', 'desc')->whereNotIn('status_disposisi', [3])->get();
        $tahunn = $request->post('tahun');
        if ($tahunn) {
            $chartSuratMasukCount = Surat::whereYear('created_at', $tahunn)
                ->select(
                    DB::raw('MONTHNAME(created_at) as bulan'),
                    DB::raw('SUM(CASE WHEN id_kategori = 1 THEN 1 ELSE 0 END) as jumlahMasuk'),
                    DB::raw('SUM(CASE WHEN id_kategori = 2 THEN 1 ELSE 0 END) as jumlahKeluar')
                )
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->orderBy('created_at', 'asc')
                ->get();
        } elseif (empty($tahunn)) {
            $tahunSekarang = Carbon::now()->year;
            // Ambil data surat masuk berdasarkan kategori
            $chartSuratMasukCount = Surat::whereYear('created_at', $tahunSekarang)
                ->select(
                    DB::raw('MONTHNAME(created_at) as bulan'),
                    DB::raw('SUM(CASE WHEN id_kategori = 1 THEN 1 ELSE 0 END) as jumlahMasuk'),
                    DB::raw('SUM(CASE WHEN id_kategori = 2 THEN 1 ELSE 0 END) as jumlahKeluar')
                )
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->orderBy('created_at', 'asc')
                ->get();
        }
        return view('home', compact('suratt', 'chartSuratMasukCount', 'suratMasuk', 'suratKeluar', 'suratselesai', 'surattSelesai'));
    }

    public function dataSurat(Request $request)
    {
        $tahunn = $request->post('tahun');
        if ($tahunn) {
            $chartSuratMasukCount = Surat::whereYear('created_at', $tahunn)
                ->select(
                    DB::raw('MONTHNAME(created_at) as bulan'),
                    DB::raw('SUM(CASE WHEN id_kategori = 1 THEN 1 ELSE 0 END) as jumlahMasuk'),
                    DB::raw('SUM(CASE WHEN id_kategori = 2 THEN 1 ELSE 0 END) as jumlahKeluar')
                )
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->orderBy('created_at', 'asc')
                ->get();
        } elseif (empty($tahunn)) {
            $tahunSekarang = Carbon::now()->year;
            // Ambil data surat masuk berdasarkan kategori
            $chartSuratMasukCount = Surat::whereYear('created_at', $tahunSekarang)
                ->select(
                    DB::raw('MONTHNAME(created_at) as bulan'),
                    DB::raw('SUM(CASE WHEN id_kategori = 1 THEN 1 ELSE 0 END) as jumlahMasuk'),
                    DB::raw('SUM(CASE WHEN id_kategori = 2 THEN 1 ELSE 0 END) as jumlahKeluar')
                )
                ->groupBy(DB::raw('MONTHNAME(created_at)'))
                ->orderBy('created_at', 'asc')
                ->get();
        }
        return view('dataSurat', compact('chartSuratMasukCount'));
    }

    //---------------------------------------------------------------------------------------//
    //---------------------------------------------------------------------------------------//
    public function user()
    {
        $role = Auth::user()->role;
        $user = User::whereNotIn('role', [1])->orderBy('id_divisi', 'asc')->orderBy('id_jabatan', 'asc')->get();
        $divisi = Divisi::all();
        $jabatan = Jabatan::all();
        return view('user', compact('user', 'jabatan', 'divisi'));
    }

    public function simpan_user(Request $request)
    {
        $messages = [
            'required' => ':attribute Form Wajib Di Isi!',
            'min' => ':attribute Minimal :min karakter!',
            'confirmed' => ':belum sama',
        ];

        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $password = $request->post('password');
        $hashedPassword = Hash::make($password);
        $simpan = DB::table('users')->insert([
            'nip' => $request->post('nip'),
            'name' => $request->post('name'),
            'username' => $request->post('username'),
            'id_jabatan' => $request->post('jabatan'),
            'id_divisi' => $request->post('divisi'),
            'email' => $request->post('email'),
            'no_telp' => $request->post('no_telp'),
            'password' =>  $hashedPassword,
            'role' => $request->post('role'),
        ]);
        if ($simpan) {
            Session::flash('sukses', 'Data berhasil disimpan.');
        } else {
            Session::flash('sukses', 'Data gagal disimpan.');
        }
        return redirect('user');
    }

    public function edit_user(Request $request)
    {
        $data = User::findOrFail($request->get('id'));
        echo json_encode($data);
    }

    public function update_user(Request $request)

    {
        $data = array(
            'nip' => $request->post('nip'),
            'name' => $request->post('name'),
            'id_jabatan' => $request->post('jabatan'),
            'id_divisi' => $request->post('divisi'),
            'email' => $request->post('email'),
            'no_telp' => $request->post('no_telp'),
            'role' => $request->post('role'),
        );
        $simpan = DB::table('users')->where('id', '=', $request->post('id'))->update($data);
        if ($simpan) {
            Session::flash('sukses', 'Data berhasil diupdate.');
        } else {
            Session::flash('sukses', 'Data gagal diupdate.');
        }
        return redirect('user')->with("sukses", "Data berhasil diubah");
    }

    public function user_hapus($id)
    {
        // hapus kategori berdasarkan id yang dipilih
        $user = User::find($id);
        $user->delete();

        return redirect('user')->with("sukses", "Data berhasil dihapus");
    }

    //---------------------------------------------------------------------------------------//
    //---------------------------------------------------------------------------------------//

    //---------------------------------------------------------------------------------------//
    //---------------------------------------------------------------------------------------//

    public function gpass()
    {
        return view('ganti_password');
    }

    public function simpan_gpass(Request $request)
    {
        $messages = [
            'required' => ':attribute Form Wajib Di Isi!',
            'min' => ':attribute Minimal :min karakter!',
            'confirmed' => ':belum sama',
        ];

        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $password = $request->post('password');
        $hashedPassword = Hash::make($password);
        $simpan = DB::table('users')->insert([
            'nip' => $request->post('nip'),
            'name' => $request->post('name'),
            'id_jabatan' => $request->post('jabatan'),
            'id_divisi' => $request->post('divisi'),
            'email' => $request->post('email'),
            'no_telp' => $request->post('no_telp'),
            'password' =>  $hashedPassword,
            'role' => $request->post('role'),
        ]);
        if ($simpan) {
            Session::flash('sukses', 'Data berhasil disimpan.');
        } else {
            Session::flash('sukses', 'Data gagal disimpan.');
        }
        return redirect('user');
    }


    public function update_gpass(Request $request)

    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $password = $request->post('password');
        $hashedPassword = Hash::make($password);
        $data = array(
            'password' => $hashedPassword,
        );
        $simpan = DB::table('users')->where('id', '=', Auth::user()->id)->update($data);
        if ($simpan) {
            Session::flash('sukses', 'Password berhasil diubah.');
        } else {
            Session::flash('sukses', 'Data gagal diupdate.');
        }
        return redirect('/home')->with("sukses", "Password berhasil diubah.");
    }

    //---------------------------------------------------------------------------------------//
    //---------------------------------------------------------------------------------------//

    //KATEGORI----------------------------------------------------------------//

    public function kategori()
    {
        $kategori = Kategori::all();
        return view('kategori', ['kategori' => $kategori]);
    }

    public function simpankategori(Request $request)
    {
        $simpan = DB::table('kategori')->insert([
            'nama' => $request->post('nama'),
            'keterangan' => $request->post('keterangan'),
        ]);
        if ($simpan) {
            Session::flash('sukses', 'Data berhasil disimpan.');
        } else {
            Session::flash('sukses', 'Data gagal disimpan.');
        }
        return redirect('kategori');
    }

    public function editkategori(Request $request)
    {
        $data = Kategori::findOrFail($request->get('id'));
        echo json_encode($data);
    }

    public function updatekategori(Request $request)

    {
        $data = array(
            'nama' => $request->post('nama'),
            'keterangan' => $request->post('keterangan'),
        );
        $simpan = DB::table('kategori')->where('id', '=', $request->post('id'))->update($data);
        if ($simpan) {
            Session::flash('status', 'Data berhasil diupdate.');
        } else {
            Session::flash('status', 'Data gagal diupdate.');
        }
        return redirect('kategori')->with("sukses", "berhasil diubah");
    }

    public function hapuskategori($id)
    {
        // hapus kategori berdasarkan id yang dipilih
        $kategori = Kategori::find($id);
        $kategori->delete();

        return redirect('kategori')->with("sukses", " berhasil dihapus");
    }

    //END KATEGORI----------------------------------------------------------------//
}
