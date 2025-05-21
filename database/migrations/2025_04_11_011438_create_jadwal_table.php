<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_lapangan');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->timestamps();
        });

    }

   
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
