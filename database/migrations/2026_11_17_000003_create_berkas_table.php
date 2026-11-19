<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->cascadeOnDelete();
            $table->string('jenis', 30);
            $table->string('path');
            $table->string('nama_asli');
            $table->timestamps();

            $table->unique(['pendaftaran_id', 'jenis']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
