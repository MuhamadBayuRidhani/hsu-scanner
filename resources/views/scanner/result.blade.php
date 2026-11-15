<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Audit Keamanan | {{ $history->url }} - HSU Sentinel</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-hsu.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
        body {
            background-color: #f8fafc;
            color: #1e293b;
        }

        .clean-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease-in-out;
        }

        .clean-card:hover {
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.08), 0 2px 4px -2px rgba(15, 23, 42, 0.05);
            border-color: #cbd5e1;
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #0f172a !important;
                font-size: 12px;
            }
            .no-print {
                display: none !important;
            }
            .clean-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                page-break-inside: avoid;
            }
            .print-break-inside-avoid {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col font-sans selection:bg-blue-600 selection:text-white antialiased">

    <!-- Top Gov Banner Strip -->
    <div class="h-1 bg-gradient-to-r from-red-600 via-white to-blue-700 w-full no-print"></div>

    <!-- Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm no-print">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <div class="flex items-center space-x-3 min-w-0">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 border border-slate-200 transition-colors shrink-0" title="Kembali ke Beranda">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div class="flex items-center space-x-2.5 min-w-0">
                    <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab HSU" class="h-8 w-auto object-contain shrink-0">
                    <span class="font-extrabold tracking-tight text-navy-900 text-sm shrink-0">HSU SENTINEL</span>
                    <span class="hidden sm:inline text-slate-300">/</span>
                    <span class="hidden sm:inline text-xs font-semibold text-slate-500 truncate">Hasil Audit Keamanan</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-2 shrink-0">
                <a href="{{ route('scan.reports') }}" class="inline-flex items-center space-x-1.5 px-3 sm:px-3.5 py-2 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-700 shadow-sm hover:border-slate-400 transition-all">
                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="hidden sm:inline">Rekap Laporan</span>
                </a>

                <button onclick="window.print()" class="inline-flex items-center space-x-1.5 px-3 sm:px-3.5 py-2 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-700 shadow-sm hover:border-slate-400 transition-all">
                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span class="hidden sm:inline">Cetak / PDF</span>
                </button>

                <form id="rescanForm" action="{{ route('scan.process') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="url" value="{{ $history->url }}">
                    <button type="submit" id="rescanBtn" class="inline-flex items-center space-x-1.5 px-3.5 sm:px-4 py-2 rounded-lg bg-gov-700 hover:bg-gov-800 text-white text-xs font-bold transition-all shadow-sm hover:shadow">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Audit Ulang</span>
                    </button>
                </form>

                <a href="{{ route('account.index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition-colors" title="Manajemen Akun & User">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 py-8 w-full">

        <!-- Formal Kop Surat Visible Only on Print -->
        <div class="hidden print:block pb-4 mb-6 border-b-2 border-black">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab HSU" class="h-20 w-auto object-contain">
                </div>
                <div class="flex-1 text-center leading-tight">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-black">
                        PEMERINTAH KABUPATEN HULU SUNGAI UTARA
                    </h3>
                    <h2 class="text-sm font-bold uppercase tracking-wide text-black mt-0.5">
                        DINAS KOMUNIKASI, INFORMATIKA DAN PERSANDIAN
                    </h2>
                    <p class="text-[10px] text-slate-700 mt-1">
                        Jalan Basuki Rahmat No. 1 Amuntai, Kalimantan Selatan 71414 &bull; Pos-el: diskominfo@hsu.go.id
                    </p>
                    <p class="text-[11px] font-bold text-slate-900 mt-1 uppercase underline underline-offset-2">
                        LEMBAR HASIL AUDIT KEAMANAN SIBER DAN KEPATUHAN PORTAL WEB
                    </p>
                </div>
            </div>
        </div>

        @php
            $score = $history->score;
            $failedItems = $history->file_results ?? [];
            $passedItems = $history->header_results ?? [];

            $passedCount = count($passedItems);
            $failedCount = count($failedItems);
            $totalChecks = $failedCount + $passedCount;

            if ($score >= 85) {
                $grade = 'A+';
                $statusLabel = 'Keamanan Sangat Baik';
                $statusDesc = 'Konfigurasi keamanan server target telah memenuhi standar optimal dan memiliki perlindungan berlapis.';
                $statusBadgeClass = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                $statusDot = 'bg-emerald-500';
                $ringColor = '#059669';
                $scoreColor = 'text-emerald-700';
                $riskLevel = 'Rendah';
                $riskColor = 'text-emerald-700 bg-emerald-50 border-emerald-200';
            } elseif ($score >= 70) {
                $grade = 'B';
                $statusLabel = 'Kepatuhan Cukup Baik';
                $statusDesc = 'Sebagian besar proteksi aktif, namun beberapa konfigurasi penting disarankan untuk dilengkapi.';
                $statusBadgeClass = 'bg-blue-50 text-blue-800 border-blue-200';
                $statusDot = 'bg-blue-500';
                $ringColor = '#0284c7';
                $scoreColor = 'text-blue-700';
                $riskLevel = 'Moderat Rendah';
                $riskColor = 'text-blue-700 bg-blue-50 border-blue-200';
            } elseif ($score >= 50) {
                $grade = 'C';
                $statusLabel = 'Perlu Perhatian';
                $statusDesc = 'Ditemukan celah keamanan atau parameter proteksi yang belum diaktifkan sehingga perlu evaluasi berkala.';
                $statusBadgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
                $statusDot = 'bg-amber-500';
                $ringColor = '#d97706';
                $scoreColor = 'text-amber-700';
                $riskLevel = 'Moderat';
                $riskColor = 'text-amber-700 bg-amber-50 border-amber-200';
            } else {
                $grade = 'F';
                $statusLabel = 'Kritis & Rentan';
                $statusDesc = 'Terdapat celah serius atau minim pertahanan standar. Diperlukan tindakan perbaikan konfigurasi segera.';
                $statusBadgeClass = 'bg-rose-50 text-rose-800 border-rose-200';
                $statusDot = 'bg-rose-500';
                $ringColor = '#e11d48';
                $scoreColor = 'text-rose-700';
                $riskLevel = 'Tinggi';
                $riskColor = 'text-rose-700 bg-rose-50 border-rose-200';
            }

            // Hitung persentase offset lingkaran SVG (keliling = 2 * PI * r = 2 * 3.14159 * 42 ≈ 264)
            $circumference = 264;
            $dashOffset = $circumference - (($score / 100) * $circumference);

            // Definisikan label kategori
            $categoryLabels = [
                'ssl_tls'               => ['label' => 'Validitas SSL/TLS & Redirect HTTPS', 'color' => 'teal'],
                'header_security'       => ['label' => 'Security Headers Modern', 'color' => 'blue'],
                'cookie_security'       => ['label' => 'Proteksi Flag Cookie', 'color' => 'cyan'],
                'sensitive_leak'        => ['label' => 'Sensitive Data Leak', 'color' => 'rose'],
                'upload_webshell'       => ['label' => 'File Upload & Web Shell', 'color' => 'orange'],
                'sqli_sanitization'     => ['label' => 'SQL Injection & Input Sanitization', 'color' => 'red'],
                'auth_bruteforce'       => ['label' => 'Authentication & Brute-Force', 'color' => 'indigo'],
                'fim'                   => ['label' => 'File Integrity Monitoring', 'color' => 'amber'],
                'dependency_framework'  => ['label' => 'Dependency & Framework', 'color' => 'purple'],
            ];

            // Kelompokkan failed items by category
            $failedByCategory = [];
            foreach ($failedItems as $f) {
                $cat = $f['category'] ?? 'unknown';
                if (!isset($failedByCategory[$cat])) {
                    $failedByCategory[$cat] = [];
                }
                $failedByCategory[$cat][] = $f;
            }

            // Kelompokkan passed items by category
            $passedByCategory = [];
            foreach ($passedItems as $p) {
                if (is_string($p)) {
                    $passedByCategory['legacy'][] = $p;
                } else {
                    $cat = $p['category'] ?? 'unknown';
                    if (!isset($passedByCategory[$cat])) {
                        $passedByCategory[$cat] = [];
                    }
                    $passedByCategory[$cat][] = $p;
                }
            }

            function getRemediation($name, $category = '') {
                if (str_contains($name, 'Sensitive Data')) {
                    return ['Kritis', 'Segera kunci atau hapus file sensitif (.env, backup.zip, .git) dari DocumentRoot web. Konfigurasikan rule pada web server untuk memblokir akses ke file tersembunyi.', 'OWASP A01:2021 – Broken Access Control'];
                } elseif (str_contains($name, 'SSL/TLS Certificate')) {
                    return ['Tinggi', 'Pasang sertifikat SSL/TLS resmi dari Certificate Authority (CA) terpercaya (seperti Let\'s Encrypt / DigiCert), perbarui sertifikat yang kedaluwarsa, dan pastikan rantai sertifikat (chain) lengkap.', 'OWASP A02:2021 – Cryptographic Failures'];
                } elseif (str_contains($name, 'Deprecated TLS')) {
                    return ['Sedang', 'Nonaktifkan protokol enkripsi usang (TLSv1.0 dan TLSv1.1) pada konfigurasi web server (Nginx/Apache/IIS) dan hanya izinkan protokol modern TLSv1.2 serta TLSv1.3.', 'OWASP A02:2021 – Cryptographic Failures'];
                } elseif (str_contains($name, 'HTTP to HTTPS Redirect')) {
                    return ['Sedang', 'Tambahkan aturan pengalihan permanen (HTTP 301 Redirect) pada konfigurasi virtual host port 80 agar setiap trafik HTTP otomatis dialihkan ke HTTPS.', 'OWASP A02:2021 – Cryptographic Failures'];
                } elseif (str_contains($name, 'Content-Security-Policy')) {
                    return ['Tinggi', 'Tambahkan header Content-Security-Policy untuk mengatur sumber konten yang sah, mencegah serangan injeksi skrip (XSS) dan pemuatan resource tidak aman.', 'OWASP A03:2021 (XSS) & Secure Headers'];
                } elseif (str_contains($name, 'Strict-Transport-Security')) {
                    return ['Sedang', 'Tambahkan header Strict-Transport-Security (HSTS) dengan max-age minimal 1 tahun agar peramban selalu mengunci sambungan ke protokol HTTPS.', 'OWASP A02:2021 – Cryptographic Failures'];
                } elseif (str_contains($name, 'X-Frame-Options')) {
                    return ['Sedang', 'Tambahkan header X-Frame-Options: SAMEORIGIN untuk melindungi web dari pembajakan frame atau antarmuka (Clickjacking).', 'OWASP A05:2021 & Secure Headers'];
                } elseif (str_contains($name, 'X-Content-Type-Options')) {
                    return ['Rendah', 'Tambahkan header X-Content-Type-Options: nosniff untuk mencegah peramban melakukan penafsiran MIME type secara otomatis (MIME-sniffing).', 'OWASP A05:2021 & Secure Headers'];
                } elseif (str_contains($name, 'Referrer-Policy')) {
                    return ['Rendah', 'Tambahkan header Referrer-Policy: strict-origin-when-cross-origin agar parameter URL sensitif tidak bocor melalui header Referer ke domain eksternal.', 'OWASP Secure Headers Project'];
                } elseif (str_contains($name, 'Permissions-Policy')) {
                    return ['Rendah', 'Tambahkan header Permissions-Policy (misalnya camera=(), microphone=(), geolocation=()) untuk membatasi penyalahgunaan fitur perangkat keras peramban.', 'OWASP Secure Headers Project'];
                } elseif (str_contains($name, 'Cookie Flags')) {
                    return ['Sedang', 'Pastikan setiap cookie sesi yang dikirim server mengaktifkan atribut Secure (hanya dikirim via HTTPS), HttpOnly (tidak bisa diakses JavaScript/XSS), dan SameSite=Lax/Strict (proteksi CSRF).', 'OWASP A05:2021 – Security Misconfiguration'];
                } elseif (str_contains($name, 'Web Shell')) {
                    return ['Kritis', 'SEGERA isolasi server dan hapus file web shell teridentifikasi! Lakukan audit integritas seluruh direktori web dan periksa log akses web server.', 'OWASP A08:2021 – Software & Data Integrity'];
                } elseif (str_contains($name, 'Unvalidated File Upload')) {
                    return ['Sedang', 'Batasi tipe file pada form upload menggunakan atribut accept dan lakukan validasi ketat (ekstensi, tipe MIME, isi file) di sisi server sebelum disimpan.', 'OWASP A04:2021 – Insecure Design'];
                } elseif (str_contains($name, 'SQL Injection')) {
                    return ['Kritis', 'Terapkan Prepared Statement / Parameterized Queries pada semua query database. Hindari merangkai parameter masukan pengguna langsung ke string SQL.', 'OWASP A03:2021 – Injection'];
                } elseif (str_contains($name, 'Brute-Force')) {
                    return ['Tinggi', 'Terapkan pembatasan percobaan login (Rate Limiting) dan pasang verifikasi CAPTCHA (Turnstile / reCAPTCHA) pada form autentikasi.', 'OWASP A07:2021 – Auth Failures'];
                } elseif (str_contains($name, 'Debug') || str_contains($name, 'Config Files')) {
                    return ['Tinggi', 'Hapus atau batasi hak akses publik ke file instalasi, debug, atau informasi server seperti phpinfo.php, readme.html, dan license.txt.', 'OWASP A05:2021 – Security Misconfiguration'];
                } elseif (str_contains($name, 'Framework') || str_contains($name, 'Version')) {
                    return ['Sedang', 'Sembunyikan header X-Powered-By, versi Server, dan meta generator CMS agar penyerang tidak dapat memetakan kelemahan versi spesifik.', 'OWASP A06:2021 – Vulnerable Components'];
                }
                return ['Sedang', 'Terapkan konfigurasi pengerasan sistem (hardening) yang sesuai standar best practice keamanan.', 'OWASP A05:2021 – Security Misconfiguration'];
            }

            function getPassedBenefit($name) {
                if (str_contains($name, 'SSL/TLS Valid')) {
                    return 'Sertifikat SSL/TLS terverifikasi valid oleh CA dan menggunakan versi protokol enkripsi modern.';
                } elseif (str_contains($name, 'HTTP to HTTPS Redirect')) {
                    return 'Akses melalui HTTP biasa (port 80) otomatis dialihkan secara aman ke protokol HTTPS.';
                } elseif ($name === 'Content-Security-Policy') {
                    return 'Kebijakan sumber konten aktif (Perlindungan terhadap serangan Cross-Site Scripting).';
                } elseif ($name === 'Strict-Transport-Security') {
                    return 'Browser diwajibkan selalu menggunakan koneksi terenkripsi HTTPS secara ketat.';
                } elseif ($name === 'X-Frame-Options') {
                    return 'Proteksi pembajakan klik dalam iFrame (Clickjacking) aktif.';
                } elseif ($name === 'X-Content-Type-Options') {
                    return 'Pencegahan MIME-sniffing aktif untuk melindungi file berformat teks/skrip.';
                } elseif ($name === 'Referrer-Policy') {
                    return 'Kebijakan pengiriman informasi Referer antar-domain terkendali dengan aman.';
                } elseif ($name === 'Permissions-Policy') {
                    return 'Pembatasan izin akses fitur API sensitif peramban (kamera, mikrofon, lokasi) telah aktif.';
                } elseif (str_contains($name, 'Cookie Security')) {
                    return 'Cookie yang dibuat server telah dilengkapi atribut proteksi (Secure, HttpOnly, SameSite).';
                } elseif (str_contains($name, 'Sensitive File')) {
                    return 'File sensitif (.env, .git, backup arsip) terlindungi dan tidak bocor ke publik.';
                } elseif (str_contains($name, 'File Upload') || str_contains($name, 'Web Shell')) {
                    return 'Tidak terdeteksi file backdoor web shell maupun celah upload tanpa pembatasan.';
                } elseif (str_contains($name, 'SQL Injection') || str_contains($name, 'Input Sanitization')) {
                    return 'Tidak ditemukan celah SQL Injection pada parameter yang diuji.';
                } elseif (str_contains($name, 'Authentication') || str_contains($name, 'Brute-Force')) {
                    return 'Proteksi percobaan login aktif atau tidak ditemukan endpoint rentan brute-force.';
                } elseif (str_contains($name, 'File Integrity') || str_contains($name, 'FIM')) {
                    return 'Tidak ada file konfigurasi debug atau informasi sensitif yang terekspos.';
                } elseif (str_contains($name, 'Dependency') || str_contains($name, 'Framework')) {
                    return 'Informasi versi server dan framework terlindungi dari pemetaan publik.';
                }
                return 'Parameter telah terkonfigurasi dengan standar keamanan yang baik.';
            }
        @endphp

        <!-- Executive Summary Card (Clean White) -->
        <div class="clean-card rounded-2xl p-6 sm:p-8 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                
                <!-- Left: Target URL & Scope -->
                <div class="space-y-4 max-w-2xl">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $statusBadgeClass }}">
                            <span class="w-2 h-2 rounded-full {{ $statusDot }}"></span>
                            <span>{{ $statusLabel }}</span>
                        </span>

                        @if(str_starts_with($history->url, 'https://'))
                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>HTTPS (Aman)</span>
                            </span>
                        @else
                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>HTTP (Tidak Terenkripsi)</span>
                            </span>
                        @endif
                    </div>

                    <div>
                        @if(isset($agency) && !empty($agency['name']))
                            <div class="mb-1">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-gov-700 bg-gov-50 px-2 py-0.5 rounded border border-gov-200 inline-block mb-1">
                                    {{ $agency['group'] ?? 'Organisasi Perangkat Daerah' }}
                                </span>
                                <h2 class="text-lg sm:text-xl font-extrabold text-navy-900 leading-tight">
                                    {{ $agency['name'] }}
                                </h2>
                            </div>
                        @endif
                        <div class="flex items-center space-x-2">
                            <h1 id="targetUrlText" class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight break-all font-mono">
                                {{ $history->url }}
                            </h1>
                            <button onclick="copyUrl()" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition-colors" title="Salin URL Target">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                            <a href="{{ $history->url }}" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg hover:bg-slate-100 transition-colors" title="Kunjungi Situs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                            {{ $statusDesc }}
                        </p>
                    </div>

                    <!-- Metadata Items -->
                    <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-xs text-slate-500 pt-1">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Waktu Audit: <strong class="text-slate-700 font-medium">{{ $history->created_at ? $history->created_at->format('d M Y, H:i') . ' WITA' : 'Baru saja' }}</strong></span>
                        </div>
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Total Filter: <strong class="text-slate-700 font-medium">{{ $totalChecks }} Kategori Uji</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Right: Circular Score Gauge & Grade -->
                <div class="flex items-center justify-start lg:justify-end space-x-6 shrink-0 border-t lg:border-t-0 lg:border-l border-slate-200 pt-6 lg:pt-0 lg:pl-8">
                    
                    <!-- Circular Gauge on White -->
                    <div class="relative w-28 h-28 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <!-- Background Track -->
                            <circle cx="50" cy="50" r="42" stroke="#f1f5f9" stroke-width="7" fill="transparent" />
                            <!-- Colored Progress Stroke -->
                            <circle 
                                cx="50" 
                                cy="50" 
                                r="42" 
                                stroke="{{ $ringColor }}" 
                                stroke-width="7" 
                                stroke-dasharray="{{ $circumference }}" 
                                stroke-dashoffset="{{ $dashOffset }}" 
                                stroke-linecap="round" 
                                fill="transparent" 
                                class="transition-all duration-1000 ease-out"
                            />
                        </svg>
                        
                        <!-- Center Score Value -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span class="text-3xl font-extrabold font-mono {{ $scoreColor }} leading-none">
                                {{ $score }}
                            </span>
                            <span class="text-[10px] font-mono text-slate-400 uppercase tracking-widest mt-1">/ 100</span>
                        </div>
                    </div>

                    <!-- Grade Badge & Evaluation -->
                    <div class="space-y-1">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Security Grade</span>
                        <div class="text-4xl font-extrabold font-mono {{ $scoreColor }} tracking-tight">
                            {{ $grade }}
                        </div>
                        <p class="text-xs text-slate-500 font-medium">
                            {{ $failedCount > 0 ? $failedCount . ' Perlu Perhatian' : 'Perlindungan Lengkap' }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- 4 Summary Stat Tiles (Clean White) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-8 pt-6 border-t border-slate-100">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <p class="text-[11px] text-slate-500 uppercase font-semibold">Parameter Diuji</p>
                    <p class="text-xl font-bold font-mono text-slate-900 mt-0.5">{{ $totalChecks }} Filter</p>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200/80">
                    <p class="text-[11px] text-emerald-800 uppercase font-semibold">Filter Lolos</p>
                    <p class="text-xl font-bold font-mono text-emerald-700 mt-0.5">{{ $passedCount }} Sukses</p>
                </div>
                <div class="p-3.5 rounded-xl {{ $failedCount > 0 ? 'bg-rose-50/70 border border-rose-200/80' : 'bg-slate-50 border border-slate-200/80' }}">
                    <p class="text-[11px] {{ $failedCount > 0 ? 'text-rose-800' : 'text-slate-500' }} uppercase font-semibold">Celah Ditemukan</p>
                    <p class="text-xl font-bold font-mono {{ $failedCount > 0 ? 'text-rose-700' : 'text-slate-700' }} mt-0.5">
                        {{ $failedCount }} Celah
                    </p>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <p class="text-[11px] text-slate-500 uppercase font-semibold">Tingkat Risiko</p>
                    <div class="mt-0.5">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold font-mono border {{ $riskColor }}">
                            {{ $riskLevel }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2-Column Findings & Protections Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Column: Vulnerabilities (7 Cols) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="flex items-center justify-between pb-1 border-b border-slate-200">
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $failedCount > 0 ? 'bg-rose-500' : 'bg-emerald-500' }}"></span>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">
                            Celah & Kerentanan Teridentifikasi ({{ $failedCount }})
                        </h2>
                    </div>
                    <span class="text-xs text-slate-500">Pengurangan Skor</span>
                </div>

                @if($failedCount > 0)
                    <div class="space-y-5">
                        @foreach($failedByCategory as $catKey => $catItems)
                            @php
                                $catInfo = $categoryLabels[$catKey] ?? ['label' => 'Kategori Lain', 'color' => 'slate'];
                            @endphp
                            
                            <div>
                                <!-- Category Title -->
                                <div class="flex items-center space-x-2 mb-2.5">
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">{{ $catInfo['label'] }}</span>
                                    <span class="text-[11px] text-slate-400 font-mono">({{ count($catItems) }} item)</span>
                                </div>

                                <div class="space-y-3">
                                    @foreach($catItems as $failed)
                                        @php
                                            $name = $failed['name'] ?? '';
                                            $desc = $failed['desc'] ?? '';
                                            $minus = $failed['minus'] ?? '-0';
                                            [$severity, $remediation, $owaspRef] = getRemediation($name, $catKey);

                                            if ($severity === 'Kritis') {
                                                $sevBadge = 'bg-rose-50 text-rose-700 border-rose-200';
                                                $accentBorder = 'border-l-rose-500';
                                            } elseif ($severity === 'Tinggi') {
                                                $sevBadge = 'bg-orange-50 text-orange-700 border-orange-200';
                                                $accentBorder = 'border-l-orange-500';
                                            } elseif ($severity === 'Rendah') {
                                                $sevBadge = 'bg-blue-50 text-blue-700 border-blue-200';
                                                $accentBorder = 'border-l-blue-500';
                                            } else {
                                                $sevBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                                                $accentBorder = 'border-l-amber-500';
                                            }
                                        @endphp

                                        <div class="clean-card rounded-xl p-5 border-l-4 {{ $accentBorder }} print-break-inside-avoid">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="space-y-1">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <h3 class="font-bold text-sm text-slate-900 font-mono">{{ $name }}</h3>
                                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded border {{ $sevBadge }}">
                                                            Risiko {{ $severity }}
                                                        </span>
                                                        <span class="px-2 py-0.5 text-[10px] font-mono font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200">
                                                            {{ $owaspRef }}
                                                        </span>
                                                    </div>
                                                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $desc }}</p>
                                                </div>
                                                <span class="shrink-0 px-2.5 py-1 bg-rose-50 text-rose-700 text-xs font-mono font-bold rounded-lg border border-rose-200">
                                                    {{ $minus }} Poin
                                                </span>
                                            </div>

                                            <!-- Rekomendasi Solusi Callout Box -->
                                            <div class="mt-4 pt-3 border-t border-slate-100 bg-slate-50/80 -mx-5 -mb-5 p-4 rounded-b-xl">
                                                <div class="flex items-start space-x-2.5">
                                                    <div class="w-5 h-5 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 mt-0.5">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="text-xs text-slate-700 leading-relaxed">
                                                        <span class="font-bold text-slate-900">Rekomendasi Perbaikan:</span>
                                                        <p class="mt-0.5 text-slate-600">{{ $remediation }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Zero Vulnerabilities Clean State -->
                    <div class="clean-card rounded-2xl p-8 text-center border-emerald-200 bg-emerald-50/30">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 border border-emerald-200 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base">Tidak Ada Celah Terdeteksi!</h3>
                        <p class="text-xs text-slate-600 mt-1 max-w-md mx-auto">
                            Konfigurasi keamanan pada target web ini telah memenuhi seluruh checklist pengujian HSU Sentinel.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Right Column: Passed Protections (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Proteksi Aktif -->
                <div>
                    <div class="flex items-center justify-between pb-1 border-b border-slate-200 mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">
                                Proteksi yang Aktif ({{ $passedCount }})
                            </h2>
                        </div>
                        <span class="text-xs text-emerald-600 font-semibold">Terverifikasi</span>
                    </div>

                    <div class="clean-card rounded-xl p-4 divide-y divide-slate-100">
                        @if($passedCount > 0)
                            <div class="space-y-3">
                                @foreach($passedItems as $passed)
                                    @php
                                        if (is_string($passed)) {
                                            $passedName = $passed;
                                            $passedCategory = '';
                                        } else {
                                            $passedName = $passed['name'] ?? '';
                                            $passedCategory = $passed['category'] ?? '';
                                        }
                                        $benefit = getPassedBenefit($passedName);
                                        $passedCatInfo = $categoryLabels[$passedCategory] ?? null;
                                    @endphp

                                    <div class="flex items-start space-x-3 p-2.5 rounded-lg hover:bg-slate-50 transition-colors">
                                        <div class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-mono font-bold text-slate-900">{{ $passedName }}</p>
                                            @if($passedCatInfo)
                                                <span class="inline-block text-[10px] text-slate-500 font-semibold uppercase tracking-wider">
                                                    {{ $passedCatInfo['label'] }}
                                                </span>
                                            @endif
                                            <p class="text-xs text-slate-600 mt-0.5">{{ $benefit }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-6 text-center">
                                <p class="text-xs text-slate-500">Semua parameter pengujian belum terpenuhi pada domain target.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Guidance & Score Standard Box (Clean White) -->
                <div class="clean-card rounded-xl p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-700">Panduan Skor & Metodologi</p>
                        <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">Basis 100 Poin</span>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Skor dihitung dengan rumus <code class="font-mono font-bold text-slate-700">100 &minus; &Sigma; Penalti</code> mengacu pada <strong>OWASP Top 10 (2021)</strong>, <strong>OWASP Secure Headers Project</strong>, dan <strong>CVSS v3.1</strong>.
                    </p>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between p-2 rounded-lg bg-emerald-50/80 border border-emerald-200/60">
                            <span class="font-bold text-emerald-800">85 - 100 Poin (A+)</span>
                            <span class="text-emerald-700 font-medium">Optimal & Layak Produksi</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-blue-50/80 border border-blue-200/60">
                            <span class="font-bold text-blue-800">70 - 84 Poin (B)</span>
                            <span class="text-blue-700 font-medium">Cukup Baik</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-amber-50/80 border border-amber-200/60">
                            <span class="font-bold text-amber-800">50 - 69 Poin (C)</span>
                            <span class="text-amber-700 font-medium">Perlu Perhatian</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg bg-rose-50/80 border border-rose-200/60">
                            <span class="font-bold text-rose-800">&lt; 50 Poin (F)</span>
                            <span class="text-rose-700 font-medium">Kritis & Rentan</span>
                        </div>
                    </div>

                    <!-- Rincian Bobot Penalti per Tingkat Risiko -->
                    <div class="pt-3 border-t border-slate-100 space-y-1.5 text-[11px]">
                        <p class="font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1">Rujukan Bobot Penalti (CVSS Severity):</p>
                        <div class="flex items-center justify-between text-slate-600">
                            <span><strong class="text-rose-700">Kritis:</strong> SQLi, Web Shell, File Sensitif Bocor</span>
                            <span class="font-mono font-bold text-rose-700">-15 Poin</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span><strong class="text-orange-700">Tinggi:</strong> SSL Invalid, CSP, Brute-Force, FIM</span>
                            <span class="font-mono font-bold text-orange-700">-10 / -15</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span><strong class="text-amber-700">Sedang:</strong> TLS, HSTS, XFO, Redirect, Cookie</span>
                            <span class="font-mono font-bold text-amber-700">-5 s/d -10</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span><strong class="text-blue-700">Rendah:</strong> XCTO, Referrer, Permissions-Policy</span>
                            <span class="font-mono font-bold text-blue-700">-2 s/d -5</span>
                        </div>
                    </div>
                </div>

                <!-- Tested Categories Checklist -->
                <div class="clean-card rounded-xl p-5 space-y-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-700">Cakupan Kategori Audit</p>
                    <div class="space-y-2">
                        @foreach($categoryLabels as $catKey => $catInfo)
                            @php
                                $isFailed = isset($failedByCategory[$catKey]);
                                $isPassed = isset($passedByCategory[$catKey]);
                            @endphp
                            <div class="flex items-center justify-between text-xs py-1 border-b border-slate-100 last:border-0">
                                <span class="text-slate-700 font-medium">{{ $catInfo['label'] }}</span>
                                @if($isFailed)
                                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span>Perlu Perbaikan</span>
                                    </span>
                                @elseif($isPassed)
                                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span>Terlindungi</span>
                                    </span>
                                @else
                                    <span class="text-[10px] text-slate-400">Normal</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

        <!-- Signature Block Visible Only on Print -->
        <div class="hidden print:block mt-8 pt-4 text-xs text-slate-800">
            <div class="flex justify-between items-start">
                <div class="text-center w-56">
                    <p class="text-slate-600">Diuji dan Diaudit Oleh:</p>
                    <p class="font-bold text-slate-900 mt-0.5">Petugas Audit / Mahasiswa PKL</p>
                    <div class="h-16 flex items-center justify-center">
                        <span class="text-[10px] text-slate-400 italic">( Tanda Tangan )</span>
                    </div>
                    <p class="font-bold text-slate-900 underline">AHMAD RIZKY MAULANA</p>
                    <p class="text-[10px] text-slate-600 font-mono">NIM: 2110010000 / FTI UNISKA</p>
                </div>
                <div class="text-center w-64">
                    <p class="text-slate-600">Amuntai, {{ date('d F Y') }}</p>
                    <p class="font-bold text-slate-900 mt-0.5">Mengetahui,<br>Bidang E-Gov & Siber Sandi Diskominfo</p>
                    <div class="h-14 flex items-center justify-center">
                        <span class="text-[10px] text-slate-400 italic">( Tanda Tangan & Cap )</span>
                    </div>
                    <p class="font-bold text-slate-900 underline">H. SYAMSUL BAHRI, S.Kom., M.M.</p>
                    <p class="text-[10px] text-slate-600 font-mono">NIP. 19780514 200501 1 008</p>
                </div>
            </div>
        </div>

        <!-- Bottom Action Bar (No Print) -->
        <div class="mt-12 pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 no-print">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-slate-200 px-5 py-2.5 rounded-xl transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Audit Target Lain</span>
            </a>

            <p class="text-xs text-slate-500 font-mono">
                Laporan ini di-generate secara otomatis oleh HSU Sentinel Engine v3.0
            </p>
        </div>

    </main>

    <!-- Clean Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500 no-print mt-12">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ date('Y') }} Dinas Komunikasi, Informatika dan Persandian Kab. Hulu Sungai Utara</p>
            <p class="font-mono text-[11px] text-slate-400">Cyber Defense & Security Assurance Division</p>
        </div>
    </footer>

    <!-- Client Scripts -->
    <script>
        function copyUrl() {
            const url = document.getElementById('targetUrlText').innerText.trim();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    alert('URL target berhasil disalin ke clipboard:\n' + url);
                }).catch(() => {
                    fallbackCopy(url);
                });
            } else {
                fallbackCopy(url);
            }
        }

        function fallbackCopy(text) {
            const temp = document.createElement('textarea');
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            alert('URL target berhasil disalin ke clipboard:\n' + text);
        }

        document.getElementById('rescanForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('rescanBtn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-3.5 w-3.5 text-white inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memindai...';
            }
        });
    </script>
</body>
</html>