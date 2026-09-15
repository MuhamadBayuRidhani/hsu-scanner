<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Whitelist Root Domains & Hosts
    |--------------------------------------------------------------------------
    |
    | Setiap domain resmi Pemkab HSU (*.hsu.go.id) maupun instansi vertikal
    | mitra di Kabupaten Hulu Sungai Utara diizinkan untuk diaudit.
    |
    */
    'allowed_roots' => [
        'hsu.go.id',
        'kab-hulusungaiutara.kpu.go.id',
        'pa-amuntai.go.id',
        'pn-amuntai.go.id',
        'hulusungaiutara.kalsel.polri.go.id',
        'hulusungaiutara.bawaslu.go.id',
        'hulusungaiutarakab.bps.go.id',
        'hsu.bps.go.id',
    ],

    /*
    |--------------------------------------------------------------------------
    | Katalog Lengkap Website Pemerintah & Instansi Vertikal HSU
    |--------------------------------------------------------------------------
    |
    | Daftar seluruh instansi vertikal, dinas, badan, kecamatan, kelurahan,
    | dan puskesmas di Kabupaten Hulu Sungai Utara.
    |
    */
    'catalog' => [
        'Portal Utama & Sekretariat Daerah' => [
            'icon' => '🏛️',
            'items' => [
                ['name' => 'Portal Resmi Pemkab Hulu Sungai Utara', 'url' => 'https://web.hsu.go.id', 'host' => 'web.hsu.go.id'],
                ['name' => 'Sekretariat Daerah (Prokopim)', 'url' => 'https://prokopim.hsu.go.id/', 'host' => 'prokopim.hsu.go.id'],
                ['name' => 'Sekretariat Daerah (SETDA)', 'url' => 'https://setda.hsu.go.id', 'host' => 'setda.hsu.go.id'],
                ['name' => 'Sekretariat DPRD', 'url' => 'https://setdprdkab.hsu.go.id/', 'host' => 'setdprdkab.hsu.go.id'],
                ['name' => 'Portal Satu Data HSU', 'url' => 'https://data.hsu.go.id', 'host' => 'data.hsu.go.id'],
                ['name' => 'Layanan Informasi Publik (PPID)', 'url' => 'https://ppid.hsu.go.id', 'host' => 'ppid.hsu.go.id'],
                ['name' => 'Layanan Pengadaan Secara Elektronik (LPSE)', 'url' => 'https://lpse.hsu.go.id', 'host' => 'lpse.hsu.go.id'],
            ]
        ],
        'Instansi Vertikal & Lembaga Hukum / Forkopimda' => [
            'icon' => '⚖️',
            'items' => [
                ['name' => 'Bagian Hukum (JDIH HSU)', 'url' => 'https://jdih.hsu.go.id/', 'host' => 'jdih.hsu.go.id'],
                ['name' => 'RSUD Pambalah Batung Amuntai', 'url' => 'https://rspb.hsu.go.id/', 'host' => 'rspb.hsu.go.id'],
                ['name' => 'Badan Pusat Statistik (BPS) HSU', 'url' => 'https://hulusungaiutarakab.bps.go.id/', 'host' => 'hulusungaiutarakab.bps.go.id'],
                ['name' => 'Kejaksaan Negeri HSU', 'url' => 'https://kejari.hsu.go.id/', 'host' => 'kejari.hsu.go.id'],
                ['name' => 'Komisi Pemilihan Umum (KPU) HSU', 'url' => 'https://kab-hulusungaiutara.kpu.go.id/', 'host' => 'kab-hulusungaiutara.kpu.go.id'],
                ['name' => 'Pengadilan Agama HSU (Amuntai)', 'url' => 'https://www.pa-amuntai.go.id/', 'host' => 'www.pa-amuntai.go.id'],
                ['name' => 'Pengadilan Negeri HSU (Amuntai)', 'url' => 'https://www.pn-amuntai.go.id/', 'host' => 'www.pn-amuntai.go.id'],
                ['name' => 'Polres Hulu Sungai Utara', 'url' => 'http://hulusungaiutara.kalsel.polri.go.id/', 'host' => 'hulusungaiutara.kalsel.polri.go.id'],
                ['name' => 'Bawaslu Kab. Hulu Sungai Utara', 'url' => 'https://hulusungaiutara.bawaslu.go.id/', 'host' => 'hulusungaiutara.bawaslu.go.id'],
            ]
        ],
        'Dinas & Badan Daerah' => [
            'icon' => '🏢',
            'items' => [
                ['name' => 'Inspektorat Daerah', 'url' => 'https://inspektorat.hsu.go.id/', 'host' => 'inspektorat.hsu.go.id'],
                ['name' => 'Badan Pendapatan Daerah (Bapenda)', 'url' => 'https://bapenda.hsu.go.id/', 'host' => 'bapenda.hsu.go.id'],
                ['name' => 'Bappedalitbang', 'url' => 'https://bappedalitbang.hsu.go.id/', 'host' => 'bappedalitbang.hsu.go.id'],
                ['name' => 'BKPSDM Kab. HSU', 'url' => 'https://bkpsdm.hsu.go.id/', 'host' => 'bkpsdm.hsu.go.id'],
                ['name' => 'Badan Penanggulangan Bencana Daerah (BPBD)', 'url' => 'https://bpbd.hsu.go.id/', 'host' => 'bpbd.hsu.go.id'],
                ['name' => 'BPKAD Kab. HSU', 'url' => 'https://bpkad.hsu.go.id/', 'host' => 'bpkad.hsu.go.id'],
                ['name' => 'Dinas Kependudukan & Catatan Sipil (Dukcapil)', 'url' => 'https://dukcapil.hsu.go.id/', 'host' => 'dukcapil.hsu.go.id'],
                ['name' => 'Dinas Ketahanan Pangan', 'url' => 'https://ketahananpangan.hsu.go.id/', 'host' => 'ketahananpangan.hsu.go.id'],
                ['name' => 'Dinas Kesehatan (Dinkes)', 'url' => 'https://dinkes.hsu.go.id/', 'host' => 'dinkes.hsu.go.id'],
                ['name' => 'Dinas Komunikasi, Informatika dan Persandian (Diskominfo)', 'url' => 'https://diskominfo.hsu.go.id/', 'host' => 'diskominfo.hsu.go.id'],
                ['name' => 'Dinas Koperasi, Perindag (Disperindagkop)', 'url' => 'https://disperindagkop.hsu.go.id/', 'host' => 'disperindagkop.hsu.go.id'],
                ['name' => 'Dinas Pendidikan (Disdik)', 'url' => 'https://disdik.hsu.go.id/', 'host' => 'disdik.hsu.go.id'],
                ['name' => 'Dinas Perpustakaan (Dispersip)', 'url' => 'https://dispersip.hsu.go.id/', 'host' => 'dispersip.hsu.go.id'],
                ['name' => 'Dinas Perhubungan (Dishub)', 'url' => 'https://dishub.hsu.go.id/', 'host' => 'dishub.hsu.go.id'],
                ['name' => 'Dinas Perikanan', 'url' => 'https://perikanan.hsu.go.id/', 'host' => 'perikanan.hsu.go.id'],
                ['name' => 'Dinas Perkim LH', 'url' => 'https://disperkimlh.hsu.go.id/', 'host' => 'disperkimlh.hsu.go.id'],
                ['name' => 'Dinas Pertanian', 'url' => 'https://pertanian.hsu.go.id/', 'host' => 'pertanian.hsu.go.id'],
                ['name' => 'Dinas PPKB', 'url' => 'https://dppkb.hsu.go.id/', 'host' => 'dppkb.hsu.go.id'],
                ['name' => 'Dinas Kepemudaan, Olahraga & Pariwisata (Dispora)', 'url' => 'https://dispora.hsu.go.id/', 'host' => 'dispora.hsu.go.id'],
                ['name' => 'Dinas PPPA', 'url' => 'https://dpppa.hsu.go.id/', 'host' => 'dpppa.hsu.go.id'],
                ['name' => 'Dinas Pemberdayaan Masyarakat dan Desa (DPMD)', 'url' => 'https://dpmd.hsu.go.id/', 'host' => 'dpmd.hsu.go.id'],
                ['name' => 'Dinas PUPR', 'url' => 'https://dpupr.hsu.go.id/', 'host' => 'dpupr.hsu.go.id'],
                ['name' => 'Dinas Penanaman Modal & PTSP (DPMPTSP)', 'url' => 'https://dpmptsp.hsu.go.id/', 'host' => 'dpmptsp.hsu.go.id'],
                ['name' => 'Dinas Sosial (Dinsos)', 'url' => 'https://dinsos.hsu.go.id/', 'host' => 'dinsos.hsu.go.id'],
                ['name' => 'Satpol PP dan Damkar', 'url' => 'https://satpolppdamkar.hsu.go.id/', 'host' => 'satpolppdamkar.hsu.go.id'],
                ['name' => 'Badan Kesatuan Bangsa dan Politik (Kesbangpol)', 'url' => 'https://kesbangpol.hsu.go.id/', 'host' => 'kesbangpol.hsu.go.id'],
            ]
        ],
        'Kecamatan & Kelurahan' => [
            'icon' => '📍',
            'items' => [
                ['name' => 'Kecamatan Amuntai Tengah', 'url' => 'https://kec-amuntaitengah.hsu.go.id/', 'host' => 'kec-amuntaitengah.hsu.go.id'],
                ['name' => 'Kecamatan Amuntai Selatan', 'url' => 'https://kec-amuntaiselatan.hsu.go.id/', 'host' => 'kec-amuntaiselatan.hsu.go.id'],
                ['name' => 'Kecamatan Amuntai Utara', 'url' => 'https://kec-amuntaiutara.hsu.go.id/', 'host' => 'kec-amuntaiutara.hsu.go.id'],
                ['name' => 'Kecamatan Banjang', 'url' => 'https://kec-banjang.hsu.go.id/', 'host' => 'kec-banjang.hsu.go.id'],
                ['name' => 'Kecamatan Haur Gading', 'url' => 'https://kec-haurgading.hsu.go.id/', 'host' => 'kec-haurgading.hsu.go.id'],
                ['name' => 'Kecamatan Sei Tabukan', 'url' => 'https://kec-seitabukan.hsu.go.id/', 'host' => 'kec-seitabukan.hsu.go.id'],
                ['name' => 'Kecamatan Babirik', 'url' => 'https://kec-babirik.hsu.go.id/', 'host' => 'kec-babirik.hsu.go.id'],
                ['name' => 'Kecamatan Sei Pandan', 'url' => 'https://kec-seipandan.hsu.go.id/', 'host' => 'kec-seipandan.hsu.go.id'],
                ['name' => 'Kecamatan Danau Panggang', 'url' => 'https://kec-danaupanggang.hsu.go.id/', 'host' => 'kec-danaupanggang.hsu.go.id'],
                ['name' => 'Kecamatan Paminggir', 'url' => 'https://kec-paminggir.hsu.go.id/', 'host' => 'kec-paminggir.hsu.go.id'],
                ['name' => 'Kelurahan Antasari', 'url' => 'https://kel-antasari.hsu.go.id/', 'host' => 'kel-antasari.hsu.go.id'],
            ]
        ],
        'Pusat Kesehatan Masyarakat (Puskesmas / PKM)' => [
            'icon' => '🏥',
            'items' => [
                ['name' => 'PKM Alabio', 'url' => 'https://pkm-alabio.hsu.go.id/', 'host' => 'pkm-alabio.hsu.go.id'],
                ['name' => 'PKM Sungai Turak', 'url' => 'https://pkm-sungaiturak.hsu.go.id/', 'host' => 'pkm-sungaiturak.hsu.go.id'],
                ['name' => 'PKM Amuntai Selatan', 'url' => 'https://pkm-amuntaiselatan.hsu.go.id/', 'host' => 'pkm-amuntaiselatan.hsu.go.id'],
                ['name' => 'PKM Babirik', 'url' => 'https://pkm-babirik.hsu.go.id/', 'host' => 'pkm-babirik.hsu.go.id'],
                ['name' => 'PKM Banjang', 'url' => 'https://pkm-banjang.hsu.go.id/', 'host' => 'pkm-banjang.hsu.go.id'],
                ['name' => 'PKM Danau Panggang', 'url' => 'https://pkm-danaupanggang.hsu.go.id/', 'host' => 'pkm-danaupanggang.hsu.go.id'],
                ['name' => 'PKM Guntung', 'url' => 'https://pkm-guntung.hsu.go.id/', 'host' => 'pkm-guntung.hsu.go.id'],
                ['name' => 'PKM Haur Gading', 'url' => 'https://pkm-haurgading.hsu.go.id/', 'host' => 'pkm-haurgading.hsu.go.id'],
                ['name' => 'PKM Paminggir', 'url' => 'https://pkm-paminggir.hsu.go.id/', 'host' => 'pkm-paminggir.hsu.go.id'],
                ['name' => 'PKM Pasar Sabtu', 'url' => 'https://pkm-pasarsabtu.hsu.go.id/', 'host' => 'pkm-pasarsabtu.hsu.go.id'],
            ]
        ],
    ]
];
