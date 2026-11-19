<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftaran extends Model
{
    public const DRAFT = 'draft';
    public const MENUNGGU = 'menunggu_verifikasi';
    public const BERMASALAH = 'berkas_bermasalah';
    public const DITERIMA = 'diterima';
    public const DITOLAK = 'ditolak';

    protected $table = 'pendaftarans';

    protected $fillable = [
        'user_id',
        'nomor_pendaftaran',
        'nama_lengkap',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'asal_sekolah',
        'alamat',
        'nama_wali',
        'no_hp_wali',
        'form_lengkap',
        'status',
        'jumlah_kirim_ulang',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'form_lengkap' => 'boolean',
        ];
    }

    public static function daftarStatus(): array
    {
        return [
            self::DRAFT => 'Belum Lengkap',
            self::MENUNGGU => 'Menunggu Verifikasi',
            self::BERMASALAH => 'Berkas Bermasalah',
            self::DITERIMA => 'Diterima',
            self::DITOLAK => 'Ditolak',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function berkas(): HasMany
    {
        return $this->hasMany(Berkas::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::daftarStatus()[$this->status] ?? $this->status;
    }

    /** Formulir dan berkas masih boleh diubah calon siswa. */
    public function bolehDiubah(): bool
    {
        return in_array($this->status, [self::DRAFT, self::BERMASALAH], true);
    }

    public function berkasLengkap(): bool
    {
        $ada = $this->berkas()->pluck('jenis')->all();

        return count(array_diff(array_keys(config('spmb.berkas')), $ada)) === 0;
    }

    public function sisaKirimUlang(): int
    {
        return max(0, config('spmb.max_kirim_ulang') - $this->jumlah_kirim_ulang);
    }

    public function kirimUlangHabis(): bool
    {
        return $this->jumlah_kirim_ulang >= config('spmb.max_kirim_ulang');
    }

    /** Tahap pada alur: 1 Daftar, 2 Isi Form, 3 Upload Berkas, 4 Verifikasi, 5 Pengumuman. */
    public function tahap(): int
    {
        return match (true) {
            ! $this->form_lengkap => 2,
            $this->status === self::DRAFT => 3,
            in_array($this->status, [self::MENUNGGU, self::BERMASALAH], true) => 4,
            default => 5,
        };
    }
}
