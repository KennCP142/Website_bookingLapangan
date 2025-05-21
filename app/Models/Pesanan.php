<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pemesan', 'wa_pemesan', 'tanggal', 'jadwal_id'];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}
