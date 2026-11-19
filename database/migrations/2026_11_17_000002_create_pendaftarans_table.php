<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nomor_pendaftaran')->nullable()->unique();

            // Data formulir
            $table->string('nama_lengkap')->nullable();
            $table->string('nisn', 10)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 1)->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('no_hp_wali', 20)->nullable();
            $table->boolean('form_lengkap')->default(false);

            // Alur verifikasi
            $table->string('status', 30)->default('draft');
            $table->unsignedTinyInteger('jumlah_kirim_ulang')->default(0);
            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
