<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Pendaftaran;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    private function pendaftaran(): ?Pendaftaran
    {
        return Auth::user()->pendaftaran;
    }

    private function belumDaftar()
    {
        return redirect()->route('siswa.dashboard')
            ->with('error', 'Mulai pendaftaran terlebih dahulu.');
    }

    public function dashboard()
    {
        $pendaftaran = $this->pendaftaran();

        return view('siswa.dashboard', [
            'pendaftaran' => $pendaftaran,
            'pengumumanDibuka' => Pengaturan::pengumumanDibuka(),
        ]);
    }

    /** Langkah "Daftar": membuat data pendaftaran. */
    public function daftar()
    {
        $user = Auth::user();

        if (! $user->pendaftaran) {
            $p = Pendaftaran::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
                'status' => Pendaftaran::DRAFT,
            ]);
            $p->update(['nomor_pendaftaran' => sprintf('SPMB-%s-%04d', date('Y'), $p->id)]);
        }

        return redirect()->route('siswa.formulir');
    }

    /** Langkah "Mengisi Form". */
    public function formulir()
    {
        $p = $this->pendaftaran();
        if (! $p) {
            return $this->belumDaftar();
        }

        return view('siswa.formulir', ['pendaftaran' => $p]);
    }

    public function simpanFormulir(Request $request)
    {
        $p = $this->pendaftaran();
        if (! $p) {
            return $this->belumDaftar();
        }
        if (! $p->bolehDiubah()) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Formulir tidak dapat diubah saat berkas sedang diverifikasi.');
        }

        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'nisn' => ['required', 'digits:10'],
            'tempat_lahir' => ['required', 'string', 'max:80'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'asal_sekolah' => ['required', 'string', 'max:120'],
            'alamat' => ['required', 'string', 'max:500'],
            'nama_wali' => ['required', 'string', 'max:100'],
            'no_hp_wali' => ['required', 'regex:/^[0-9+]{9,15}$/'],
        ], [
            'required' => ':attribute wajib diisi.',
            'nisn.digits' => 'NISN harus 10 digit angka.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'no_hp_wali.regex' => 'Format nomor HP tidak valid.',
        ], [
            'nama_lengkap' => 'Nama lengkap',
            'nisn' => 'NISN',
            'tempat_lahir' => 'Tempat lahir',
            'tanggal_lahir' => 'Tanggal lahir',
            'jenis_kelamin' => 'Jenis kelamin',
            'asal_sekolah' => 'Asal sekolah',
            'alamat' => 'Alamat',
            'nama_wali' => 'Nama orang tua / wali',
            'no_hp_wali' => 'No. HP orang tua / wali',
        ]);

        $p->update($data + ['form_lengkap' => true]);

        return redirect()->route('siswa.berkas')
            ->with('sukses', 'Formulir tersimpan. Lanjutkan dengan mengunggah berkas.');
    }

    /** Langkah "Upload Berkas". */
    public function berkas()
    {
        $p = $this->pendaftaran();
        if (! $p) {
            return $this->belumDaftar();
        }
        if (! $p->form_lengkap) {
            return redirect()->route('siswa.formulir')
                ->with('error', 'Lengkapi formulir terlebih dahulu.');
        }

        return view('siswa.berkas', [
            'pendaftaran' => $p,
            'berkas' => $p->berkas()->get()->keyBy('jenis'),
        ]);
    }

    public function simpanBerkas(Request $request)
    {
        $p = $this->pendaftaran();
        if (! $p || ! $p->form_lengkap || ! $p->bolehDiubah()) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Berkas tidak dapat diubah saat ini.');
        }

        $aturan = [];
        foreach (array_keys(config('spmb.berkas')) as $jenis) {
            $aturan[$jenis] = $jenis === 'foto'
                ? ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048']
                : ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
        }

        $request->validate($aturan, [
            'mimes' => ':attribute harus berformat JPG, PNG, atau PDF (foto: JPG/PNG).',
            'max' => 'Ukuran :attribute maksimal 2 MB.',
            'uploaded' => ':attribute gagal diunggah. Coba lagi.',
        ], config('spmb.berkas'));

        $tersimpan = 0;
        foreach (array_keys(config('spmb.berkas')) as $jenis) {
            if (! $request->hasFile($jenis)) {
                continue;
            }

            $file = $request->file($jenis);
            $lama = Berkas::where('pendaftaran_id', $p->id)->where('jenis', $jenis)->first();
            if ($lama) {
                Storage::disk('local')->delete($lama->path);
            }

            Berkas::updateOrCreate(
                ['pendaftaran_id' => $p->id, 'jenis' => $jenis],
                [
                    'path' => $file->store("berkas/{$p->id}", 'local'),
                    'nama_asli' => $file->getClientOriginalName(),
                ]
            );
            $tersimpan++;
        }

        return back()->with(
            'sukses',
            $tersimpan ? "{$tersimpan} berkas berhasil disimpan." : 'Tidak ada berkas baru yang dipilih.'
        );
    }

    /** Mengirim berkas ke admin untuk diverifikasi (termasuk kirim ulang). */
    public function kirimBerkas()
    {
        $p = $this->pendaftaran();
        if (! $p || ! $p->form_lengkap || ! $p->bolehDiubah()) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Berkas tidak dapat dikirim saat ini.');
        }
        if (! $p->berkasLengkap()) {
            return back()->with('error', 'Lengkapi semua berkas wajib sebelum mengirim.');
        }

        $kirimUlang = $p->status === Pendaftaran::BERMASALAH;

        $p->update([
            'status' => Pendaftaran::MENUNGGU,
            'jumlah_kirim_ulang' => $p->jumlah_kirim_ulang + ($kirimUlang ? 1 : 0),
        ]);

        return redirect()->route('siswa.dashboard')
            ->with('sukses', 'Berkas terkirim. Mohon tunggu proses verifikasi dan pengumuman.');
    }

    /** Hasil pendaftaran (tampil setelah admin membuka pengumuman). */
    public function hasil()
    {
        $p = $this->pendaftaran();
        if (! $p) {
            return $this->belumDaftar();
        }

        return view('siswa.hasil', [
            'pendaftaran' => $p,
            'pengumumanDibuka' => Pengaturan::pengumumanDibuka(),
        ]);
    }
}
