<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // username dipakai untuk login: NIK untuk calon siswa, "admin" untuk admin.
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('role', 20)->default('siswa')->after('password');
            $table->string('no_hp', 20)->nullable()->after('role');
        });

        // Email tidak wajib karena login memakai NIK / Username.
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'role', 'no_hp']);
        });
    }
};
