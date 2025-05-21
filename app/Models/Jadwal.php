<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = ['nomor_lapangan', 'jam_mulai', 'jam_selesai'];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}
