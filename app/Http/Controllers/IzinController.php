<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Izin;
use Carbon\Carbon;

class IzinController extends Controller
{
    // Menampilkan halaman pengajuan izin
    public function create()
    {
        $alasan_izin = ['Sakit', 'Izin'];
        $izin_hari_ini = Izin::whereDate('created_at', Carbon::today())->get();

        return view('create-izin', compact('alasan_izin', 'izin_hari_ini'));
    }

    // Menyimpan izin ke dalam database
    public function store(Request $request)
    {
        $request->validate([
            'alasan' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required'
        ]);

        $imageName = null;
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $imageName);
        }

        // Menyimpan data izin dengan pengguna yang sedang login
        Izin::create([
            'name' => Auth::user()->name,
            'alasan' => $request->alasan,
            'gambar' => $imageName,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('izin.index')->with('success', 'Izin berhasil diajukan.');
    }

    // Menampilkan daftar izin
    public function index()
    {
        // Menampilkan izin berdasarkan pengguna yang sedang login
        $izin_pengguna = Izin::where('name', Auth::user()->name)->get();

        // Menampilkan izin/sakit yang diajukan hari ini
        $izin_hari_ini = Izin::whereDate('created_at', Carbon::today())->get();

        return view('izin', compact('izin_pengguna', 'izin_hari_ini'));
    }
}
