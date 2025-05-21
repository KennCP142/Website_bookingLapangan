@extends('layouts.app')

@section('title', 'UTS WFD')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: darkred;">
                <h3 class="mb-0" style="color: white;">List Pemesanan Lapangan</h3>
                <a href="{{ route('pesanan.create') }}" class="btn btn-dark ">+ Pemesanan Baru</a>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.index') }}" method="GET" class="mb-4">
                    <h4>Filter</h4>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="nomor_lapangan" class="form-label">Nomor Lapangan</label>
                            <select class="form-select" id="nomor_lapangan" name="nomor_lapangan">
                                <option value="Semua Lapangan">Semua Lapangan</option>
                                @foreach($nomorLapangan as $nomor)
                                    <option value="{{ $nomor }}" {{ request('nomor_lapangan') == $nomor ? 'selected' : '' }}>
                                        Lapangan {{ $nomor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="jam_pemakaian" class="form-label">Jam Pemakaian</label>
                            <select class="form-select" id="jam_pemakaian" name="jam_pemakaian">
                                <option value="Semua Jam Pemakaian">Semua Jam Pemakaian</option>
                                @foreach($jamPemakaian as $jam)
                                    <option value="{{ $jam }}" {{ request('jam_pemakaian') == $jam ? 'selected' : '' }}>
                                        {{ $jam }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="tanggal" class="form-label">Rentang Awal Tanggal Booking</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal" class="form-label">Rentang Akhir Tanggal Booking</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="">
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="semua_tanggal" name="semua_tanggal" value="1" {{ request('semua_tanggal') ? 'checked' : '' }}>
                        <label class="form-check-label" for="semua_tanggal">
                            Semua Tanggal Booking?
                        </label>
                    </div>
                    <button type="submit" class="btn btn-dark mt-3">Tampilkan</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pemesan</th>
                                <th>Nomor WhatsApp</th>
                                <th>Tanggal Booking</th>
                                <th>Nomor Lapangan</th>
                                <th>Jam Pemakaian</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanans as $index => $pesanan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pesanan->nama_pemesan }}</td>
                                    <td>{{ $pesanan->wa_pemesan }}</td>
                                    <td>{{ date('d F Y', strtotime($pesanan->tanggal)) }}</td>
                                    <td>{{ $pesanan->jadwal->nomor_lapangan }}</td>
                                    <td>{{ $pesanan->jadwal->jam_mulai }} - {{ $pesanan->jadwal->jam_selesai }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('pesanan.edit', $pesanan->id) }}" class="btn btn-success btn-secondary">Edit</a>
                                            <form action="{{ route('pesanan.destroy', $pesanan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-secondary">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pemesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
