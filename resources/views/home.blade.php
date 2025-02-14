@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Rekap Presensi User</div>
                <div class="card-body">
                    <!-- Form untuk filter bulan -->
                    <form method="GET" action="{{ route('home') }}">
                        <div class="form-group row">
                            <label for="month" class="col-md-2 col-form-label text-md-right">Pilih Bulan:</label>
                            <div class="col-md-3">
                                <select id="month" name="month" class="form-control">
                                    @foreach($months as $key => $month)
                                        <option value="{{ $key }}" {{ $selectedMonth == $key ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="year" class="col-md-1 col-form-label text-md-right">Tahun:</label>
                            <div class="col-md-2">
                                <input type="number" id="year" name="year" class="form-control" value="{{ $selectedYear }}" min="2024" max="{{ date('Y') }}">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel Rekap Presensi -->
                    <table id="rekapTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Masuk</th>
                                <th>Pulang</th>
                                <th>Lokasi (Latitude, Longitude)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presensis as $item)
                            <tr>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->masuk }}</td>
                                <td>{{ $item->pulang ?? '-' }}</td>
                                <td>{{ $item->latitude }}, {{ $item->longitude }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Presensi Hari Ini -->
            <div class="card mt-5">
                <div class="card-header">Riwayat Presensi Hari Ini</div>
                <div class="card-body">
                    <h3>Total Karyawan Absen Hari Ini: {{ $presensisHariIni->count() }}</h3>
                    <table id="riwayatTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($presensisHariIni as $presensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $presensi->user->name }}</td>
                                <td>{{ $presensi->tanggal }}</td>
                                <td>{{ $presensi->masuk }}</td>
                                <td>{{ $presensi->pulang ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data presensi hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk mengaktifkan DataTables -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#rekapTable').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/id.json'
            }
        });

        $('#riwayatTable').DataTable({
            responsive: true
        });
    });
</script>
@endsection
