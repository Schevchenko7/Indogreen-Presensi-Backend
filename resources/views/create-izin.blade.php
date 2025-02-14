@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="alasan" class="form-label">Pilih Alasan</label>
                    <select name="alasan" id="alasan" class="form-control" required>
                        <option value="">-- Pilih Alasan --</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Alasan</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Deskripsi alasan izin / sakit" required></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
