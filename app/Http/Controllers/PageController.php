<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pengaturan;

class PageController extends Controller
{
    /** Halaman Utama */
    public function beranda()
    {
        return view('beranda');
    }

    /** Pengumuman hasil pendaftaran (publik, tampil setelah dibuka admin). */
    public function pengumuman()
    {
        $dibuka = Pengaturan::pengumumanDibuka();

        $diterima = $dibuka
            ? Pendaftaran::where('status', Pendaftaran::DITERIMA)->orderBy('nama_lengkap')->paginate(20)
            : null;

        return view('pengumuman', compact('dibuka', 'diterima'));
    }
}
