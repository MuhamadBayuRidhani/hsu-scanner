<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Audit Keamanan Siber | HSU Sentinel - Diskominfo Kab. HSU</title>
    
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
            box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 1px 2px -1px rgba(15, 23, 42, 0.03);
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
    </style>
</head>
<body class="text-slate-800 min-h-screen flex flex-col font-sans selection:bg-blue-600 selection:text-white antialiased">

    <!-- Top Gov Banner Strip -->
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
                                LAPORAN RESMI
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-1 truncate">
                            Dinas Komunikasi, Informatika dan Persandian Kab. Hulu Sungai Utara
                        </p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-1.5 px-3 sm:px-3.5 py-2 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-700 shadow-sm hover:border-slate-400 transition-all">
                    <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="hidden sm:inline">Dashboard Audit</span>
                </a>

                <a href="{{ route('scan.reports') }}" class="hidden md:inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-lg bg-gov-700 text-white text-xs font-bold shadow-sm hover:bg-gov-800 transition-all">
                    <svg class="w-4 h-4 text-gov-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Rekapitulasi Laporan</span>
                </a>

                <a href="{{ route('scan.reports.print', array_merge(request()->query(), ['mode' => 'resmi'])) }}" target="_blank" title="Cetak ringkasan eksekutif & tabel rekapitulasi resmi" class="inline-flex items-center space-x-1.5 px-3.5 sm:px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm hover:shadow transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak PDF Resmi</span>
                </a>

                <a href="{{ route('account.index') }}" class="inline-flex items-center space-x-1.5 px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 text-xs font-bold transition-all" title="Kelola Akun & Tambah User">
                    <svg class="w-4 h-4 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="hidden lg:inline">Akun</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center space-x-1 px-3 py-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition-colors" title="Keluar dari Sistem">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <!-- Flash Success Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start space-x-3 shadow-xs">
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

        <!-- Page Header Banner -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-gov-100 text-gov-800 text-xs font-semibold mb-2">
                        <span class="w-2 h-2 rounded-full bg-gov-600"></span>
                        <span>Modul Pelaporan Resmi Keamanan Informasi & Kepatuhan Siber</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-900 tracking-tight">
                        Laporan Rekapitulasi Audit Keamanan Portal Web OPD
                    </h2>
                    <p class="text-sm text-slate-600 mt-1 max-w-3xl leading-relaxed">
                        Dokumen rekapitulasi evaluasi keamanan siber seluruh instansi, dinas, badan, kecamatan, dan puskesmas di lingkungan Pemerintah Kabupaten Hulu Sungai Utara berdasarkan parameter pengujian kerentanan.
                    </p>
                </div>

                <!-- Print & Export Action Buttons -->
                <div class="shrink-0 flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('scan.reports.print', array_merge(request()->query(), ['mode' => 'lengkap'])) }}" target="_blank" title="Cetak laporan lengkap disertai analisis kerentanan & rincian teknis per website OPD" class="inline-flex items-center space-x-2 bg-gov-700 hover:bg-gov-800 text-white font-bold text-xs uppercase tracking-wider px-5 py-3 rounded-lg shadow-sm transition-all hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Cetak Laporan Lengkap (PDF)</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 Summary Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Data -->
            <div class="gov-card rounded-xl p-5 relative overflow-hidden flex flex-col justify-between h-full">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Audit Terfilter</p>
                        <h3 class="text-3xl font-extrabold text-navy-900 mt-1.5 font-mono leading-none">
                            {{ number_format($totalCount) }}
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-2">Situs web tercatat dalam log</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-gov-50 border border-gov-200 flex items-center justify-center text-gov-700 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Skor -->
            @php
                if ($avgScore >= 80) {
                    $avgBadge = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                    $avgLabel = 'Predikat Optimal';
                } elseif ($avgScore >= 50) {
                    $avgBadge = 'bg-amber-50 text-amber-800 border-amber-200';
                    $avgLabel = 'Predikat Waspada';
                } else {
                    $avgBadge = 'bg-rose-50 text-rose-800 border-rose-200';
                    $avgLabel = 'Predikat Kritis';
                }
            @endphp
            <div class="gov-card rounded-xl p-5 relative overflow-hidden flex flex-col justify-between h-full">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Rata-Rata Indeks</p>
                        <div class="flex items-baseline space-x-1.5 mt-1.5 leading-none">
                            <h3 class="text-3xl font-extrabold text-navy-900 font-mono leading-none">{{ $avgScore }}</h3>
                            <span class="text-xs text-slate-500 font-mono">/ 100</span>
                        </div>
                        <span class="inline-block px-2 py-0.5 mt-2 rounded text-[10px] font-bold border {{ $avgBadge }}">
                            {{ $avgLabel }}
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-700 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Memenuhi Standar -->
            <div class="gov-card rounded-xl p-5 relative overflow-hidden flex flex-col justify-between h-full">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Status Optimal (Aman)</p>
                        <h3 class="text-3xl font-extrabold text-emerald-600 mt-1.5 font-mono leading-none">
                            {{ $secureCount }}
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-2">Skor ≥ 80 Poin (Good Security)</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Perlu Perhatian / Kritis -->
            <div class="gov-card rounded-xl p-5 relative overflow-hidden flex flex-col justify-between h-full">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Perlu Remidiasi Celah</p>
                        <h3 class="text-3xl font-extrabold text-rose-600 mt-1.5 font-mono leading-none">
                            {{ $criticalCount + $warningCount }}
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-2">
                            {{ $criticalCount }} Kritis (&lt;50) &bull; {{ $warningCount }} Waspada (50-79)
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Panel -->
        <div class="gov-card rounded-2xl p-6 mb-8 bg-white">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gov-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                        Parameter Filter Laporan
                    </h3>
                </div>
                <span class="text-xs text-slate-500">
                    Menampilkan <strong>{{ $totalCount }}</strong> baris data laporan
                </span>
            </div>

            <form action="{{ route('scan.reports') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3.5 items-end">
                <!-- Filter Tanggal Mulai -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Dari Tanggal
                    </label>
                    <input 
                        type="date" 
                        name="start_date" 
                        value="{{ request('start_date') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-mono text-slate-800 focus:outline-none focus:border-gov-600 focus:bg-white"
                    >
                </div>

                <!-- Filter Tanggal Selesai -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Sampai Tanggal
                    </label>
                    <input 
                        type="date" 
                        name="end_date" 
                        value="{{ request('end_date') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-mono text-slate-800 focus:outline-none focus:border-gov-600 focus:bg-white"
                    >
                </div>

                <!-- Filter Kategori OPD / Group -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Kategori Instansi
                    </label>
                    <select 
                        name="group" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-gov-600 focus:bg-white cursor-pointer"
                    >
                        <option value="all">Semua Kategori Instansi</option>
                        @foreach($catalog as $groupName => $groupData)
                            <option value="{{ $groupName }}" {{ request('group') == $groupName ? 'selected' : '' }}>
                                {{ $groupName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Predikat Keamanan -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Predikat Keamanan
                    </label>
                    <select 
                        name="grade" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-gov-600 focus:bg-white cursor-pointer"
                    >
                        <option value="all" {{ request('grade') == 'all' ? 'selected' : '' }}>Semua Predikat</option>
                        <option value="secure" {{ request('grade') == 'secure' ? 'selected' : '' }}>Aman / Optimal (≥80)</option>
                        <option value="warning" {{ request('grade') == 'warning' ? 'selected' : '' }}>Waspada (50-79)</option>
                        <option value="critical" {{ request('grade') == 'critical' ? 'selected' : '' }}>Kritis (<50)</option>
                    </select>
                </div>

                <!-- Search Input -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                        Cari Domain / URL
                    </label>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Contoh: dinkes..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-mono text-slate-800 focus:outline-none focus:border-gov-600 focus:bg-white"
                    >
                </div>

                <!-- Buttons -->
                <div class="flex items-center space-x-2">
                    <button 
                        type="submit" 
                        class="flex-1 inline-flex items-center justify-center space-x-1.5 bg-gov-700 hover:bg-gov-800 text-white font-bold text-xs py-2.5 px-4 rounded-lg shadow-2xs transition-all"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>Filter</span>
                    </button>
                    <a 
                        href="{{ route('scan.reports') }}" 
                        class="inline-flex items-center justify-center p-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 border border-slate-200 transition-colors"
                        title="Reset Filter"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- Top 5 Common Vulnerabilities Insight Panel -->
        @if(count($topVulnerabilities) > 0)
            <div class="gov-card rounded-2xl p-6 mb-8 bg-white border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                                Top 5 Kerentanan Paling Banyak Ditemukan pada Portal OPD HSU
                            </h4>
                            <p class="text-[11px] text-slate-500">
                                Berdasarkan data riwayat pengujian aktif pada sistem audit
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    @foreach($topVulnerabilities as $vulnName => $count)
                        @php
                            $pct = round(($count / max(1, $totalCount)) * 100);
                        @endphp
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex flex-col justify-between">
                            <div>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 mb-1.5">
                                    {{ $count }} Kasus ({{ $pct }}%)
                                </span>
                                <p class="text-xs font-bold text-slate-800 line-clamp-2">
                                    {{ $vulnName }}
                                </p>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-1 mt-3 overflow-hidden">
                                <div class="bg-rose-500 h-1 rounded-full" style="width: {{ min(100, $pct) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Laporan Table -->
        <div class="gov-card rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-xs">
            <div class="p-5 sm:p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gov-50 border border-gov-200 flex items-center justify-center text-gov-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight">
                            Tabel Rekapitulasi Audit Keamanan Siber
                        </h3>
                        <p class="text-xs text-slate-500">
                            Daftar lengkap hasil audit keamanan situs instansi Pemerintah Kabupaten Hulu Sungai Utara
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <form action="{{ route('scan.cleanup.duplicates') }}" method="POST" onsubmit="return confirm('Bersihkan seluruh riwayat audit lama dan hanya sisakan 1 hasil audit paling baru untuk setiap website OPD?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg {{ ($duplicateCount ?? 0) > 0 ? 'bg-amber-50 hover:bg-amber-100 text-amber-800 border-amber-300' : 'bg-slate-100 hover:bg-rose-50 text-slate-700 hover:text-rose-700 border-slate-200 hover:border-rose-200' }} text-xs font-bold border transition-colors" title="Hapus hasil scan lama yang berulang dan hanya sisakan 1 audit terbaru per domain">
                            <svg class="w-3.5 h-3.5 {{ ($duplicateCount ?? 0) > 0 ? 'text-amber-600' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Bersihkan Riwayat Lama</span>
                            @if(($duplicateCount ?? 0) > 0)
                                <span class="px-1.5 py-0.2 rounded-full bg-amber-200/80 text-amber-900 font-mono text-[10px]">{{ $duplicateCount }}</span>
                            @endif
                        </button>
                    </form>
                    <a href="{{ route('scan.reports.print', array_merge(request()->query(), ['mode' => 'resmi'])) }}" target="_blank" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-200 transition-colors" title="Cetak ringkasan tabel rekapitulasi resmi">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        <span>Cetak Ringkasan Resmi</span>
                    </a>
                    <a href="{{ route('scan.reports.print', array_merge(request()->query(), ['mode' => 'lengkap'])) }}" target="_blank" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-gov-50 hover:bg-gov-100 text-gov-800 text-xs font-bold border border-gov-200 transition-colors" title="Cetak laporan lengkap disertai lampiran rincian temuan tiap website">
                        <svg class="w-3.5 h-3.5 text-gov-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Cetak Rincian Lengkap</span>
                    </a>
                </div>
            </div>

            @if(count($allScans) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                                <th class="py-3.5 px-4 w-12 text-center">No</th>
                                <th class="py-3.5 px-4">Instansi & Website Target</th>
                                <th class="py-3.5 px-4">Kategori OPD</th>
                                <th class="py-3.5 px-4 text-center">Skor</th>
                                <th class="py-3.5 px-4">Predikat & Status</th>
                                <th class="py-3.5 px-4 text-center">Parameter Lolos</th>
                                <th class="py-3.5 px-4 text-center">Temuan Celah</th>
                                <th class="py-3.5 px-4">Waktu Audit</th>
                                <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($allScans as $idx => $scan)
                                @php
                                    $host = strtolower(parse_url($scan->url, PHP_URL_HOST) ?? '');
                                    $agencyInfo = $agencyMap[$host] ?? null;
                                    $agencyName = $agencyInfo['name'] ?? $host;
                                    $agencyGroup = $agencyInfo['group'] ?? 'Website Daerah';

                                    $score = $scan->score;
                                    if ($score >= 85) {
                                        $grade = 'A+';
                                        $gradeBadge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                        $gradeDot = 'bg-emerald-500';
                                        $statusText = 'Optimal (Aman)';
                                    } elseif ($score >= 70) {
                                        $grade = 'B';
                                        $gradeBadge = 'bg-blue-50 text-blue-700 border-blue-200';
                                        $gradeDot = 'bg-blue-500';
                                        $statusText = 'Cukup Baik';
                                    } elseif ($score >= 50) {
                                        $grade = 'C';
                                        $gradeBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                                        $gradeDot = 'bg-amber-500';
                                        $statusText = 'Perlu Perhatian';
                                    } else {
                                        $grade = 'F';
                                        $gradeBadge = 'bg-rose-50 text-rose-700 border-rose-200';
                                        $gradeDot = 'bg-rose-500';
                                        $statusText = 'Kritis & Rentan';
                                    }

                                    $passedList = $scan->header_results ?? [];
                                    $failedList = $scan->file_results ?? [];
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-3.5 px-4 text-center font-mono text-slate-500">
                                        {{ $idx + 1 }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-slate-900 text-xs">
                                            {{ $agencyName }}
                                        </div>
                                        <a href="{{ $scan->url }}" target="_blank" class="font-mono text-[11px] text-gov-700 hover:text-gov-900 hover:underline flex items-center space-x-1 mt-0.5">
                                            <span>{{ $scan->url }}</span>
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $agencyGroup }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="font-mono font-extrabold text-sm {{ $score >= 80 ? 'text-emerald-700' : ($score >= 50 ? 'text-amber-700' : 'text-rose-700') }}">
                                            {{ $score }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-mono block">/100</span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold border {{ $gradeBadge }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $gradeDot }}"></span>
                                            <span>{{ $grade }} - {{ $statusText }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded font-mono font-bold text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            {{ count($passedList) }} Lolos
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if(count($failedList) > 0)
                                            <span class="inline-block px-2 py-0.5 rounded font-mono font-bold text-xs bg-rose-50 text-rose-700 border border-rose-200">
                                                {{ count($failedList) }} Temuan
                                            </span>
                                        @else
                                            <span class="inline-block px-2 py-0.5 rounded font-mono font-bold text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                0 (Nihil)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px] whitespace-nowrap">
                                        {{ $scan->created_at ? $scan->created_at->format('d/m/Y H:i') : '-' }} WITA
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-1.5">
                                            <!-- View Detail -->
                                            <a 
                                                href="{{ route('scan.history', $scan->id) }}" 
                                                class="inline-flex items-center space-x-1 px-2.5 py-1.5 rounded-lg bg-gov-50 hover:bg-gov-100 text-gov-700 border border-gov-200 text-xs font-semibold transition-colors"
                                                title="Lihat Detail Hasil Audit"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <span>Detail</span>
                                            </a>

                                            <!-- Delete Form -->
                                            <form action="{{ route('scan.destroy', $scan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data audit {{ $scan->url }} ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors"
                                                    title="Hapus Riwayat Ini"
                                                >
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
            @else
                <div class="py-16 text-center">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h4 class="text-sm font-bold text-slate-700">Tidak Ada Data Audit yang Cocok</h4>
                    <p class="text-xs text-slate-500 mt-1">Coba sesuaikan filter rentang tanggal, predikat, atau kata kunci pencarian Anda.</p>
                    <a href="{{ route('scan.reports') }}" class="inline-block mt-4 px-4 py-2 rounded-lg bg-gov-700 text-white text-xs font-bold hover:bg-gov-800 transition-colors">
                        Reset Semua Filter
                    </a>
                </div>
            @endif
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-xs text-slate-500 mt-12">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab HSU" class="h-5 w-auto object-contain">
                <p>&copy; {{ date('Y') }} Dinas Komunikasi, Informatika dan Persandian Kab. Hulu Sungai Utara</p>
            </div>
            <p class="font-mono text-[11px] text-slate-400">Cyber Defense & Security Assurance Division</p>
        </div>
    </footer>

</body>
</html>
