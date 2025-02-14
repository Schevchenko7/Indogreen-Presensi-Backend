@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a href="{{ route('izin.create') }}" type="button" class="btn btn-info mb-2">+ Tambah Izin / Sakit</a>

            <div class="card mb-3">
                <div class="card-header">Daftar Izin / Sakit User</div>
                
                <div class="card-body">
                    <table id="izinTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alasan</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Tanggal</th> <!-- Tambahkan kolom tanggal -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($izin_pengguna as $izin)
                            <tr>
                                <td>{{ $izin->name }}</td>
                                <td>{{ $izin->alasan }}</td>
                                <td>{{ $izin->deskripsi }}</td>
                                <td><img src="{{ asset('uploads/' . $izin->gambar) }}" alt="gambar" style="width: 100px; height: auto;"></td>
                                <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d F Y') }}</td> <!-- Format tanggal di web -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Daftar Izin / Sakit Hari Ini</div>
                
                <div class="card-body">
                    <table id="izinTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alasan</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Tanggal</th> <!-- Tambahkan kolom tanggal -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($izin_hari_ini as $izin)
                            <tr>
                                <td>{{ $izin->name }}</td>
                                <td>{{ $izin->alasan }}</td>
                                <td>{{ $izin->deskripsi }}</td>
                                <td><img src="{{ asset('uploads/' . $izin->gambar) }}" alt="gambar" style="width: 100px; height: auto;"></td>
                                <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d F Y') }}</td> <!-- Format tanggal di web -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
