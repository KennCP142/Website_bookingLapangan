<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('wa_pemesan');
            $table->date('tanggal');
            $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
            $table->timestamps();
        });

    }

    
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
