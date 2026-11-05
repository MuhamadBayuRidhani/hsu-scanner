<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSU Sentinel | Portal Audit Keamanan Siber Pemerintah Kab. Hulu Sungai Utara</title>
    
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

        .gov-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease-in-out;
        }

        .gov-card:hover {
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.08), 0 2px 4px -2px rgba(15, 23, 42, 0.06);
            border-color: #cbd5e1;
        }

        .gov-input-focus:focus-within {
            box-shadow: 0 0 0 3px rgba(2, 114, 197, 0.15);
            border-color: #0272c5;
        }

        /* Radar scan pulse */
        @keyframes radar-sweep {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-radar {
            animation: radar-sweep 2.4s linear infinite;
        }
    </style>
</head>
<body class="text-slate-800 min-h-screen flex flex-col font-sans selection:bg-blue-600 selection:text-white antialiased">

    <!-- Top Institutional Banner / Red-White Gov Bar -->
    <div class="h-1 bg-gradient-to-r from-red-600 via-white to-blue-700 w-full"></div>

    <!-- Main Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <!-- Brand & Agency Identity -->
            <div class="flex items-center min-w-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3.5 group min-w-0">
                    <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab Hulu Sungai Utara" class="h-11 sm:h-12 w-auto object-contain drop-shadow-sm transition-transform duration-200 group-hover:scale-105 shrink-0">
                    <div class="min-w-0">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-base sm:text-lg font-extrabold tracking-tight text-navy-900 leading-none truncate">
                                HSU SENTINEL
                            </h1>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gov-100 text-gov-800 border border-gov-200 shrink-0">
                                KAB. HSU
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-1 truncate">
                            Dinas Komunikasi, Informatika dan Persandian Kab. Hulu Sungai Utara
                        </p>
                    </div>
                </a>
            </div>

            <!-- Header Operational Status, Clock & Navigation -->
            <div class="flex items-center space-x-3 sm:space-x-5 shrink-0">
                <!-- Engine Online Indicator -->
                <div class="hidden lg:flex items-center space-x-2 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-800">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="font-mono text-[11px] font-bold tracking-wide">CORE ONLINE</span>
                </div>

                <!-- Real-time Clock -->
                <div class="hidden md:block text-right border-l border-slate-200 pl-5">
                    <p id="liveTime" class="text-xs font-mono font-bold text-navy-900 leading-tight">--:--:-- WITA</p>
                    <p id="liveDate" class="text-[11px] text-slate-500 leading-tight mt-0.5">-- --- ----</p>
                </div>

                <!-- Navigation to Reports -->
                <a href="{{ route('scan.reports') }}" class="inline-flex items-center space-x-1.5 px-3.5 sm:px-4 py-2.5 rounded-lg bg-gov-700 hover:bg-gov-800 text-white text-xs font-bold shadow-sm transition-all">
                    <svg class="w-4 h-4 text-gov-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Laporan Rekap</span>
                </a>

                <!-- Account Management -->
                <a href="{{ route('account.index') }}" class="inline-flex items-center space-x-1.5 px-3 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all" title="Pengaturan Akun, Ganti Password & Tambah User">
                    <svg class="w-4 h-4 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="hidden xl:inline">Akun &amp; User</span>
                </a>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center space-x-1 px-3 py-2.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition-colors" title="Keluar dari Sistem">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <!-- Flash Notifications -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start space-x-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-bold text-emerald-900">Operasi Berhasil</p>
                    <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start space-x-3 shadow-sm">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-bold text-rose-900">Pemberitahuan Audit</p>
                    <p class="text-xs text-rose-700 mt-0.5">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <!-- Executive Hero Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-gov-100 text-gov-800 border border-gov-200/70 text-xs font-semibold mb-2.5">
                        <span class="w-2 h-2 rounded-full bg-gov-600"></span>
                        <span>Portal Pengawasan Keamanan Informasi Daerah</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-900 tracking-tight">
                        Dashboard Audit & Pemindai Kerentanan Siber
                    </h2>
                    <p class="text-sm text-slate-600 mt-1.5 max-w-3xl leading-relaxed">
                        Pengujian kepatuhan keamanan web portal Organisasi Perangkat Daerah (OPD) mencakup konfigurasi HTTP Security Headers, integritas file sistem, deteksi ancaman injeksi, web shell, dan kebocoran data sensitif.
                    </p>
                </div>
                <div class="shrink-0 flex items-center space-x-2">
                    <a href="#scannerSection" class="inline-flex items-center space-x-2 bg-gov-700 hover:bg-gov-800 text-white font-bold text-xs uppercase tracking-wider px-5 py-3 rounded-xl shadow-sm transition-all hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>Audit Situs Baru</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 Executive KPI & Security Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            
            <!-- KPI 1: Total Audit -->
            <div class="gov-card rounded-xl p-5 relative overflow-hidden flex flex-col justify-between h-full">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Audit Situs</p>
                        <h3 class="text-3xl font-extrabold text-navy-900 mt-1.5 font-mono leading-none">
                            {{ number_format($metrics['totalScans'] ?? 0) }}
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-2">Domain tercatat di database</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-gov-50 border border-gov-200 flex items-center justify-center text-gov-700 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center text-[11px] text-slate-600 font-medium">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 mr-1.5 shrink-0"></span>
                    <span>Monitoring Berkala Aktif</span>
                </div>
            </div>

            <!-- KPI 2: Rata-Rata Indeks Keamanan -->
            @php
                $avg = $metrics['avgScore'] ?? 0;
                if ($avg >= 80) {
                    $avgStatus = 'Optimal';
                    $avgColor = 'text-emerald-700 bg-emerald-50 border-emerald-200';
                    $barColor = 'bg-emerald-500';
                } elseif ($avg >= 50) {
                    $avgStatus = 'Cukup';
                    $avgColor = 'text-amber-700 bg-amber-50 border-amber-200';
                    $barColor = 'bg-amber-500';
                } else {
                    $avgStatus = 'Kritis';
                    $avgColor = 'text-rose-700 bg-rose-50 border-rose-200';
                    $barColor = 'bg-rose-500';
                }
            @endphp
            <div class="gov-card rounded-xl p-5 relative overflow-hidden flex flex-col justify-between h-full">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Indeks Keamanan</p>
                        <div class="flex items-baseline space-x-1.5 mt-1.5 leading-none">
                            <h3 class="text-3xl font-extrabold text-navy-900 font-mono leading-none">
                                {{ $avg }}
                            </h3>
                            <span class="text-xs text-slate-500 font-mono">/ 100</span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2">Rata-rata skor kepatuhan</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-700 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="{{ $barColor }} h-1.5 rounded-full" style="width: {{ $avg }}%"></div>
                    </div>
                    <span class="shrink-0 inline-block px-2 py-0.5 rounded text-[10px] font-bold border {{ $avgColor }}">
                        Predikat: {{ $avgStatus }}
                    </span>
                </div>
            </div>

            <!-- KPI 3: Domain Kategori Aman -->
            @php
                $total = max(1, $metrics['totalScans'] ?? 0);
                $secCount = $metrics['secureCount'] ?? 0;
                $secPct = round(($secCount / $total) * 100);
            @endphp
            <div class="gov-card rounded-xl p-5 relative overflow-hidden flex flex-col justify-between h-full">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Domain Memenuhi Standar</p>
                        <h3 class="text-3xl font-extrabold text-emerald-600 mt-1.5 font-mono leading-none">
                            {{ $secCount }}
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-2">{{ $secPct }}% rasio kepatuhan</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center text-[11px] text-emerald-700 font-medium">
                    <span class="font-bold">Skor ≥ 80 Poin (Aman / Good)</span>
                </div>
            </div>

            <!-- KPI 4: Domain Perlu Perhatian / Rentan -->
            @php
                $critCount = $metrics['criticalCount'] ?? 0;
                $warnCount = $metrics['warningCount'] ?? 0;
                $remCount = $critCount + $warnCount;
            @endphp
            <div class="gov-card rounded-xl p-5 relative overflow-hidden flex flex-col justify-between h-full">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Perlu Remidiasi</p>
                        <h3 class="text-3xl font-extrabold text-rose-600 mt-1.5 font-mono leading-none">
                            {{ $remCount }}
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-2">Domain butuh tindakan penguatan</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] font-medium">
                    <span class="text-rose-700 font-semibold">{{ $critCount }} Kritis (&lt;50)</span>
                    <span class="text-amber-700 font-semibold">{{ $warnCount }} Waspada (50-79)</span>
                </div>
            </div>

        </div>

        <!-- Scanner Hub Card (Formulir Audit Mandiri) -->
        <div id="scannerSection" class="gov-card rounded-2xl p-6 sm:p-8 mb-10 relative overflow-hidden border-t-4 border-t-gov-700">
            
            <div class="max-w-4xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-6">
                    <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-gov-50 border border-gov-200 text-gov-800 text-xs font-semibold mb-2">
                        <svg class="w-3.5 h-3.5 text-gov-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Inspeksi Cepat Keamanan Web Pemerintah</span>
                    </span>
                    <h3 class="text-xl sm:text-2xl font-bold text-navy-900 tracking-tight">
                        Uji Kepatuhan & Kerentanan Portal Web
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1.5 max-w-2xl mx-auto">
                        Pilih instansi atau website Organisasi Perangkat Daerah (OPD) untuk memulai audit keamanan secara instan tanpa perlu mengetik URL secara manual.
                    </p>
                </div>

                <!-- Scan Form -->
                <form id="scanForm" action="{{ route('scan.process') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Hidden field to store actual processed URL -->
                    <input type="hidden" id="urlInput" name="url" value="https://web.hsu.go.id">

                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                            <label for="opdSelect" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Pilih Instansi / Website OPD Target Audit
                            </label>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center space-x-1 text-[11px] text-gov-800 font-bold bg-gov-50 px-2.5 py-0.5 rounded-full border border-gov-200">
                                    <svg class="w-3 h-3 text-gov-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    <span>Terkunci: Domain HSU & Whitelist Vertikal</span>
                                </span>
                            </div>
                        </div>
                        
                        <div class="gov-input-focus flex flex-col sm:flex-row items-stretch bg-white border-2 border-slate-300 rounded-xl p-1.5 transition-all shadow-sm gap-2">
                            <div class="flex items-center flex-1 min-w-0 px-2">
                                <div class="pl-1 pr-2 text-gov-700 shrink-0">
                                    <svg class="w-5 h-5 text-gov-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <select 
                                    id="opdSelect" 
                                    onchange="handleOpdChange(this)"
                                    class="w-full bg-transparent border-0 text-slate-900 font-bold text-sm py-2.5 pr-4 focus:outline-none focus:ring-0 cursor-pointer truncate"
                                >
                                    @if(isset($catalog) && count($catalog) > 0)
                                        @foreach($catalog as $groupName => $groupData)
                                            <optgroup label="{{ $groupData['icon'] ?? '📁' }} {{ $groupName }}">
                                                @foreach($groupData['items'] as $item)
                                                    <option value="{{ $item['url'] }}" {{ $loop->parent->first && $loop->first ? 'selected' : '' }}>
                                                        {{ $item['name'] }} ({{ $item['host'] }})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @else
                                        <optgroup label="🏛️ Portal Utama & Sekretariat Daerah">
                                            <option value="https://web.hsu.go.id" selected>Portal Resmi Pemkab Hulu Sungai Utara (web.hsu.go.id)</option>
                                            <option value="https://prokopim.hsu.go.id/">Sekretariat Daerah - Prokopim (prokopim.hsu.go.id)</option>
                                            <option value="https://setda.hsu.go.id">Sekretariat Daerah - SETDA (setda.hsu.go.id)</option>
                                        </optgroup>
                                    @endif
                                    <optgroup label="⚙️ Pilihan Lain">
                                        <option value="custom">✏️ Masukkan URL Lain Secara Manual...</option>
                                    </optgroup>
                                </select>
                            </div>

                            <button 
                                type="submit" 
                                id="submitBtn"
                                class="shrink-0 inline-flex items-center justify-center space-x-2 bg-gov-700 hover:bg-gov-800 text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-lg shadow-sm hover:shadow transition-all"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                <span>Mulai Audit Sekarang</span>
                            </button>
                        </div>
                    </div>

                    <!-- Custom URL Manual Input Container (Hidden by default, shown if "custom" selected) -->
                    <div id="customUrlContainer" class="hidden">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="customUrlInput" class="block text-xs font-semibold text-slate-700">
                                Ketik Alamat URL Website Kustom:
                            </label>
                            <span class="inline-flex items-center space-x-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Terkunci Domain HSU & Whitelist Vertikal</span>
                            </span>
                        </div>
                        <div id="customUrlInputBox" class="gov-input-focus flex items-center bg-slate-50 border border-slate-300 rounded-xl p-1.5 transition-all">
                            <div class="pl-2 pr-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="customUrlInput" 
                                placeholder="Contoh: https://kab-hulusungaiutara.kpu.go.id atau https://disdik.hsu.go.id" 
                                oninput="handleCustomUrlInput(this.value)"
                                class="w-full bg-transparent border-0 text-slate-900 placeholder-slate-400 font-mono text-xs px-2 py-1.5 focus:outline-none focus:ring-0"
                            >
                            <button 
                                type="button" 
                                onclick="cancelCustomUrl()"
                                class="shrink-0 text-xs text-slate-500 hover:text-slate-800 px-3 py-1 font-medium transition-colors"
                            >
                                Kembali ke Pilihan OPD
                            </button>
                        </div>
                        <p id="domainWarningText" class="hidden text-[11px] text-rose-600 mt-1.5 font-medium flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Perhatian: Target harus beralamat pada domain resmi Pemerintah Kab. HSU (<strong>*.hsu.go.id</strong>) atau instansi vertikal mitra HSU terdaftar (KPU, PA/PN Amuntai, Bawaslu, Polres, BPS).</span>
                        </p>
                    </div>

                    <!-- Target Preview & Status Bar -->
                    <div id="targetPreviewCard" class="flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs gap-2">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-500 block leading-tight">Target URL Siap Diaudit:</span>
                                <span id="targetPreviewUrl" class="font-mono font-bold text-gov-800 text-xs">https://web.hsu.go.id</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>SSL / HTTPS</span>
                            </span>
                            <button type="button" onclick="switchToCustomMode()" class="text-[11px] text-gov-600 hover:text-gov-800 font-semibold hover:underline">
                                Ketik URL Lain
                            </button>
                        </div>
                    </div>

                    <!-- Quick Target Presets (OPD Kab. Hulu Sungai Utara & Instansi Vertikal) -->
                    <div class="flex flex-wrap items-center gap-2 pt-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Pilih Cepat:</span>
                        <button type="button" onclick="setOpdTarget('https://web.hsu.go.id')" class="opd-chip text-xs font-mono text-gov-800 bg-gov-100 border border-gov-300 px-2.5 py-1 rounded-md font-bold shadow-sm">
                            web.hsu.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('https://diskominfo.hsu.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            diskominfo.hsu.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('https://dinkes.hsu.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            dinkes.hsu.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('https://kab-hulusungaiutara.kpu.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            kpu.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('https://www.pa-amuntai.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            pa-amuntai.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('https://www.pn-amuntai.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            pn-amuntai.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('http://hulusungaiutara.kalsel.polri.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            polri.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('https://hulusungaiutara.bawaslu.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            bawaslu.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('https://bapenda.hsu.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            bapenda.hsu.go.id
                        </button>
                        <button type="button" onclick="setOpdTarget('https://rspb.hsu.go.id/')" class="opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium">
                            rspb.hsu.go.id
                        </button>
                    </div>
                </form>

                <!-- Parameter Inspection Badges — 7 Kategori Standar Keamanan -->
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 text-center sm:text-left">
                        Cakupan Parameter Audit Keamanan:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        
                        <div class="flex items-center space-x-2.5 p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                            <div class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 truncate">Security Headers</p>
                                <p class="text-[10px] text-slate-500 truncate">CSP, HSTS, X-Frame</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2.5 p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                            <div class="w-7 h-7 rounded-md bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 truncate">Sensitif File Audit</p>
                                <p class="text-[10px] text-slate-500 truncate">.env, .git, backup</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2.5 p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                            <div class="w-7 h-7 rounded-md bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 truncate">Web Shell Probe</p>
                                <p class="text-[10px] text-slate-500 truncate">Backdoor & upload</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2.5 p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                            <div class="w-7 h-7 rounded-md bg-red-100 text-red-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 truncate">SQL Injection</p>
                                <p class="text-[10px] text-slate-500 truncate">Sanitisasi input</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2.5 p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                            <div class="w-7 h-7 rounded-md bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 truncate">Brute-Force & Auth</p>
                                <p class="text-[10px] text-slate-500 truncate">Rate-limit & captcha</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2.5 p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                            <div class="w-7 h-7 rounded-md bg-yellow-100 text-yellow-800 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 truncate">File Integrity (FIM)</p>
                                <p class="text-[10px] text-slate-500 truncate">Debug & config leak</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2.5 p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                            <div class="w-7 h-7 rounded-md bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 truncate">Framework Version</p>
                                <p class="text-[10px] text-slate-500 truncate">CMS & server leak</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2.5 p-2.5 rounded-lg bg-gov-50 border border-gov-200">
                            <div class="w-7 h-7 rounded-md bg-gov-600 text-white flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-gov-900 truncate">Indeks Kepatuhan</p>
                                <p class="text-[10px] text-gov-700 truncate">Skala 0 - 100 Poin</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- Tabel Riwayat Audit Interaktif (Tersimpan di Database) -->
        <div class="gov-card rounded-2xl p-6 sm:p-8 bg-white border border-slate-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gov-50 border border-gov-200 flex items-center justify-center text-gov-700 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                                Riwayat Audit Keamanan Terakhir
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 font-mono">
                                {{ count($recentScans) }} Tersimpan
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Daftar hasil inspeksi kepatuhan dan skor keamanan web portal instansi yang tersimpan pada sistem database
                        </p>
                    </div>
                </div>

                <!-- Instant Client-side Search Box -->
                <div class="w-full sm:w-72">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="searchHistoryInput" 
                            onkeyup="applyHistoryFilters()" 
                            placeholder="Cari domain / URL..." 
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs rounded-xl pl-9 pr-8 py-2.5 focus:outline-none focus:border-gov-600 focus:bg-white transition-all font-mono"
                        >
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <button type="button" onclick="clearHistorySearch()" id="clearSearchBtn" class="hidden absolute right-2.5 top-2.5 text-slate-400 hover:text-slate-600 p-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Filter Chips / Tabs -->
            <div class="flex flex-wrap items-center justify-between gap-2 mb-5 pb-3 border-b border-slate-100">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 mr-1">Filter Kategori:</span>
                    <button type="button" data-cat="all" onclick="setHistoryCategory('all', this)" class="history-chip active px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-gov-700 text-white shadow-sm">
                        Semua ({{ count($recentScans) }})
                    </button>
                    <button type="button" data-cat="secure" onclick="setHistoryCategory('secure', this)" class="history-chip px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 border border-slate-200">
                        Aman (≥80)
                    </button>
                    <button type="button" data-cat="warning" onclick="setHistoryCategory('warning', this)" class="history-chip px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-slate-100 hover:bg-amber-50 text-slate-700 hover:text-amber-800 border border-slate-200">
                        Waspada (50-79)
                    </button>
                    <button type="button" data-cat="critical" onclick="setHistoryCategory('critical', this)" class="history-chip px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-slate-100 hover:bg-rose-50 text-slate-700 hover:text-rose-800 border border-slate-200">
                        Kritis (&lt;50)
                    </button>
                </div>

                @if(isset($recentScans) && count($recentScans) > 0)
                    <form action="{{ route('scan.cleanup.duplicates') }}" method="POST" onsubmit="return confirm('Bersihkan seluruh riwayat audit lama dan hanya sisakan 1 hasil audit paling baru untuk setiap website OPD?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg {{ ($duplicateCount ?? 0) > 0 ? 'bg-amber-50 hover:bg-amber-100 text-amber-800 border-amber-300' : 'bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-700 border-slate-200 hover:border-rose-200' }} text-xs font-bold border transition-colors" title="Hapus hasil scan lama yang berulang dan hanya sisakan 1 audit terbaru per domain">
                            <svg class="w-3.5 h-3.5 {{ ($duplicateCount ?? 0) > 0 ? 'text-amber-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Bersihkan Riwayat Lama (Sisakan Terbaru)</span>
                            @if(($duplicateCount ?? 0) > 0)
                                <span class="px-1.5 py-0.2 rounded-full bg-amber-200/80 text-amber-900 font-mono text-[10px]">{{ $duplicateCount }}</span>
                            @endif
                        </button>
                    </form>
                @endif
            </div>

            @if(isset($recentScans) && count($recentScans) > 0)
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left text-xs" id="historyTable">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                                <th class="py-3.5 px-4">Target Website URL</th>
                                <th class="py-3.5 px-4">Waktu Audit</th>
                                <th class="py-3.5 px-4 text-center">Skor Kepatuhan</th>
                                <th class="py-3.5 px-4 text-center">Status Keamanan</th>
                                <th class="py-3.5 px-4 text-right">Laporan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white" id="historyTableBody">
                            @foreach($recentScans as $item)
                                @php
                                    $score = $item->score;
                                    if ($score >= 80) {
                                        $categoryKey = 'secure';
                                        $badgeBg = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                                        $statusDot = 'bg-emerald-500';
                                        $statusText = 'Aman (Optimal)';
                                        $grade = $score >= 85 ? 'A+' : 'A';
                                    } elseif ($score >= 50) {
                                        $categoryKey = 'warning';
                                        $badgeBg = 'bg-amber-50 text-amber-800 border-amber-200';
                                        $statusDot = 'bg-amber-500';
                                        $statusText = 'Perlu Perhatian';
                                        $grade = $score >= 70 ? 'B' : 'C';
                                    } else {
                                        $categoryKey = 'critical';
                                        $badgeBg = 'bg-rose-50 text-rose-800 border-rose-200';
                                        $statusDot = 'bg-rose-500';
                                        $statusText = 'Kritis & Rentan';
                                        $grade = 'F';
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-colors history-row" data-category="{{ $categoryKey }}" data-url="{{ strtolower($item->url) }}">
                                    <td class="py-3.5 px-4 font-mono font-medium text-slate-900 domain-cell">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <a href="{{ route('scan.history', $item->id) }}" class="font-bold text-slate-900 hover:text-gov-700 transition-colors truncate block max-w-xs sm:max-w-md" title="{{ $item->url }}">
                                                    {{ $item->url }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
                                        <span class="font-medium text-slate-800 block text-xs">
                                            {{ $item->created_at ? $item->created_at->format('d M Y, H:i') . ' WITA' : '-' }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">
                                            {{ $item->created_at ? $item->created_at->diffForHumans() : '' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-bold border {{ $badgeBg }}">
                                            {{ $score }}/100 <span class="ml-1 text-[10px] font-sans font-semibold">({{ $grade }})</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeBg }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span>
                                            <span>{{ $statusText }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end space-x-1.5">
                                            <a href="{{ route('scan.history', $item->id) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg bg-gov-50 hover:bg-gov-100 text-gov-800 font-bold text-xs border border-gov-200 transition-all shadow-sm">
                                                <span>Buka Laporan</span>
                                                <svg class="w-3.5 h-3.5 text-gov-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('scan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data audit {{ $item->url }} ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus Riwayat Ini">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- No Match Filter State -->
                <div id="noMatchRow" class="hidden text-center py-10 bg-slate-50/50 rounded-xl border border-dashed border-slate-200 my-3">
                    <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-xs font-semibold text-slate-700">Tidak ada riwayat audit yang cocok dengan filter.</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                </div>

                <!-- Bottom Banner to Full Reports -->
                <div class="mt-5 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center space-x-2 text-xs text-slate-600">
                        <svg class="w-4 h-4 text-gov-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Memerlukan rekapitulasi audit seluruh OPD untuk lampiran laporan resmi PKL?</span>
                    </div>
                    <a href="{{ route('scan.reports') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-lg bg-gov-700 hover:bg-gov-800 text-white font-bold text-xs shadow-sm transition-all shrink-0">
                        <span>Buka Rekapitulasi Laporan</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            @else
                <div class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-xs font-semibold text-slate-600">Belum ada data audit tersimpan.</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Masukkan alamat URL situs pada formulir di atas untuk memulai audit keamanan pertama Anda.</p>
                </div>
            @endif
        </div>

    </main>

    <!-- Scanning Overlay Modal (Active upon form submit) -->
    <div id="scanningOverlay" class="fixed inset-0 z-50 bg-navy-950/70 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white max-w-md w-full rounded-2xl p-8 text-center border border-slate-200 shadow-2xl relative overflow-hidden">
            
            <!-- Radar sweep graphic -->
            <div class="relative w-24 h-24 mx-auto mb-5 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border border-gov-200"></div>
                <div class="absolute inset-2 rounded-full border border-gov-300"></div>
                <div class="absolute inset-5 rounded-full border border-gov-400"></div>
                <div class="w-full h-full rounded-full animate-radar origin-center bg-gradient-to-tr from-gov-500/20 via-transparent to-transparent"></div>
                <div class="w-3.5 h-3.5 bg-gov-600 rounded-full shadow-md shadow-gov-600/50"></div>
            </div>

            <h3 class="text-lg font-bold text-navy-900 tracking-tight mb-1">
                Sedang Melakukan Audit Keamanan...
            </h3>
            <p id="scanningTargetUrl" class="text-xs font-mono font-semibold text-gov-700 mb-5 truncate px-2 bg-gov-50 py-1 rounded-md border border-gov-200">
                Memeriksa konfigurasi server...
            </p>

            <!-- Dynamic Scanning Step Indicators — 8 langkah -->
            <div class="space-y-2 text-left bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-xs">
                <div id="step1" class="flex items-center space-x-2 text-slate-500">
                    <span class="w-2 h-2 rounded-full bg-gov-600 animate-pulse"></span>
                    <span class="font-medium">1. Menghubungkan & menganalisa sertifikat SSL...</span>
                </div>
                <div id="step2" class="flex items-center space-x-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span>2. Menguji HTTP Security Headers...</span>
                </div>
                <div id="step3" class="flex items-center space-x-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span>3. Memindai kebocoran file sensitif...</span>
                </div>
                <div id="step4" class="flex items-center space-x-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span>4. Mendeteksi web shell & upload vulnerability...</span>
                </div>
                <div id="step5" class="flex items-center space-x-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span>5. Menguji kerentanan SQL Injection...</span>
                </div>
                <div id="step6" class="flex items-center space-x-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span>6. Memeriksa proteksi brute-force & auth...</span>
                </div>
                <div id="step7" class="flex items-center space-x-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span>7. Mengaudit file integrity & debug exposure...</span>
                </div>
                <div id="step8" class="flex items-center space-x-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span>8. Menganalisa dependency & framework version...</span>
                </div>
            </div>

            <p class="text-[11px] text-slate-500 mt-5">
                Proses audit mendalam memerlukan waktu 8 - 25 detik. Mohon jangan menutup halaman ini.
            </p>
        </div>
    </div>

    <!-- Official Institutional Footer -->
    <footer class="bg-white border-t border-slate-200 mt-12 py-8 text-xs text-slate-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3 text-center md:text-left">
                    <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab HSU" class="h-9 w-auto object-contain shrink-0 hidden sm:block">
                    <div>
                        <p class="font-bold text-navy-900 text-sm">
                            HSU SENTINEL &bull; Portal Audit & Monitoring Keamanan Siber Daerah
                        </p>
                        <p class="text-slate-500 mt-0.5">
                            &copy; {{ date('Y') }} Dinas Komunikasi, Informatika dan Persandian Pemerintah Kabupaten Hulu Sungai Utara
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-[11px] font-medium text-slate-500">
                    <span>Standar Kepatuhan: BSSN RI No. 8/2020</span>
                    <span>&bull;</span>
                    <span>SPBE Keamanan Informasi</span>
                    <span>&bull;</span>
                    <span class="font-mono text-gov-700">Python 3 & Laravel Engine</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Client-Side Scripts -->
    <script>
        // Real-time Clock (WITA)
        function updateClock() {
            const now = new Date();
            // Format time in WITA (UTC+8)
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WITA';
            const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });
            
            const clockEl = document.getElementById('liveTime');
            const dateEl = document.getElementById('liveDate');
            if (clockEl) clockEl.textContent = timeStr;
            if (dateEl) dateEl.textContent = dateStr;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // OPD Selector & Target Helpers
        function handleOpdChange(selectEl) {
            const val = selectEl.value;
            const customContainer = document.getElementById('customUrlContainer');
            const customInput = document.getElementById('customUrlInput');
            const urlInput = document.getElementById('urlInput');
            const previewEl = document.getElementById('targetPreviewUrl');

            if (val === 'custom') {
                customContainer.classList.remove('hidden');
                customInput.focus();
                const currentCustom = customInput.value.trim();
                urlInput.value = currentCustom;
                previewEl.textContent = currentCustom || '(Ketik URL kustom di atas)';
            } else {
                customContainer.classList.add('hidden');
                urlInput.value = val;
                previewEl.textContent = val;
            }
            highlightActiveOpdChip(val);
        }

        const ALLOWED_ROOTS = [
            'hsu.go.id',
            'kab-hulusungaiutara.kpu.go.id',
            'pa-amuntai.go.id',
            'pn-amuntai.go.id',
            'hulusungaiutara.kalsel.polri.go.id',
            'hulusungaiutara.bawaslu.go.id',
            'hulusungaiutarakab.bps.go.id',
            'hsu.bps.go.id'
        ];

        function normalizeTargetUrl(u) {
            return (u || '').replace(/\/+$/, '').toLowerCase();
        }

        function setOpdTarget(url) {
            const selectEl = document.getElementById('opdSelect');
            const urlInput = document.getElementById('urlInput');
            const previewEl = document.getElementById('targetPreviewUrl');
            const customContainer = document.getElementById('customUrlContainer');

            let found = false;
            const normUrl = normalizeTargetUrl(url);
            for (let i = 0; i < selectEl.options.length; i++) {
                if (normalizeTargetUrl(selectEl.options[i].value) === normUrl) {
                    selectEl.selectedIndex = i;
                    found = true;
                    break;
                }
            }

            if (!found) {
                selectEl.value = 'custom';
                customContainer.classList.remove('hidden');
                document.getElementById('customUrlInput').value = url;
            } else {
                customContainer.classList.add('hidden');
            }

            urlInput.value = url;
            previewEl.textContent = url;
            highlightActiveOpdChip(url);
        }

        // Backward compatibility
        function setTarget(url) {
            setOpdTarget(url);
        }

        function switchToCustomMode() {
            const selectEl = document.getElementById('opdSelect');
            selectEl.value = 'custom';
            handleOpdChange(selectEl);
        }

        function isHsuDomain(urlStr) {
            if (!urlStr) return false;
            let clean = urlStr.trim();
            if (!clean.startsWith('http://') && !clean.startsWith('https://')) {
                clean = 'https://' + clean;
            }
            try {
                const parsed = new URL(clean);
                let host = parsed.hostname.toLowerCase();
                if (host.includes(':')) {
                    host = host.split(':')[0];
                }
                return ALLOWED_ROOTS.some(root => host === root || host.endsWith('.' + root));
            } catch (e) {
                return false;
            }
        }

        function cancelCustomUrl() {
            const selectEl = document.getElementById('opdSelect');
            selectEl.selectedIndex = 0; // Default to first option
            handleOpdChange(selectEl);
            const warningEl = document.getElementById('domainWarningText');
            const inputBox = document.getElementById('customUrlInputBox');
            if (warningEl) warningEl.classList.add('hidden');
            if (inputBox) {
                inputBox.classList.remove('border-rose-400', 'bg-rose-50/40');
                inputBox.classList.add('border-slate-300');
            }
        }

        function handleCustomUrlInput(val) {
            let cleanVal = val.trim();
            if (cleanVal && !cleanVal.startsWith('http://') && !cleanVal.startsWith('https://')) {
                cleanVal = 'https://' + cleanVal;
            }
            document.getElementById('urlInput').value = cleanVal;
            document.getElementById('targetPreviewUrl').textContent = cleanVal || '(Ketik URL kustom di atas)';

            const warningEl = document.getElementById('domainWarningText');
            const inputBox = document.getElementById('customUrlInputBox');
            if (val.trim().length > 6 && !isHsuDomain(val.trim())) {
                if (warningEl) warningEl.classList.remove('hidden');
                if (inputBox) {
                    inputBox.classList.add('border-rose-400', 'bg-rose-50/40');
                    inputBox.classList.remove('border-slate-300');
                }
            } else {
                if (warningEl) warningEl.classList.add('hidden');
                if (inputBox) {
                    inputBox.classList.remove('border-rose-400', 'bg-rose-50/40');
                    inputBox.classList.add('border-slate-300');
                }
            }
        }

        function highlightActiveOpdChip(activeUrl) {
            document.querySelectorAll('.opd-chip').forEach(chip => {
                const text = chip.textContent.trim();
                if (activeUrl && activeUrl.includes(text)) {
                    chip.className = 'opd-chip text-xs font-mono text-gov-800 bg-gov-100 border border-gov-300 px-2.5 py-1 rounded-md font-bold shadow-sm';
                } else {
                    chip.className = 'opd-chip text-xs font-mono text-slate-600 bg-slate-100 hover:bg-gov-50 hover:text-gov-800 hover:border-gov-300 border border-slate-200 px-2.5 py-1 rounded-md transition-colors font-medium';
                }
            });
        }

        // History Table Interactive Filter & Search
        let currentHistoryCategory = 'all';

        function setHistoryCategory(category, buttonEl) {
            currentHistoryCategory = category;
            
            // Update active styles on chips
            document.querySelectorAll('.history-chip').forEach(btn => {
                btn.className = 'history-chip px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200';
            });
            
            buttonEl.className = 'history-chip active px-3 py-1.5 rounded-lg text-xs font-bold transition-all bg-gov-700 text-white shadow-sm';
            applyHistoryFilters();
        }

        function clearHistorySearch() {
            const input = document.getElementById('searchHistoryInput');
            if (input) {
                input.value = '';
                document.getElementById('clearSearchBtn')?.classList.add('hidden');
                applyHistoryFilters();
                input.focus();
            }
        }

        function resetAllHistoryFilters() {
            const input = document.getElementById('searchHistoryInput');
            if (input) input.value = '';
            document.getElementById('clearSearchBtn')?.classList.add('hidden');
            const allBtn = document.querySelector('.history-chip[data-cat="all"]');
            if (allBtn) {
                setHistoryCategory('all', allBtn);
            } else {
                currentHistoryCategory = 'all';
                applyHistoryFilters();
            }
        }

        function applyHistoryFilters() {
            const query = (document.getElementById('searchHistoryInput')?.value || '').toLowerCase().trim();
            const clearBtn = document.getElementById('clearSearchBtn');
            if (clearBtn) {
                if (query.length > 0) clearBtn.classList.remove('hidden');
                else clearBtn.classList.add('hidden');
            }

            const rows = document.querySelectorAll('.history-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const url = (row.getAttribute('data-url') || '').toLowerCase();
                const category = row.getAttribute('data-category') || 'all';

                const matchesQuery = query === '' || url.includes(query);
                const matchesCategory = currentHistoryCategory === 'all' || category === currentHistoryCategory;

                if (matchesQuery && matchesCategory) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noMatchEl = document.getElementById('noMatchRow');
            if (noMatchEl) {
                if (visibleCount === 0 && rows.length > 0) {
                    noMatchEl.classList.remove('hidden');
                } else {
                    noMatchEl.classList.add('hidden');
                }
            }
        }

        // Scanning Steps Animation Helpers
        function completeStep(stepId, label) {
            const el = document.getElementById(stepId);
            if (el) {
                el.className = 'flex items-center space-x-2 text-emerald-700 font-medium';
                el.innerHTML = '<svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>' + label + '</span>';
            }
        }

        function activateStep(stepId) {
            const el = document.getElementById(stepId);
            if (el) {
                el.className = 'flex items-center space-x-2 text-gov-700 font-medium';
                el.children[0].className = 'w-2 h-2 rounded-full bg-gov-600 animate-pulse';
            }
        }

        // Form Submit Handler
        document.getElementById('scanForm').addEventListener('submit', function(e) {
            const selectEl = document.getElementById('opdSelect');
            let url = document.getElementById('urlInput').value.trim();

            if (selectEl && selectEl.value === 'custom') {
                const customVal = (document.getElementById('customUrlInput')?.value || '').trim();
                if (!customVal) {
                    e.preventDefault();
                    alert('Silakan masukkan alamat URL target audit terlebih dahulu.');
                    document.getElementById('customUrlInput')?.focus();
                    return;
                }
                if (!customVal.startsWith('http://') && !customVal.startsWith('https://')) {
                    url = 'https://' + customVal;
                } else {
                    url = customVal;
                }
                document.getElementById('urlInput').value = url;
            }

            if (!url) {
                e.preventDefault();
                alert('Silakan pilih atau masukkan URL target audit.');
                return;
            }

            // Validasi Kunci Domain HSU & Whitelist di Sisi Klien
            if (!isHsuDomain(url)) {
                e.preventDefault();
                alert('Akses Ditolak: Sistem HSU Sentinel dikunci khusus untuk mengaudit website resmi Pemerintah Kabupaten Hulu Sungai Utara (*.hsu.go.id) serta instansi vertikal HSU yang terdaftar di whitelist (KPU, Bawaslu, PA/PN Amuntai, Polres, BPS). Target domain selain HSU tidak diizinkan.');
                const customInput = document.getElementById('customUrlInput');
                if (customInput) customInput.focus();
                return;
            }

            // Show Scanning Modal
            const overlay = document.getElementById('scanningOverlay');
            document.getElementById('scanningTargetUrl').textContent = url;
            overlay.classList.remove('hidden');

            // Staggered Step Animations
            setTimeout(() => {
                completeStep('step1', '1. Koneksi host & SSL berhasil diverifikasi');
                activateStep('step2');
            }, 1500);

            setTimeout(() => {
                completeStep('step2', '2. HTTP Security Headers terverifikasi');
                activateStep('step3');
            }, 3000);

            setTimeout(() => {
                completeStep('step3', '3. Pemindaian file sensitif selesai');
                activateStep('step4');
            }, 4500);

            setTimeout(() => {
                completeStep('step4', '4. Deteksi web shell selesai');
                activateStep('step5');
            }, 6000);

            setTimeout(() => {
                completeStep('step5', '5. Pengujian SQL Injection selesai');
                activateStep('step6');
            }, 8000);

            setTimeout(() => {
                completeStep('step6', '6. Pemeriksaan brute-force selesai');
                activateStep('step7');
            }, 10000);

            setTimeout(() => {
                completeStep('step7', '7. Audit file integrity selesai');
                activateStep('step8');
            }, 12000);
        });
    </script>
</body>
</html>