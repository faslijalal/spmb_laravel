<?php

return [
    'nama' => 'SPMB Online',
    'sekolah' => env('SPMB_SEKOLAH', 'Nama Sekolah'),
    'tahun_ajaran' => env('SPMB_TAHUN_AJARAN', '2026/2027'),

    // Batas kirim ulang berkas setelah dinyatakan bermasalah (sesuai alur: "kirim ulang sudah mencapai max").
    'max_kirim_ulang' => (int) env('SPMB_MAX_KIRIM_ULANG', 3),

    // Berkas wajib yang harus diunggah calon siswa.
    'berkas' => [
        'kk' => 'Kartu Keluarga',
        'akta' => 'Akta Kelahiran',
        'ijazah' => 'Ijazah / SKL',
        'foto' => 'Pas Foto 3x4',
    ],
];
