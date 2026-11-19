# SPMB Online (Laravel + Tailwind CSS)

Website Seleksi Penerimaan Murid Baru berdasarkan alur sistem: Halaman Utama → Login/Registrasi →
(Calon siswa/Orang tua: Daftar → Isi Form → Upload Berkas → Menunggu Pengumuman) /
(Admin: Verifikasi Berkas → Diterima | Berkas Bermasalah → kirim ulang atau Ditolak) → Pengumuman Hasil.

Folder ini adalah **overlay**: berisi file aplikasi yang ditimpa ke proyek Laravel baru (Laravel 11 atau 12).

## Pemasangan

```bash
# 1. Buat proyek Laravel baru
composer create-project laravel/laravel spmb-online
cd spmb-online

# 2. Salin isi folder overlay ini ke dalam proyek (timpa jika ditanya)
#    Folder: app/ config/ database/ resources/ routes/ + vite.config.js
cp -r /path/ke/overlay/. .

# 3. Pasang Tailwind CSS v4 (sudah terpasang di Laravel 12, wajib untuk Laravel 11)
npm install
npm install -D tailwindcss @tailwindcss/vite

# 4. Siapkan database (default SQLite) dan data awal
php artisan migrate --seed

# 5. Jalankan
npm run dev          # terminal 1
php artisan serve    # terminal 2
```

Buka http://localhost:8000

## Akun awal

| Peran | Username | Password |
|-------|----------|----------|
| Admin | `admin` | `admin123` (segera ganti) |
| Calon siswa | daftar sendiri di menu **Daftar** (NIK 16 digit sebagai username) | bebas |

## Pengaturan

Opsional di `.env`:

```
SPMB_SEKOLAH="Nama Sekolah Anda"
SPMB_TAHUN_AJARAN=2026/2027
SPMB_MAX_KIRIM_ULANG=3
```

Daftar berkas wajib ada di `config/spmb.php`.

## Aturan alur

- Calon siswa harus mengisi formulir sebelum bisa upload berkas.
- Berkas dikirim ke admin lewat tombol **Kirim Berkas**; setelah itu tidak bisa diubah.
- Admin memilih **Terima** atau **Berkas bermasalah** (wajib catatan).
- Bermasalah: jika kirim ulang belum mencapai batas → siswa upload ulang; jika sudah → **Ditolak**.
- Hasil baru terlihat setelah admin menekan **Buka Pengumuman** di dashboard admin.
- Berkas disimpan di disk privat (`storage/app/private/berkas`) dan hanya bisa dibuka admin atau pemiliknya.
