<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        $jadwal = [
            ['nomor_lapangan' => 1, 'jam_mulai' => '09:00', 'jam_selesai' => '11:00'],
            ['nomor_lapangan' => 1, 'jam_mulai' => '11:00', 'jam_selesai' => '13:00'],
            ['nomor_lapangan' => 1, 'jam_mulai' => '13:00', 'jam_selesai' => '15:00'],
            ['nomor_lapangan' => 1, 'jam_mulai' => '15:00', 'jam_selesai' => '17:00'],
            ['nomor_lapangan' => 1, 'jam_mulai' => '17:00', 'jam_selesai' => '19:00'],
            ['nomor_lapangan' => 1, 'jam_mulai' => '19:00', 'jam_selesai' => '21:00'],
            ['nomor_lapangan' => 1, 'jam_mulai' => '21:00', 'jam_selesai' => '23:00'],
            ['nomor_lapangan' => 2, 'jam_mulai' => '09:00', 'jam_selesai' => '11:00'],
            ['nomor_lapangan' => 2, 'jam_mulai' => '11:00', 'jam_selesai' => '13:00'],
            ['nomor_lapangan' => 2, 'jam_mulai' => '13:00', 'jam_selesai' => '15:00'],
            ['nomor_lapangan' => 2, 'jam_mulai' => '15:00', 'jam_selesai' => '17:00'],
            ['nomor_lapangan' => 2, 'jam_mulai' => '17:00', 'jam_selesai' => '19:00'],
            ['nomor_lapangan' => 2, 'jam_mulai' => '19:00', 'jam_selesai' => '21:00'],
            ['nomor_lapangan' => 2, 'jam_mulai' => '21:00', 'jam_selesai' => '23:00'],
        ];

        foreach ($jadwal as $jadwal) {
            DB::table('jadwals')->insert($jadwal);
        }
    }
}
