<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    /** Menampilkan berkas (hanya admin atau pemilik berkas). */
    public function tampil(Berkas $berkas)
    {
        $user = Auth::user();

        abort_unless(
            $user->isAdmin() || $berkas->pendaftaran->user_id === $user->id,
            403
        );
        abort_unless(Storage::disk('local')->exists($berkas->path), 404);

        return Storage::disk('local')->response($berkas->path, $berkas->nama_asli);
    }
}
