<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berkas extends Model
{
    protected $table = 'berkas';

    protected $fillable = ['pendaftaran_id', 'jenis', 'path', 'nama_asli'];

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function getLabelAttribute(): string
    {
        return config('spmb.berkas')[$this->jenis] ?? $this->jenis;
    }
}
