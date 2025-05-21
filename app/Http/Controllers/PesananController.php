<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with('jadwal')->orderBy('tanggal', 'asc');

       
        if ($request->has('nama_pemesan') && !empty($request->nama_pemesan)) {
            $query->where('nama_pemesan', 'like', '%' . $request->nama_pemesan . '%');
        }

        
        if ($request->has('tanggal') && !empty($request->tanggal)) {
            $query->whereDate('tanggal', $request->tanggal);
        }

       
        if ($request->has('nomor_lapangan') && $request->nomor_lapangan != 'Semua Lapangan') {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('nomor_lapangan', $request->nomor_lapangan);
            });
        }

        
        if ($request->has('jam_pemakaian') && $request->jam_pemakaian != 'Semua Jam Pemakaian') {
            $jamArray = explode(' - ', $request->jam_pemakaian);
            if (count($jamArray) == 2) {
                $jamMulai = $jamArray[0];
                $jamSelesai = $jamArray[1];
                
                $query->whereHas('jadwal', function($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', $jamMulai)
                      ->where('jam_selesai', $jamSelesai);
                });
            }
        }

        $pesanans = $query->get();
        $jadwals = Jadwal::all();
        
        
        $nomorLapangan = Jadwal::select('nomor_lapangan')->distinct()->pluck('nomor_lapangan');
        
        
        $jamPemakaian = Jadwal::select('jam_mulai', 'jam_selesai')
            ->distinct()
            ->get()
            ->map(function($item) {
                return $item->jam_mulai . ' - ' . $item->jam_selesai;
            });

        return view('pesanan.index', compact('pesanans', 'jadwals', 'nomorLapangan', 'jamPemakaian'));
    }

    public function create()
    {
        $jadwals = Jadwal::all();
        return view('pesanan.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemesan' => 'required|max:255',
            'wa_pemesan' => 'required|max:20',
            'tanggal' => 'required|date|after_or_equal:today',
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        
        $jadwal = Jadwal::findOrFail($request->jadwal_id);
        $existingBooking = Pesanan::where('tanggal', $request->tanggal)
            ->whereHas('jadwal', function($query) use ($jadwal) {
                $query->where('nomor_lapangan', $jadwal->nomor_lapangan)
                    ->where('jam_mulai', $jadwal->jam_mulai)
                    ->where('jam_selesai', $jadwal->jam_selesai);
            })
            ->exists();

        if ($existingBooking) {
            return redirect()->back()
                ->with('error', 'Jadwal sudah dipesan untuk tanggal dan waktu tersebut!')
                ->withInput();
        }

        
        Pesanan::create([
            'nama_pemesan' => $request->nama_pemesan,
            'wa_pemesan' => $request->wa_pemesan,
            'tanggal' => $request->tanggal,
            'jadwal_id' => $request->jadwal_id,
        ]);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pemesanan berhasil dibuat!');
    }

    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $jadwals = Jadwal::all();
        return view('pesanan.edit', compact('pesanan', 'jadwals'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemesan' => 'required|max:255',
            'wa_pemesan' => 'required|max:20',
            'tanggal' => 'required|date|after_or_equal:today',
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pesanan = Pesanan::findOrFail($id);
        $jadwal = Jadwal::findOrFail($request->jadwal_id);

       
        $existingBooking = Pesanan::where('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
            ->whereHas('jadwal', function($query) use ($jadwal) {
                $query->where('nomor_lapangan', $jadwal->nomor_lapangan)
                    ->where('jam_mulai', $jadwal->jam_mulai)
                    ->where('jam_selesai', $jadwal->jam_selesai);
            })
            ->exists();

        if ($existingBooking) {
            return redirect()->back()
                ->with('error', 'Jadwal sudah dipesan untuk tanggal dan waktu tersebut!')
                ->withInput();
        }

        // Update booking
        $pesanan->update([
            'nama_pemesan' => $request->nama_pemesan,
            'wa_pemesan' => $request->wa_pemesan,
            'tanggal' => $request->tanggal,
            'jadwal_id' => $request->jadwal_id,
        ]);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pemesanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('pesanan.index')
            ->with('success', 'Pemesanan berhasil dihapus!');
    }
}
