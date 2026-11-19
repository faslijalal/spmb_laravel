<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $hitung = Pendaftaran::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', [
            'hitung' => $hitung,
            'total' => $hitung->sum(),
            'antrian' => Pendaftaran::where('status', Pendaftaran::MENUNGGU)
                ->latest('updated_at')->limit(6)->get(),
            'pengumumanDibuka' => Pengaturan::pengumumanDibuka(),
        ]);
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $status = $request->query('status');

        $pendaftar = Pendaftaran::with('user')
            ->when($status && array_key_exists($status, Pendaftaran::daftarStatus()),
                fn ($query) => $query->where('status', $status))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nama_lengkap', 'like', "%{$q}%")
                        ->orWhere('nomor_pendaftaran', 'like', "%{$q}%")
                        ->orWhere('nisn', 'like', "%{$q}%");
                });
            })
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pendaftar.index', compact('pendaftar', 'q', 'status'));
    }

    /** Halaman "Verifikasi Berkas". */
    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['user', 'berkas']);

        return view('admin.pendaftar.show', ['p' => $pendaftaran]);
    }

    /** Verifikasi: Diterima. */
    public function terima(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status !== Pendaftaran::MENUNGGU) {
            return back()->with('error', 'Hanya pendaftar berstatus "Menunggu Verifikasi" yang dapat diverifikasi.');
        }

        $pendaftaran->update(['status' => Pendaftaran::DITERIMA, 'catatan_admin' => null]);

        return redirect()->route('admin.pendaftar.index')
            ->with('sukses', "{$pendaftaran->nama_lengkap} dinyatakan DITERIMA.");
    }

    /**
     * Verifikasi: Berkas bermasalah.
     * Jika kirim ulang sudah mencapai batas maksimum -> Ditolak,
     * jika belum -> calon siswa diminta mengunggah ulang.
     */
    public function bermasalah(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status !== Pendaftaran::MENUNGGU) {
            return back()->with('error', 'Hanya pendaftar berstatus "Menunggu Verifikasi" yang dapat diverifikasi.');
        }

        $data = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:500'],
        ], [
            'catatan_admin.required' => 'Tuliskan catatan berkas yang bermasalah agar siswa dapat memperbaikinya.',
        ]);

        if ($pendaftaran->kirimUlangHabis()) {
            $pendaftaran->update(['status' => Pendaftaran::DITOLAK] + $data);
            $pesan = "Batas kirim ulang tercapai. {$pendaftaran->nama_lengkap} dinyatakan DITOLAK.";
        } else {
            $pendaftaran->update(['status' => Pendaftaran::BERMASALAH] + $data);
            $pesan = "Berkas ditandai bermasalah. {$pendaftaran->nama_lengkap} diminta mengirim ulang.";
        }

        return redirect()->route('admin.pendaftar.index')->with('sukses', $pesan);
    }

    public function togglePengumuman()
    {
        $dibuka = ! Pengaturan::pengumumanDibuka();
        Pengaturan::simpan('pengumuman_dibuka', $dibuka ? '1' : '0');

        return back()->with('sukses', $dibuka ? 'Pengumuman dibuka untuk umum.' : 'Pengumuman ditutup.');
    }
}
