<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Izin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IzinController extends Controller
{
    // Menyimpan izin melalui API
    public function saveIzin(Request $request)
    {
        $request->validate([
            'alasan' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required'
        ]);

        // Cek apakah user sudah mengirim izin hari ini
        $today = Carbon::today();
        $existingIzin = Izin::where('name', Auth::user()->name)
                            ->whereDate('created_at', $today)
                            ->first();

        if ($existingIzin) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengajukan izin hari ini'
            ], 400); // Mengembalikan respons gagal jika izin sudah ada
        }

        // Handling image upload
        $imageName = null;
        if ($request->hasFile('gambar')) {
            // Save image to public/uploads
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $imageName);
        }

        // Menyimpan data izin dengan pengguna yang sedang login
        Izin::create([
            'name' => Auth::user()->name,
            'alasan' => $request->alasan,
            'gambar' => $imageName, // Save the image name to the database
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Izin berhasil disimpan',
            'data' => $imageName ? asset('uploads/' . $imageName) : null // Return image path
        ], 200);
    }

    // Mendapatkan izin pengguna yang sedang login
    public function getIzin()
    {
        $izin = Izin::where('name', Auth::user()->name)->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'alasan' => $item->alasan,
                'gambar' => $item->gambar ? asset('uploads/' . $item->gambar) : null,
                'deskripsi' => $item->deskripsi,
                'tanggal' => Carbon::parse($item->created_at)->format('d F Y'), // Format tanggal
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Sukses menampilkan data izin',
            'data' => $izin
        ]);
    }

    // Mendapatkan izin hari ini
    public function getIzinHariIni()
    {
        $today = Carbon::today();
        $izinHariIni = Izin::whereDate('created_at', $today)->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'alasan' => $item->alasan,
                'gambar' => $item->gambar ? asset('uploads/' . $item->gambar) : null,
                'deskripsi' => $item->deskripsi,
                'tanggal' => Carbon::parse($item->created_at)->format('d F Y'), // Format tanggal
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Sukses menampilkan izin hari ini',
            'data' => $izinHariIni
        ]);
    }
}
