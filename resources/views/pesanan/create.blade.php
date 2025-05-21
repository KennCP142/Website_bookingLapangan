@extends('layouts.app')

@section('title', 'Form Pemesanan Lapangan')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h1 class="mb-4">Pemesanan Lapangan</h1>

        <form action="{{ route('pesanan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_pemesan" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama_pemesan') is-invalid @enderror" id="nama_pemesan" name="nama_pemesan" value="{{ old('nama_pemesan') }}">
                @error('nama_pemesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="wa_pemesan" class="form-label">WhatsApp</label>
                <input type="text" class="form-control @error('wa_pemesan') is-invalid @enderror" id="wa_pemesan" name="wa_pemesan" value="{{ old('wa_pemesan') }}">
                @error('wa_pemesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Booking</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
                @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jadwal_id" class="form-label">Jadwal</label>
                <select class="form-select @error('jadwal_id') is-invalid @enderror" id="jadwal_id" name="jadwal_id">
                    <option value="">Pilih Jadwal</option>
                    @foreach($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}" {{ old('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                            Lapangan {{ $jadwal->nomor_lapangan }} | {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                        </option>
                    @endforeach
                </select>
                @error('jadwal_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning">Simpan</button>
            <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection