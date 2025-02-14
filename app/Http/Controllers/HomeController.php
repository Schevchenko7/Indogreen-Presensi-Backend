<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Daftar bulan dalam bahasa Indonesia
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        // Mendapatkan bulan dan tahun yang dipilih, default ke bulan dan tahun saat ini
        $selectedMonth = $request->get('month', Carbon::now()->format('m'));
        $selectedYear = $request->get('year', Carbon::now()->format('Y'));

        // Ambil presensi berdasarkan bulan dan tahun yang dipilih
        $presensis = Presensi::whereYear('tanggal', $selectedYear)
                             ->whereMonth('tanggal', $selectedMonth)
                             ->get();

        // Format tanggal ke dalam bahasa Indonesia
        foreach ($presensis as $item) {
            $datetime = Carbon::parse($item->tanggal)->locale('id');
            $datetime->settings(['formatFunction' => 'translatedFormat']);
            $item->tanggal = $datetime->format('l, j F Y');
        }

        // Ambil presensi untuk hari ini
        $presensisHariIni = Presensi::whereDate('tanggal', Carbon::today())->get();

        return view('home', [
            'months' => $months,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'presensis' => $presensis,
            'presensisHariIni' => $presensisHariIni,
        ]);
    }
}
