<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun & Petugas | HSU Sentinel - Diskominfo Kab. HSU</title>
    
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
        }
    </style>
</head>
<body class="text-slate-800 min-h-screen flex flex-col font-sans selection:bg-blue-600 selection:text-white antialiased">

    <!-- Top Gov Banner Strip -->
    <div class="h-1 bg-gradient-to-r from-red-600 via-white to-blue-700 w-full"></div>

    <!-- Header Navigation -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <div class="flex items-center min-w-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3.5 group min-w-0">
                    <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab Hulu Sungai Utara" class="h-11 sm:h-12 w-auto object-contain drop-shadow-sm transition-transform duration-200 group-hover:scale-105 shrink-0">
                    <div class="min-w-0">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-base sm:text-lg font-extrabold tracking-tight text-navy-900 leading-none truncate">
                                HSU SENTINEL
                            </h1>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gov-100 text-gov-800 border border-gov-200 shrink-0">
                                MANAJEMEN AKUN
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
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-1.5 px-3 sm:px-3.5 py-2 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-700 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="hidden sm:inline">Dashboard Audit</span>
                </a>

                <a href="{{ route('scan.reports') }}" class="inline-flex items-center space-x-1.5 px-3 sm:px-3.5 py-2 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-700 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="hidden sm:inline">Laporan Rekap</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition-colors">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <!-- Flash Success -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start space-x-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-bold text-emerald-900">Berhasil</p>
                    <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Flash Error / Validation Errors -->
        @if(session('error') || $errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start space-x-3 shadow-xs">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-bold text-rose-900">Perhatian</p>
                    <p class="text-xs text-rose-700 mt-0.5">{{ session('error') ?? $errors->first() }}</p>
                </div>
            </div>
        @endif

        <!-- Page Heading -->
        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-navy-900 tracking-tight">
                Pengaturan Akun, Ganti Kata Sandi &amp; Manajemen Petugas
            </h2>
            <p class="text-sm text-slate-600 mt-1">
                Kelola kredensial akun Anda, perbarui kata sandi keamanan, atau tambahkan akun petugas audit baru.
            </p>
        </div>

        <!-- 2 Column Grid: Left = Ganti Password, Right = Tambah User Baru -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Card 1: Ganti Password & Profil Saya -->
            <div class="gov-card rounded-2xl p-6">
                <div class="flex items-center space-x-3 pb-4 mb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-gov-50 border border-gov-200 text-gov-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Ubah Profil &amp; Ganti Kata Sandi Saya</h3>
                        <p class="text-xs text-slate-500">Sedang login sebagai: <strong class="font-mono text-gov-700">{{ $user->email }}</strong></p>
                    </div>
                </div>

                <form action="{{ route('account.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Alamat Email Login</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Kata Sandi Saat Ini <span class="text-rose-600">*</span>
                        </label>
                        <input type="password" name="current_password" required placeholder="Masukkan kata sandi lama Anda" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kata Sandi Baru</label>
                            <input type="password" name="new_password" placeholder="Min. 6 karakter" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Ulangi Kata Sandi Baru</label>
                            <input type="password" name="new_password_confirmation" placeholder="Konfirmasi sandi baru" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-400">Kosongkan kolom Kata Sandi Baru jika Anda hanya ingin mengubah nama atau alamat email.</p>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-gov-700 hover:bg-gov-800 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-xs">
                        Simpan Perubahan Profil &amp; Sandi
                    </button>
                </form>
            </div>

            <!-- Card 2: Buat User / Petugas Baru -->
            <div class="gov-card rounded-2xl p-6">
                <div class="flex items-center space-x-3 pb-4 mb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Tambah Akun User / Petugas Baru</h3>
                        <p class="text-xs text-slate-500">Buat kredensial login baru untuk petugas audit atau admin Diskominfo</p>
                    </div>
                </div>

                <form action="{{ route('account.users.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap Petugas <span class="text-rose-600">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Muhamad Bayu Ridhani" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Alamat Email Login <span class="text-rose-600">*</span></label>
                        <input type="email" name="email" required placeholder="Contoh: bayu@hsu.go.id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kata Sandi <span class="text-rose-600">*</span></label>
                            <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Konfirmasi Kata Sandi <span class="text-rose-600">*</span></label>
                            <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-xs">
                        + Buat Akun Petugas Baru
                    </button>
                </form>
            </div>

        </div>

        <!-- Daftar Seluruh User Terdaftar -->
        <div class="gov-card rounded-2xl overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Daftar Akun Petugas Terdaftar ({{ count($users) }})</h3>
                    <p class="text-xs text-slate-500">Seluruh pengguna yang memiliki akses ke dashboard HSU Sentinel</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Nama Petugas</th>
                            <th class="py-3 px-4">Email Login</th>
                            <th class="py-3 px-4">Terdaftar Pada</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $idx => $u)
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 px-4 text-center font-mono text-slate-500">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $u->name }}</td>
                                <td class="py-3 px-4 font-mono text-gov-700">{{ $u->email }}</td>
                                <td class="py-3 px-4 font-mono text-slate-500">{{ $u->created_at ? $u->created_at->format('d/m/Y H:i') : '-' }}</td>
                                <td class="py-3 px-4 text-center">
                                    @if($u->id === $user->id)
                                        <span class="inline-block px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px]">
                                            Akun Anda (Aktif)
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200 font-semibold text-[10px]">
                                            Petugas Terdaftar
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    @if($u->id !== $user->id)
                                        <form action="{{ route('account.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus akun petugas {{ $u->name }} ({{ $u->email }})?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold transition-colors">
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[11px] text-slate-400 italic">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500 mt-12">
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

