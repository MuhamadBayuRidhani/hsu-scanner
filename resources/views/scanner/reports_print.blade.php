@php
    $isFullReport = ($reportMode ?? request('mode', 'resmi')) === 'lengkap';

    $categoryLabels = [
        'header_security'      => 'HTTP Security Headers',
        'sensitive_leak'       => 'Proteksi File Sensitif',
        'upload_webshell'      => 'File Upload & Web Shell',
        'sqli_sanitization'    => 'SQL Injection & Sanitasi Input',
        'auth_bruteforce'      => 'Autentikasi & Proteksi Brute-Force',
        'fim'                  => 'File Integrity Monitoring (FIM)',
        'dependency_framework' => 'Eksposur Framework & Versi Server',
    ];

    $getRemediation = function (string $name): array {
        if (str_contains($name, 'Sensitive Data')) {
            return ['Kritis', 'Segera kunci atau hapus file sensitif (.env, backup.zip, .git) dari DocumentRoot web dan blokir akses file tersembunyi pada konfigurasi web server.'];
        } elseif (str_contains($name, 'Content-Security-Policy')) {
            return ['Tinggi', 'Tambahkan header Content-Security-Policy (CSP) untuk membatasi sumber skrip/aset yang sah guna mencegah serangan Cross-Site Scripting (XSS).'];
        } elseif (str_contains($name, 'Strict-Transport-Security')) {
            return ['Tinggi', 'Aktifkan header Strict-Transport-Security (HSTS) dengan max-age minimal 31536000 detik agar browser selalu mengunci koneksi ke HTTPS.'];
        } elseif (str_contains($name, 'X-Frame-Options')) {
            return ['Sedang', 'Tambahkan header X-Frame-Options: SAMEORIGIN untuk mencegah penyisipan halaman pada iframe eksternal (Clickjacking).'];
        } elseif (str_contains($name, 'X-Content-Type-Options')) {
            return ['Sedang', 'Tambahkan header X-Content-Type-Options: nosniff agar browser tidak menebak tipe MIME secara otomatis (MIME-sniffing).'];
        } elseif (str_contains($name, 'Web Shell')) {
            return ['Kritis', 'SEGERA isolasi server, hapus file web shell terdeteksi, lakukan audit integritas menyeluruh pada direktori web, dan periksa access log server.'];
        } elseif (str_contains($name, 'Unvalidated File Upload')) {
            return ['Tinggi', 'Batasi ekstensi dan tipe MIME pada form maupun backend server, serta simpan file unggahan di luar direktori eksekusi skrip.'];
        } elseif (str_contains($name, 'SQL Injection')) {
            return ['Kritis', 'Gunakan Prepared Statements / Parameterized Queries pada seluruh akses database dan validasi ketat setiap parameter input URL/form.'];
        } elseif (str_contains($name, 'Brute-Force')) {
            return ['Tinggi', 'Terapkan pembatasan laju login (Rate Limiting) dan tambahkan CAPTCHA (Turnstile / reCAPTCHA) pada halaman autentikasi admin/CMS.'];
        } elseif (str_contains($name, 'Debug') || str_contains($name, 'Config Files')) {
            return ['Tinggi', 'Hapus atau blokir akses publik ke file debug/konfigurasi seperti phpinfo.php, server-status, .htaccess, web.config, dan readme.html.'];
        } elseif (str_contains($name, 'Framework') || str_contains($name, 'Version')) {
            return ['Sedang', 'Sembunyikan header X-Powered-By, nomor versi Server, dan meta tag generator CMS untuk mencegah pemetaan celah spesifik versi (CVE).'];
        }
        return ['Sedang', 'Lakukan pengerasan konfigurasi server (system hardening) sesuai standar keamanan informasi pemerintah daerah.'];
    };

    // Hitung statistik tambahan untuk Laporan Lengkap
    $gradeACount = $allScans->where('score', '>=', 85)->count();
    $gradeBCount = $allScans->whereBetween('score', [70, 84])->count();
    $gradeCCount = $allScans->whereBetween('score', [50, 69])->count();
    $gradeFCount = $allScans->where('score', '<', 50)->count();

    $totalFindingsCount = 0;
    foreach ($allScans as $s) {
        $totalFindingsCount += count($s->file_results ?? []);
    }

    $baseQuery = collect(request()->query())->except('mode')->toArray();

    $gradeFilterLabels = [
        'all'      => 'Semua Predikat',
        'secure'   => 'Aman / Optimal (≥80)',
        'warning'  => 'Waspada (50-79)',
        'critical' => 'Kritis (<50)',
    ];
    $activeGradeLabel = $gradeFilterLabels[request('grade', 'all')] ?? 'Semua Predikat';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isFullReport ? 'Laporan Lengkap & Rincian Teknis Audit Keamanan Siber OPD Kab. HSU' : 'Laporan Resmi Rekapitulasi Audit Keamanan Siber OPD Kab. HSU' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-hsu.png') }}">
    
    <!-- Google Fonts: Times New Roman alternative + Plus Jakarta Sans + JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Tinos:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        gov: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            300: '#7cc8fb',
                            400: '#36abf7',
                            500: '#0c90e7',
                            600: '#0272c5',
                            700: '#035ba0',
                            800: '#074e84',
                            900: '#0b416e',
                            950: '#072a4a',
                        },
                        navy: {
                            800: '#1e293b',
                            850: '#141e30',
                            900: '#0f172a',
                            950: '#080d1a',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        @page {
            size: A4 portrait;
            margin: 14mm 14mm 14mm 14mm;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
            background: #f1f5f9;
        }

        .formal-font {
            font-family: 'Tinos', 'Times New Roman', serif;
        }

        .paper-container {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            padding: 16mm 16mm 16mm 16mm;
            position: relative;
        }

        /* Kop Surat Double Line */
        .kop-border {
            border-bottom: 3px solid #000000;
            position: relative;
            margin-bottom: 20px;
        }
        .kop-border::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -5px;
            border-bottom: 1px solid #000000;
        }

        .avoid-break {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .paper-container {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .page-break-before {
                break-before: page;
                page-break-before: always;
            }
            .page-break {
                break-after: page;
                page-break-after: always;
            }
            tr {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body class="selection:bg-blue-600 selection:text-white">

    <!-- Top floating bar (Print Actions & Mode Switcher) -->
    <div class="no-print sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200 py-3 px-4 shadow-sm">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center space-x-3">
                <a href="{{ route('scan.reports', $baseQuery) }}" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-xs font-semibold text-slate-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Laporan</span>
                </a>

                <!-- Switcher Jenis Dokumen PDF -->
                <div class="inline-flex items-center p-1 rounded-lg bg-slate-100 border border-slate-200">
                    <a href="{{ route('scan.reports.print', array_merge($baseQuery, ['mode' => 'resmi'])) }}"
                       class="px-3 py-1 rounded-md text-xs font-bold transition-all {{ !$isFullReport ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        PDF Resmi (Ringkasan)
                    </a>
                    <a href="{{ route('scan.reports.print', array_merge($baseQuery, ['mode' => 'lengkap'])) }}"
                       class="px-3 py-1 rounded-md text-xs font-bold transition-all {{ $isFullReport ? 'bg-gov-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        Laporan Lengkap (Rincian Teknis)
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button onclick="window.print()" class="inline-flex items-center space-x-2 px-5 py-2 rounded-lg {{ $isFullReport ? 'bg-gov-700 hover:bg-gov-800' : 'bg-emerald-600 hover:bg-emerald-700' }} text-white text-xs font-bold shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak / Simpan {{ $isFullReport ? 'Laporan Lengkap' : 'PDF Resmi' }}</span>
                </button>
            </div>
        </div>
        <div class="max-w-5xl mx-auto mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
            @if($isFullReport)
                <span><strong class="text-gov-800">Mode Laporan Lengkap:</strong> Memuat ringkasan eksekutif, distribusi predikat, top kerentanan dominan, tabel rekapitulasi, serta <strong>lampiran rincian celah &amp; rekomendasi teknis per website OPD</strong>.</span>
            @else
                <span><strong class="text-emerald-700">Mode PDF Resmi (Ringkas):</strong> Memuat dokumen surat rekapitulasi eksekutif resmi, tabel kepatuhan seluruh OPD, rekomendasi umum, dan lembar pengesahan pimpinan.</span>
            @endif
        </div>
    </div>

    <!-- Paper Sheet Container -->
    <div class="paper-container">

        <!-- KOP SURAT RESMI PEMERINTAH KABUPATEN HULU SUNGAI UTARA -->
        <div class="flex items-center space-x-4 pb-3">
            <!-- Official Crest Emblem Logo Pemkab HSU -->
            <div class="w-24 h-24 shrink-0 flex items-center justify-center">
                <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab Hulu Sungai Utara" class="h-24 w-auto object-contain">
            </div>

            <!-- Kop Text -->
            <div class="flex-1 text-center formal-font leading-tight">
                <h3 class="text-lg font-bold tracking-wider text-black uppercase">
                    PEMERINTAH KABUPATEN HULU SUNGAI UTARA
                </h3>
                <h2 class="text-xl font-bold tracking-wide text-black uppercase mt-0.5">
                    DINAS KOMUNIKASI, INFORMATIKA DAN PERSANDIAN
                </h2>
                <p class="text-xs text-slate-700 mt-1 font-sans">
                    Jalan Basuki Rahmat No. 1 Amuntai, Kabupaten Hulu Sungai Utara, Kalimantan Selatan 71414
                </p>
                <p class="text-[11px] text-slate-600 font-sans mt-0.5">
                    Telepon: (0511) 6701100 &bull; Pos-el: diskominfo@hsu.go.id &bull; Laman Resmi: https://diskominfo.hsu.go.id
                </p>
            </div>
        </div>

        <!-- Garis Kop Ganda -->
        <div class="kop-border"></div>

        <!-- Judul Dokumen Laporan -->
        <div class="text-center mt-6 mb-6">
            @if($isFullReport)
                <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest bg-slate-100 text-slate-800 border border-slate-300 mb-1.5">
                    Dokumen Evaluasi Teknis &amp; Lampiran Temuan Lengkap
                </span>
                <h1 class="text-base sm:text-lg font-bold uppercase tracking-tight text-slate-900 formal-font underline decoration-1 underline-offset-4">
                    LAPORAN LENGKAP HASIL AUDIT TEKNIS KEAMANAN SIBER DAN RINCIAN KERENTANAN PORTAL WEB OPD
                </h1>
                <p class="text-xs font-mono font-bold text-slate-600 mt-1">
                    NOMOR DOKUMEN: 045.2 / {{ date('Y') }} / DISKOMINFO-HSU / SIBER-AUDIT-FULL
                </p>
            @else
                <h1 class="text-base sm:text-lg font-bold uppercase tracking-tight text-slate-900 formal-font underline decoration-1 underline-offset-4">
                    LAPORAN REKAPITULASI AUDIT KEAMANAN SIBER DAN KEPATUHAN PORTAL WEB OPD
                </h1>
                <p class="text-xs font-mono font-bold text-slate-600 mt-1">
                    NOMOR DOKUMEN: 045.2 / {{ date('Y') }} / DISKOMINFO-HSU / SIBER-REKAP
                </p>
            @endif
        </div>

        <!-- Metadata Pemeriksaan -->
        <div class="bg-slate-50 border border-slate-300 rounded-lg p-3.5 mb-6 text-xs">
            <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                <div>
                    <span class="text-slate-500 font-medium">Instansi Pelaksana:</span>
                    <span class="font-bold text-slate-900 block">Dinas Komunikasi, Informatika dan Persandian Kab. HSU</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Tanggal Diterbitkan:</span>
                    <span class="font-bold text-slate-900 block font-mono">{{ date('d F Y') }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Periode Audit:</span>
                    <span class="font-bold text-slate-900 block font-mono">
                        {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : 'Awal Sistem' }} 
                        s/d 
                        {{ request('end_date') ? date('d/m/Y', strtotime(request('end_date'))) : date('d/m/Y') }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Cakupan Kategori Instansi:</span>
                    <span class="font-bold text-slate-900 block">
                        {{ ($selectedGroup ?? 'all') !== 'all' ? $selectedGroup : 'Seluruh Website Resmi Pemkab HSU (*.hsu.go.id) & Instansi Vertikal' }}
                    </span>
                </div>
                @if($isFullReport)
                    <div>
                        <span class="text-slate-500 font-medium">Filter Predikat &amp; Pencarian:</span>
                        <span class="font-bold text-slate-900 block">
                            {{ $activeGradeLabel }}{{ request('search') ? ' • Kata Kunci: "' . request('search') . '"' : '' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-500 font-medium">Cakupan Parameter Uji:</span>
                        <span class="font-bold text-slate-900 block">7 Modul Pengujian Aktif (Headers, File Leak, Web Shell, SQLi, Auth, FIM, Versi)</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ringkasan Eksekutif (4 Indikator) -->
        <div class="grid grid-cols-4 gap-3 mb-5 text-center text-xs avoid-break">
            <div class="border border-slate-300 rounded-lg p-3 bg-white">
                <p class="text-[10px] uppercase font-bold text-slate-500">Total Audit</p>
                <p class="text-xl font-bold font-mono text-slate-900 mt-0.5">{{ $totalCount }}</p>
                <p class="text-[10px] text-slate-500">Domain Terperiksa</p>
            </div>
            <div class="border border-slate-300 rounded-lg p-3 bg-white">
                <p class="text-[10px] uppercase font-bold text-slate-500">Rata-Rata Indeks</p>
                <p class="text-xl font-bold font-mono text-blue-800 mt-0.5">{{ $avgScore }} / 100</p>
                <p class="text-[10px] text-slate-500">Indeks Keamanan</p>
            </div>
            <div class="border border-slate-300 rounded-lg p-3 bg-white">
                <p class="text-[10px] uppercase font-bold text-slate-500">Memenuhi Standar</p>
                <p class="text-xl font-bold font-mono text-emerald-700 mt-0.5">{{ $secureCount }}</p>
                <p class="text-[10px] text-emerald-700">Skor ≥ 80 (Aman)</p>
            </div>
            <div class="border border-slate-300 rounded-lg p-3 bg-white">
                <p class="text-[10px] uppercase font-bold text-slate-500">Perlu Remidiasi</p>
                <p class="text-xl font-bold font-mono text-rose-700 mt-0.5">{{ $criticalCount + $warningCount }}</p>
                <p class="text-[10px] text-rose-700">{{ $isFullReport ? $totalFindingsCount . ' Total Temuan Celah' : 'Celah Terdeteksi' }}</p>
            </div>
        </div>

        @if($isFullReport)
            <!-- Distribusi Predikat Keamanan (Khusus Laporan Lengkap) -->
            <div class="mb-6 border border-slate-300 rounded-lg p-3 bg-slate-50/70 text-[11px] avoid-break">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold uppercase tracking-wider text-slate-700 text-[10px]">Distribusi Predikat Keamanan Siber (Security Grade)</span>
                    <span class="font-mono text-[10px] text-slate-500">Total Akumulasi Temuan: <strong>{{ $totalFindingsCount }} Celah</strong></span>
                </div>
                <div class="grid grid-cols-4 gap-2 text-center">
                    <div class="bg-white border border-emerald-200 rounded px-2 py-1.5">
                        <span class="block font-mono font-bold text-emerald-800 text-sm">{{ $gradeACount }}</span>
                        <span class="text-[10px] text-emerald-700 font-semibold">Grade A+ (85–100)</span>
                    </div>
                    <div class="bg-white border border-blue-200 rounded px-2 py-1.5">
                        <span class="block font-mono font-bold text-blue-800 text-sm">{{ $gradeBCount }}</span>
                        <span class="text-[10px] text-blue-700 font-semibold">Grade B (70–84)</span>
                    </div>
                    <div class="bg-white border border-amber-200 rounded px-2 py-1.5">
                        <span class="block font-mono font-bold text-amber-800 text-sm">{{ $gradeCCount }}</span>
                        <span class="text-[10px] text-amber-700 font-semibold">Grade C (50–69)</span>
                    </div>
                    <div class="bg-white border border-rose-200 rounded px-2 py-1.5">
                        <span class="block font-mono font-bold text-rose-800 text-sm">{{ $gradeFCount }}</span>
                        <span class="text-[10px] text-rose-700 font-semibold">Grade F (&lt;50 Kritis)</span>
                    </div>
                </div>
            </div>

            <!-- Bagian I (Laporan Lengkap): Analisis Top 5 Kerentanan Dominan -->
            <div class="mb-6 avoid-break">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-2 border-b border-slate-300 pb-1 formal-font">
                    I. Analisis Kerentanan Paling Dominan pada Portal Web OPD
                </h4>

                @if(count($topVulnerabilities) > 0)
                    <table class="w-full text-left text-[11px] border-collapse border border-slate-400">
                        <thead>
                            <tr class="bg-slate-100 text-slate-900 uppercase font-bold text-[10px] text-center">
                                <th class="border border-slate-400 py-1.5 px-2 w-8">No</th>
                                <th class="border border-slate-400 py-1.5 px-3 text-left">Jenis Celah / Parameter Kerentanan</th>
                                <th class="border border-slate-400 py-1.5 px-2 w-20">Tingkat Risiko</th>
                                <th class="border border-slate-400 py-1.5 px-2 w-24">Jumlah Kasus</th>
                                <th class="border border-slate-400 py-1.5 px-2 w-24">Rasio Paparan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $vIdx = 1; @endphp
                            @foreach($topVulnerabilities as $vulnName => $count)
                                @php
                                    $pct = round(($count / max(1, $totalCount)) * 100);
                                    [$sevLabel, $remShort] = $getRemediation($vulnName);
                                @endphp
                                <tr class="{{ $vIdx % 2 == 0 ? 'bg-slate-50' : 'bg-white' }}">
                                    <td class="border border-slate-400 py-1.5 px-2 text-center font-mono">{{ $vIdx++ }}</td>
                                    <td class="border border-slate-400 py-1.5 px-3 font-mono font-bold text-slate-900">{{ $vulnName }}</td>
                                    <td class="border border-slate-400 py-1.5 px-2 text-center text-[10px] font-bold {{ $sevLabel === 'Kritis' ? 'text-rose-800' : ($sevLabel === 'Tinggi' ? 'text-amber-800' : 'text-slate-700') }}">
                                        {{ $sevLabel }}
                                    </td>
                                    <td class="border border-slate-400 py-1.5 px-2 text-center font-mono font-bold text-rose-800">{{ $count }} Domain</td>
                                    <td class="border border-slate-400 py-1.5 px-2 text-center font-mono">{{ $pct }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="border border-emerald-300 bg-emerald-50/50 rounded p-3 text-[11px] text-emerald-800">
                        Tidak ditemukan kerentanan aktif pada seluruh sampel portal web OPD yang diaudit dalam periode ini.
                    </div>
                @endif
            </div>
        @endif

        <!-- Tabel Rekapitulasi Utama -->
        <div class="mb-6">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-2 border-b border-slate-300 pb-1 formal-font">
                {{ $isFullReport ? 'II. Tabel Rekapitulasi Indeks Kepatuhan Seluruh Portal Web OPD' : 'I. Tabel Status Kepatuhan & Kerentanan Portal Web OPD' }}
            </h4>

            <table class="w-full text-left text-[11px] border-collapse border border-slate-400">
                <thead>
                    <tr class="bg-slate-100 text-slate-900 uppercase font-bold text-[10px] text-center">
                        <th class="border border-slate-400 py-2 px-2 w-8">No</th>
                        <th class="border border-slate-400 py-2 px-2.5 text-left">Nama Instansi / SKPD</th>
                        <th class="border border-slate-400 py-2 px-2.5 text-left">Alamat Domain (URL)</th>
                        <th class="border border-slate-400 py-2 px-2 w-12">Skor</th>
                        <th class="border border-slate-400 py-2 px-2 w-20">Predikat</th>
                        <th class="border border-slate-400 py-2 px-1.5 w-14">Lolos</th>
                        <th class="border border-slate-400 py-2 px-1.5 w-14">Celah</th>
                        <th class="border border-slate-400 py-2 px-2 w-24">Waktu Audit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allScans as $i => $item)
                        @php
                            $host = strtolower(parse_url($item->url, PHP_URL_HOST) ?? '');
                            $agency = $agencyMap[$host]['name'] ?? $host;
                            $agencyGroup = $agencyMap[$host]['group'] ?? 'Website Daerah';
                            $score = $item->score;
                            if ($score >= 85) {
                                $grade = 'A+ (Optimal)';
                            } elseif ($score >= 70) {
                                $grade = 'B (Cukup)';
                            } elseif ($score >= 50) {
                                $grade = 'C (Waspada)';
                            } else {
                                $grade = 'F (Kritis)';
                            }
                            $passed = count($item->header_results ?? []);
                            $failed = count($item->file_results ?? []);
                        @endphp
                        <tr class="{{ $i % 2 == 1 ? 'bg-slate-50' : 'bg-white' }}">
                            <td class="border border-slate-400 py-1.5 px-2 text-center font-mono">{{ $i + 1 }}</td>
                            <td class="border border-slate-400 py-1.5 px-2.5">
                                <span class="font-semibold text-slate-900 block leading-snug">{{ $agency }}</span>
                                @if($isFullReport)
                                    <span class="text-[9px] text-slate-500 block">{{ $agencyGroup }}</span>
                                @endif
                            </td>
                            <td class="border border-slate-400 py-1.5 px-2.5 font-mono text-[10px] text-slate-700 break-all">{{ $item->url }}</td>
                            <td class="border border-slate-400 py-1.5 px-2 text-center font-mono font-bold">{{ $score }}</td>
                            <td class="border border-slate-400 py-1.5 px-2 text-center text-[10px] font-bold">{{ $grade }}</td>
                            <td class="border border-slate-400 py-1.5 px-1.5 text-center font-mono text-emerald-800">{{ $passed }}</td>
                            <td class="border border-slate-400 py-1.5 px-1.5 text-center font-mono {{ $failed > 0 ? 'text-rose-800 font-bold' : 'text-slate-500' }}">{{ $failed }}</td>
                            <td class="border border-slate-400 py-1.5 px-2 text-center font-mono text-[10px]">
                                {{ $item->created_at ? ($isFullReport ? $item->created_at->format('d/m/Y H:i') : $item->created_at->format('d/m/Y')) : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border border-slate-400 py-4 text-center text-slate-500">
                                Tidak ada data yang memenuhi kriteria filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($isFullReport && count($allScans) > 0)
            <!-- BAGIAN III (KHUSUS LAPORAN LENGKAP): LAMPIRAN RINCIAN TEKNIS PER WEBSITE OPD -->
            <div class="page-break-before pt-2 mb-8">
                <div class="border-b-2 border-slate-800 pb-2 mb-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 formal-font">
                        III. Lampiran Rincian Teknis Temuan Celah &amp; Rekomendasi Perbaikan per Website OPD
                    </h4>
                    <p class="text-[10px] text-slate-600 mt-0.5">
                        Uraian lengkap hasil pemeriksaan parameter keamanan, rincian kerentanan teridentifikasi, serta panduan remidiasi teknis pada masing-masing domain.
                    </p>
                </div>

                <div class="space-y-4">
                    @foreach($allScans as $idx => $scan)
                        @php
                            $host = strtolower(parse_url($scan->url, PHP_URL_HOST) ?? '');
                            $agencyName = $agencyMap[$host]['name'] ?? $host;
                            $agencyGroup = $agencyMap[$host]['group'] ?? 'Website Daerah';
                            $score = $scan->score;

                            if ($score >= 85) {
                                $gradeText = 'A+ (Optimal)';
                                $riskText = 'Risiko Rendah';
                                $scoreBadge = 'bg-emerald-50 text-emerald-800 border-emerald-300';
                            } elseif ($score >= 70) {
                                $gradeText = 'B (Cukup Baik)';
                                $riskText = 'Risiko Moderat Rendah';
                                $scoreBadge = 'bg-blue-50 text-blue-800 border-blue-300';
                            } elseif ($score >= 50) {
                                $gradeText = 'C (Waspada)';
                                $riskText = 'Risiko Moderat';
                                $scoreBadge = 'bg-amber-50 text-amber-800 border-amber-300';
                            } else {
                                $gradeText = 'F (Kritis)';
                                $riskText = 'Risiko Tinggi';
                                $scoreBadge = 'bg-rose-50 text-rose-800 border-rose-300';
                            }

                            $failedList = $scan->file_results ?? [];
                            $passedList = $scan->header_results ?? [];
                        @endphp

                        <div class="border border-slate-400 rounded-lg overflow-hidden bg-white avoid-break">
                            <!-- Card Header Instansi -->
                            <div class="bg-slate-100 border-b border-slate-300 px-3.5 py-2.5 flex items-start justify-between gap-3">
                                <div>
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="inline-flex items-center justify-center px-1.5 py-0.5 rounded bg-slate-800 text-white font-mono text-[10px] font-bold">
                                            #{{ $idx + 1 }}
                                        </span>
                                        <h5 class="text-xs font-bold text-slate-900">{{ $agencyName }}</h5>
                                        <span class="text-[10px] px-2 py-0.5 rounded bg-white border border-slate-300 text-slate-600 font-medium">
                                            {{ $agencyGroup }}
                                        </span>
                                    </div>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-0.5 text-[10px] text-slate-600 font-mono">
                                        <span>URL: <strong class="text-slate-900">{{ $scan->url }}</strong></span>
                                        <span>&bull;</span>
                                        <span>Waktu Uji: {{ $scan->created_at ? $scan->created_at->format('d/m/Y H:i') . ' WITA' : '-' }}</span>
                                    </div>
                                </div>

                                <div class="text-right shrink-0">
                                    <span class="inline-block px-2.5 py-1 rounded border text-[11px] font-mono font-bold {{ $scoreBadge }}">
                                        Skor: {{ $score }}/100 &bull; {{ $gradeText }}
                                    </span>
                                    <span class="block text-[9px] text-slate-500 font-semibold mt-0.5 uppercase tracking-wider">
                                        {{ $riskText }} ({{ count($passedList) }} Lolos / {{ count($failedList) }} Celah)
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body: Temuan Celah & Proteksi Aktif -->
                            <div class="p-3 space-y-2.5 text-[10.5px]">
                                @if(count($failedList) > 0)
                                    <div>
                                        <p class="font-bold uppercase tracking-wider text-rose-800 text-[10px] mb-1.5">
                                            A. Rincian Celah Kerentanan Terdeteksi ({{ count($failedList) }} Temuan):
                                        </p>
                                        <table class="w-full text-left border-collapse border border-slate-300 text-[10px]">
                                            <thead>
                                                <tr class="bg-slate-50 text-slate-700 font-bold">
                                                    <th class="border border-slate-300 py-1 px-2 w-44">Parameter &amp; Kategori</th>
                                                    <th class="border border-slate-300 py-1 px-1.5 text-center w-16">Tingkat</th>
                                                    <th class="border border-slate-300 py-1 px-2">Detail Temuan &amp; Rekomendasi Remidiasi Teknis</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($failedList as $fItem)
                                                    @php
                                                        $fName = $fItem['name'] ?? 'Kerentanan Konfigurasi';
                                                        $fDesc = $fItem['desc'] ?? '-';
                                                        $fMinus = $fItem['minus'] ?? '0';
                                                        $fCatKey = $fItem['category'] ?? '';
                                                        $fCatLabel = $categoryLabels[$fCatKey] ?? 'Keamanan Web';
                                                        [$fSev, $fRem] = $getRemediation($fName);
                                                    @endphp
                                                    <tr>
                                                        <td class="border border-slate-300 py-1.5 px-2 align-top">
                                                            <span class="font-mono font-bold text-slate-900 block">{{ $fName }}</span>
                                                            <span class="text-[9px] text-slate-500 block">{{ $fCatLabel }}</span>
                                                            <span class="inline-block mt-0.5 font-mono text-[9px] font-bold text-rose-700">Penalti: {{ $fMinus }} Poin</span>
                                                        </td>
                                                        <td class="border border-slate-300 py-1.5 px-1.5 text-center align-top font-bold {{ $fSev === 'Kritis' ? 'text-rose-700 bg-rose-50/50' : ($fSev === 'Tinggi' ? 'text-amber-800 bg-amber-50/50' : 'text-slate-700') }}">
                                                            {{ $fSev }}
                                                        </td>
                                                        <td class="border border-slate-300 py-1.5 px-2 align-top leading-snug">
                                                            <p class="text-slate-800"><strong>Temuan:</strong> {{ $fDesc }}</p>
                                                            <p class="text-slate-600 mt-1"><strong>Solusi:</strong> {{ $fRem }}</p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="bg-emerald-50/70 border border-emerald-200 rounded px-2.5 py-1.5 text-emerald-800 text-[10px]">
                                        <strong>Nihil Kerentanan:</strong> Seluruh parameter pengujian keamanan telah terpenuhi dengan baik pada domain ini.
                                    </div>
                                @endif

                                <!-- Daftar Proteksi Aktif -->
                                <div>
                                    <p class="font-bold uppercase tracking-wider text-emerald-800 text-[10px] mb-1">
                                        {{ count($failedList) > 0 ? 'B.' : 'A.' }} Parameter Proteksi Terverifikasi Aktif ({{ count($passedList) }} Parameter):
                                    </p>
                                    @if(count($passedList) > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($passedList as $pItem)
                                                @php
                                                    $pName = is_string($pItem) ? $pItem : ($pItem['name'] ?? 'Parameter Aman');
                                                @endphp
                                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-emerald-50 border border-emerald-200 text-emerald-800 font-mono text-[9.5px] font-semibold">
                                                    ✓ {{ $pName }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-[10px] text-slate-500 italic">Belum ada parameter proteksi yang terverifikasi lolos.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Rekomendasi Umum Pengamanan Sistem Siber -->
        <div class="mb-8 text-xs avoid-break">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-2 border-b border-slate-300 pb-1 formal-font">
                {{ $isFullReport ? 'IV. Rekomendasi Strategis Penguatan Keamanan Sistem Informasi Daerah' : 'II. Rekomendasi Penguatan Keamanan Sistem Informasi Daerah' }}
            </h4>
            <ol class="list-decimal list-inside space-y-1 text-slate-700 leading-relaxed pl-1 text-[11px]">
                <li><strong>Penerapan HTTP Security Headers:</strong> Setiap server OPD wajib melengkapi konfigurasi <em>Content-Security-Policy (CSP)</em>, <em>Strict-Transport-Security (HSTS)</em>, dan <em>X-Frame-Options</em> guna menangkal serangan XSS, pembajakan klik, dan pemaksaan enkripsi HTTPS.</li>
                <li><strong>Proteksi File Sensitif &amp; Direktori:</strong> Menutup akses langsung publik terhadap file konfigurasi lingkungan (seperti <code>.env</code>, <code>web.config</code>, direktori <code>.git</code>, dan arsip backup database).</li>
                <li><strong>Penguatan Mekanisme Autentikasi:</strong> Menerapkan pembatasan laju percobaan masuk (<em>Rate Limiting</em>) dan verifikasi CAPTCHA pada portal administrasi CMS OPD untuk mencegah serangan <em>Brute-Force</em>.</li>
                <li><strong>Pemutakhiran Patch Berkala:</strong> Melakukan pembaruan rutin pada sistem manajemen konten (CMS) serta modul framework guna menutup celah kerentanan yang telah dipublikasikan (CVE).</li>
            </ol>
        </div>

        <!-- LEMBAR PENGESAHAN DAN TANDA TANGAN RESMI -->
        <div class="mt-8 pt-4 text-xs text-slate-800 avoid-break">
            <div class="flex justify-between items-start">
                <!-- Kolom Kiri: Penguji / Mahasiswa PKL -->
                <div class="text-center w-64">
                    <p class="text-slate-600">Dibuat dan Diuji oleh:</p>
                    <p class="font-bold text-slate-900 mt-0.5">Petugas Audit Siber / Mahasiswa PKL</p>
                    <div class="h-20 flex items-center justify-center">
                        <span class="text-[10px] text-slate-400 italic">( Tanda Tangan )</span>
                    </div>
                    <p class="font-bold text-slate-900 underline decoration-1 underline-offset-2">
                        Muhamad Bayu Ridhani
                    </p>
                    <p class="text-[11px] text-slate-600 font-mono mt-0.5">
                        NIM: 2310010477 / FTI UNISKA
                    </p>
                </div>

                <!-- Kolom Kanan: Pembimbing / Kepala Bidang Diskominfo -->
                <div class="text-center w-72">
                    <p class="text-slate-600">Amuntai, {{ date('d F Y') }}</p>
                    <p class="font-bold text-slate-900 mt-0.5">
                        Mengetahui,<br>
                        Kepala Bidang Penyelenggaraan E-Government<br>
                        Dinas Kominfo Kab. Hulu Sungai Utara
                    </p>
                    <div class="h-16 flex items-center justify-center">
                        <span class="text-[10px] text-slate-400 italic">( Tanda Tangan &amp; Cap Dinas )</span>
                    </div>
                    <p class="font-bold text-slate-900 underline decoration-1 underline-offset-2">
                        Muzain, SE, M.M.
                    </p>
                    <p class="text-[11px] text-slate-600 font-mono mt-0.5">
                        NIP. 
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Catatan Otomatis -->
        <div class="mt-12 pt-3 border-t border-slate-200 text-[10px] text-slate-400 flex justify-between items-center font-mono">
            <span>Dicetak secara otomatis melalui Sistem HSU Sentinel v3.0 ({{ $isFullReport ? 'Mode Laporan Teknis Lengkap' : 'Mode Ringkasan Resmi' }})</span>
            <span>Diskominfo Kab. Hulu Sungai Utara</span>
        </div>

    </div>

</body>
</html>
