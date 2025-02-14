<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        // Ambil semua data presensi untuk rekap presensi
        $presensis = Presensi::with('user')->get();

        // Ambil data presensi yang hanya terjadi hari ini
        $presensisHariIni = Presensi::with('user')
            ->whereDate('tanggal', Carbon::today())
            ->get();

        // Kirimkan kedua data tersebut ke view home.blade.php
        return view('home', compact('presensis', 'presensisHariIni'));
    }
}
