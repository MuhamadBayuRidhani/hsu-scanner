<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Memastikan minimal ada 1 akun Administrator default jika tabel users masih kosong.
     */
    public static function ensureDefaultAdmin(): void
    {
        try {
            if (User::count() === 0) {
                User::create([
                    'name'     => 'Administrator Diskominfo HSU',
                    'email'    => 'admin@hsu.go.id',
                    'password' => Hash::make('admin12345'),
                ]);
            }
        } catch (\Throwable $e) {
            // Abaikan jika koneksi DB belum siap
        }
    }

    /**
     * Menampilkan halaman form login resmi HSU Sentinel.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        self::ensureDefaultAdmin();

        return view('auth.login');
    }

    /**
     * Memproses autentikasi login dengan proteksi Rate Limiting (Anti Brute-Force).
     */
    public function login(Request $request)
    {
        self::ensureDefaultAdmin();

        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('error', "Terlalu banyak percobaan login gagal. Silakan tunggu {$seconds} detik sebelum mencoba kembali.");
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        RateLimiter::hit($throttleKey, 60);

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Email atau kata sandi yang Anda masukkan salah.');
    }

    /**
     * Keluar dari sesi pengguna (Logout).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sesi HSU Sentinel.');
    }

    /**
     * Halaman Manajemen Akun (Ganti Password & Tambah User Baru).
     */
    public function showAccount()
    {
        $user = Auth::user();
        $users = User::orderBy('id')->get();

        return view('auth.account', compact('user', 'users'));
    }

    /**
     * Memperbarui profil & mengganti password pengguna yang sedang login.
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['required', 'string'],
            'new_password'     => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Masukkan kata sandi saat ini untuk konfirmasi perubahan.',
            'new_password.min'          => 'Kata sandi baru minimal 6 karakter.',
            'new_password.confirmed'    => 'Konfirmasi kata sandi baru tidak cocok.',
            'email.unique'              => 'Email tersebut sudah digunakan oleh akun lain.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Kata sandi saat ini yang Anda masukkan tidak sesuai.');
        }

        $user->name = trim($request->name);
        $user->email = strtolower(trim($request->email));

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with(
            'success',
            $request->filled('new_password')
                ? 'Profil dan kata sandi Anda berhasil diperbarui.'
                : 'Data profil Anda berhasil diperbarui.'
        );
    }

    /**
     * Menambahkan akun petugas / user baru.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Nama lengkap petugas wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.unique'       => 'Alamat email ini sudah terdaftar.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $newUser = User::create([
            'name'     => trim($request->name),
            'email'    => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'User baru "' . $newUser->name . '" (' . $newUser->email . ') berhasil ditambahkan.');
    }

    /**
     * Menghapus akun user lain.
     */
    public function destroyUser($id)
    {
        if ((int) Auth::id() === (int) $id) {
            return back()->with('error', 'Aksi ditolak: Anda tidak dapat menghapus akun yang sedang Anda gunakan untuk login.');
        }

        $target = User::findOrFail($id);
        $targetName = $target->name;
        $target->delete();

        return back()->with('success', 'Akun user "' . $targetName . '" berhasil dihapus dari sistem.');
    }
}

