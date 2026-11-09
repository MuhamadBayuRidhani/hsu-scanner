<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Sistem Audit Keamanan Siber | HSU Sentinel - Diskominfo Kab. HSU</title>

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
            background-image:
                radial-gradient(at 0% 0%, rgba(3, 91, 160, 0.07) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(15, 23, 42, 0.06) 0px, transparent 50%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between font-sans text-slate-800 antialiased selection:bg-gov-600 selection:text-white">

    <!-- Top Institutional Red-White-Blue Strip -->
    <div class="h-1.5 bg-gradient-to-r from-red-600 via-white to-blue-700 w-full"></div>

    <!-- Main Centered Login Section -->
    <main class="flex-1 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">

            <!-- Brand Identity Header -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center mb-3">
                    <div class="p-2.5 rounded-2xl bg-white/90 border border-slate-200 shadow-md shadow-slate-900/5">
                        <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab Hulu Sungai Utara" class="h-20 w-auto object-contain drop-shadow-sm transition-transform duration-200 hover:scale-105">
                    </div>
                </div>
                <div class="flex items-center justify-center space-x-2">
                    <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-navy-900">
                        HSU SENTINEL
                    </h1>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gov-100 text-gov-800 border border-gov-200">
                        PORTAL PETUGAS
                    </span>
                </div>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Dinas Komunikasi, Informatika dan Persandian Kab. Hulu Sungai Utara
                </p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xl shadow-slate-900/5 overflow-hidden">
                <div class="bg-gradient-to-r from-navy-900 via-navy-850 to-gov-900 px-6 py-4 text-white flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold tracking-wide uppercase">Autentikasi Petugas Audit</h2>
                        <p class="text-[11px] text-slate-300 mt-0.5">Masuk untuk mengakses sistem pemindaian &amp; laporan keamanan</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-gov-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                <div class="p-6 sm:p-7">
                    <!-- Flash Success -->
                    @if(session('success'))
                        <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-start space-x-2.5">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Flash Error / Validation Error -->
                    @if(session('error') || $errors->any())
                        <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start space-x-2.5">
                            <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="font-bold text-rose-900">Gagal Masuk</p>
                                <p class="mt-0.5">{{ session('error') ?? $errors->first() }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Alamat Email Petugas
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', 'admin@hsu.go.id') }}"
                                    required
                                    autofocus
                                    placeholder="admin@hsu.go.id"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white focus:ring-2 focus:ring-gov-500/15 transition-all"
                                >
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="••••••••"
                                    class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono text-slate-900 focus:outline-none focus:border-gov-600 focus:bg-white focus:ring-2 focus:ring-gov-500/15 transition-all"
                                >
                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700"
                                    title="Tampilkan / Sembunyikan Kata Sandi"
                                >
                                    <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between pt-1">
                            <label class="inline-flex items-center space-x-2 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                    {{ old('remember') ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-gov-700 focus:ring-gov-500 w-3.5 h-3.5"
                                >
                                <span class="text-xs text-slate-600 font-medium">Ingat sesi perangkat ini</span>
                            </label>
                            <span class="text-[11px] font-mono text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded">
                                Rate-Limit Aktif
                            </span>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-gov-700 hover:bg-gov-800 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-gov-700/20 hover:shadow-lg transition-all flex items-center justify-center space-x-2"
                        >
                            <span>Masuk ke Dashboard Audit</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-5 text-center text-xs text-slate-500 flex flex-col items-center justify-center space-y-1.5">
        <div class="flex items-center space-x-2 text-[11px] font-medium text-slate-600">
            <img src="{{ asset('images/logo-hsu.png') }}" alt="Logo Pemkab HSU" class="h-4 w-auto object-contain">
            <span>Pemerintah Kabupaten Hulu Sungai Utara</span>
        </div>
        <p>&copy; {{ date('Y') }} Dinas Komunikasi, Informatika dan Persandian Kab. Hulu Sungai Utara</p>
    </footer>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
</body>
</html>

