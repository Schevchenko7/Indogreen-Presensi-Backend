<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

date_default_timezone_set("Asia/Jakarta");

class PresensiController extends Controller
{
    // Mengambil presensi pengguna yang sedang login
    public function getPresensis()
    {
        $presensis = Presensi::where('name', Auth::user()->name)->get();

        foreach ($presensis as $item) {
            $item->is_hari_ini = ($item->tanggal == date('Y-m-d'));

            $tanggal = Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, j F Y');
            $masuk = $item->masuk ? Carbon::parse($item->masuk)->locale('id')->format('H:i') : "-";
            $pulang = $item->pulang ? Carbon::parse($item->pulang)->locale('id')->format('H:i') : "-";

            // Tambahkan URL gambar jika ada
            $item->foto_url = $item->foto ? asset('storage/' . $item->foto) : null;

            $item->tanggal = $tanggal;
            $item->masuk = $masuk;
            $item->pulang = $pulang;
        }

        return response()->json([
            'success' => true,
            'message' => 'Sukses menampilkan data presensi',
            'data' => $presensis
        ]);
    }

    // Mengambil presensi semua karyawan yang absen hari ini
    public function getPresensisHariIni()
    {
        $presensisHariIni = Presensi::whereDate('tanggal', Carbon::today())->get();

        foreach ($presensisHariIni as $item) {
            $item->masuk = $item->masuk ? Carbon::parse($item->masuk)->locale('id')->format('H:i') : "-";
            $item->pulang = $item->pulang ? Carbon::parse($item->pulang)->locale('id')->format('H:i') : "-";

            // Tambahkan URL gambar jika ada
            $item->foto_url = $item->foto ? asset('storage/' . $item->foto) : null;
        }

        return response()->json([
            'success' => true,
            'message' => 'Sukses menampilkan data presensi hari ini',
            'data' => $presensisHariIni
        ]);
    }

    // Menyimpan presensi masuk dan pulang dengan fitur upload foto
    public function savePresensi(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Foto bersifat opsional
        ]);

        $presensi = Presensi::whereDate('tanggal', date('Y-m-d'))
            ->where('name', Auth::user()->name)
            ->first();

        // Simpan foto jika ada
        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('presensi_foto', 'public');
        }

        // Jika belum ada presensi hari ini, buat presensi masuk
        if (!$presensi) {
            $presensi = Presensi::create([
                'name' => Auth::user()->name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tanggal' => date('Y-m-d'),
                'masuk' => date('H:i:s'),
                'pulang' => null,
                'foto' => $path // Simpan path foto
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sukses absen masuk',
                'data' => $presensi
            ]);
        } 

        // Jika sudah ada presensi masuk tapi belum pulang
        if (!$presensi->pulang) {
            $presensi->update([
                'pulang' => date('H:i:s'),
                'foto' => $path ?? $presensi->foto // Simpan foto hanya jika ada
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sukses absen pulang',
                'data' => $presensi
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Anda sudah melakukan presensi pulang',
            'data' => null
        ]);
    }
}
