<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Models\ScanHistory;

class ScannerController extends Controller
{
    public function index()
    {
        $metrics = [
            'totalScans'    => 0,
            'avgScore'      => 0,
            'secureCount'   => 0,
            'warningCount'  => 0,
            'criticalCount' => 0,
        ];
        $recentScans = collect([]);
        $duplicateCount = 0;

        try {
            $metrics['totalScans']    = ScanHistory::count();
            $metrics['avgScore']      = (int) round(ScanHistory::avg('score') ?? 0);
            $metrics['secureCount']   = ScanHistory::where('score', '>=', 80)->count();
            $metrics['warningCount']  = ScanHistory::whereBetween('score', [50, 79])->count();
            $metrics['criticalCount'] = ScanHistory::where('score', '<', 50)->count();
            $recentScans = ScanHistory::latest()->take(30)->get();
            $duplicateCount = self::countDuplicateScans();
        } catch (\Throwable $e) {
            // Fallback aman jika database belum terhubung
        }

        $catalog = config('hsu.catalog', []);

        return view('scanner.index', compact('recentScans', 'metrics', 'catalog', 'duplicateCount'));
    }

    public function show($id)
    {
        $history = ScanHistory::findOrFail($id);
        $agencyMap = self::getAgencyMap();
        $host = strtolower(parse_url($history->url, PHP_URL_HOST) ?? '');
        $agency = $agencyMap[$host] ?? null;

        return view('scanner.result', compact('history', 'agency'));
    }

    public function destroy($id)
    {
        $history = ScanHistory::findOrFail($id);
        $targetUrl = $history->url;
        $history->delete();

        return back()->with('success', 'Riwayat audit untuk "' . $targetUrl . '" berhasil dihapus dari sistem.');
    }

    /**
     * Normalisasi domain agar variasi protokol/www/trailing-slash dikenali sebagai website yang sama.
     */
    public static function normalizeDomainKey(string $url): string
    {
        $host = strtolower(trim(parse_url($url, PHP_URL_HOST) ?? ''));
        if (empty($host)) {
            $host = strtolower(rtrim(trim($url), '/'));
        }
        if (str_starts_with($host, 'www.')) {
            $host = substr($host, 4);
        }
        return $host;
    }

    /**
     * Hitung jumlah riwayat audit lama (duplikat domain) yang dapat dibersihkan.
     */
    public static function countDuplicateScans(): int
    {
        try {
            $all = ScanHistory::orderByDesc('created_at')->orderByDesc('id')->get(['id', 'url']);
            $seen = [];
            $duplicates = 0;
            foreach ($all as $scan) {
                $key = self::normalizeDomainKey($scan->url);
                if (!isset($seen[$key])) {
                    $seen[$key] = true;
                } else {
                    $duplicates++;
                }
            }
            return $duplicates;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Menghapus seluruh riwayat audit lama dan hanya menyisakan 1 hasil audit paling baru untuk setiap domain.
     */
    public function cleanupOldDuplicates()
    {
        $all = ScanHistory::orderByDesc('created_at')->orderByDesc('id')->get(['id', 'url', 'created_at']);
        $seen = [];
        $idsToDelete = [];

        foreach ($all as $scan) {
            $key = self::normalizeDomainKey($scan->url);
            if (!isset($seen[$key])) {
                $seen[$key] = $scan->id;
            } else {
                $idsToDelete[] = $scan->id;
            }
        }

        if (!empty($idsToDelete)) {
            ScanHistory::whereIn('id', $idsToDelete)->delete();
            return back()->with(
                'success',
                'Berhasil membersihkan ' . count($idsToDelete) . ' riwayat audit lama. Sistem kini hanya menyimpan 1 hasil audit terbaru untuk masing-masing website (' . count($seen) . ' domain unik).'
            );
        }

        return back()->with(
            'success',
            'Tidak ditemukan riwayat audit lama/ganda. Seluruh data saat ini (' . count($seen) . ' domain) sudah merupakan hasil audit paling baru.'
        );
    }

    public static function getAgencyMap(): array
    {
        $catalog = config('hsu.catalog', []);
        $map = [];
        foreach ($catalog as $groupName => $groupData) {
            foreach ($groupData['items'] as $item) {
                $host = strtolower(trim($item['host'] ?? ''));
                $map[$host] = [
                    'name'  => $item['name'] ?? $host,
                    'group' => $groupName,
                ];
                if (str_starts_with($host, 'www.')) {
                    $nonWww = substr($host, 4);
                    $map[$nonWww] = [
                        'name'  => $item['name'] ?? $nonWww,
                        'group' => $groupName,
                    ];
                } else {
                    $map['www.' . $host] = [
                        'name'  => $item['name'] ?? $host,
                        'group' => $groupName,
                    ];
                }
            }
        }
        return $map;
    }

    public function reports(Request $request)
    {
        $agencyMap = self::getAgencyMap();
        $query = ScanHistory::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('grade') && $request->grade !== 'all') {
            if ($request->grade === 'secure') {
                $query->where('score', '>=', 80);
            } elseif ($request->grade === 'warning') {
                $query->whereBetween('score', [50, 79]);
            } elseif ($request->grade === 'critical') {
                $query->where('score', '<', 50);
            }
        }
        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where('url', 'like', '%' . $searchTerm . '%');
        }

        $sort = $request->input('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'score_desc') {
            $query->orderByDesc('score');
        } elseif ($sort === 'score_asc') {
            $query->orderBy('score');
        } else {
            $query->latest();
        }

        try {
            $allScans = $query->get();
        } catch (\Throwable $e) {
            $allScans = collect([]);
        }

        $selectedGroup = $request->input('group', 'all');
        if ($selectedGroup !== 'all' && !empty($selectedGroup)) {
            $allScans = $allScans->filter(function ($item) use ($agencyMap, $selectedGroup) {
                $host = strtolower(parse_url($item->url, PHP_URL_HOST) ?? '');
                $group = $agencyMap[$host]['group'] ?? 'Lainnya';
                return $group === $selectedGroup;
            });
        }

        $totalCount = $allScans->count();
        $avgScore = $totalCount > 0 ? (int) round($allScans->avg('score')) : 0;
        $secureCount = $allScans->where('score', '>=', 80)->count();
        $warningCount = $allScans->whereBetween('score', [50, 79])->count();
        $criticalCount = $allScans->where('score', '<', 50)->count();

        $vulnerabilityCounts = [];
        foreach ($allScans as $scan) {
            $fails = $scan->file_results ?? [];
            if (is_array($fails)) {
                foreach ($fails as $fail) {
                    $name = $fail['name'] ?? 'Kerentanan Konfigurasi';
                    $vulnerabilityCounts[$name] = ($vulnerabilityCounts[$name] ?? 0) + 1;
                }
            }
        }
        arsort($vulnerabilityCounts);
        $topVulnerabilities = array_slice($vulnerabilityCounts, 0, 5, true);

        $catalog = config('hsu.catalog', []);
        $duplicateCount = self::countDuplicateScans();

        return view('scanner.reports', compact(
            'allScans',
            'totalCount',
            'avgScore',
            'secureCount',
            'warningCount',
            'criticalCount',
            'topVulnerabilities',
            'agencyMap',
            'catalog',
            'selectedGroup',
            'duplicateCount'
        ));
    }

    public function printReport(Request $request)
    {
        $agencyMap = self::getAgencyMap();
        $query = ScanHistory::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('grade') && $request->grade !== 'all') {
            if ($request->grade === 'secure') {
                $query->where('score', '>=', 80);
            } elseif ($request->grade === 'warning') {
                $query->whereBetween('score', [50, 79]);
            } elseif ($request->grade === 'critical') {
                $query->where('score', '<', 50);
            }
        }
        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where('url', 'like', '%' . $searchTerm . '%');
        }

        $sort = $request->input('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'score_desc') {
            $query->orderByDesc('score');
        } elseif ($sort === 'score_asc') {
            $query->orderBy('score');
        } else {
            $query->latest();
        }

        try {
            $allScans = $query->get();
        } catch (\Throwable $e) {
            $allScans = collect([]);
        }

        $selectedGroup = $request->input('group', 'all');
        if ($selectedGroup !== 'all' && !empty($selectedGroup)) {
            $allScans = $allScans->filter(function ($item) use ($agencyMap, $selectedGroup) {
                $host = strtolower(parse_url($item->url, PHP_URL_HOST) ?? '');
                $group = $agencyMap[$host]['group'] ?? 'Lainnya';
                return $group === $selectedGroup;
            });
        }

        $totalCount = $allScans->count();
        $avgScore = $totalCount > 0 ? (int) round($allScans->avg('score')) : 0;
        $secureCount = $allScans->where('score', '>=', 80)->count();
        $warningCount = $allScans->whereBetween('score', [50, 79])->count();
        $criticalCount = $allScans->where('score', '<', 50)->count();

        $vulnerabilityCounts = [];
        foreach ($allScans as $scan) {
            $fails = $scan->file_results ?? [];
            if (is_array($fails)) {
                foreach ($fails as $fail) {
                    $name = $fail['name'] ?? 'Kerentanan Konfigurasi';
                    $vulnerabilityCounts[$name] = ($vulnerabilityCounts[$name] ?? 0) + 1;
                }
            }
        }
        arsort($vulnerabilityCounts);
        $topVulnerabilities = array_slice($vulnerabilityCounts, 0, 5, true);

        $reportMode = $request->input('mode') === 'lengkap' ? 'lengkap' : 'resmi';

        return view('scanner.reports_print', compact(
            'allScans',
            'totalCount',
            'avgScore',
            'secureCount',
            'warningCount',
            'criticalCount',
            'topVulnerabilities',
            'agencyMap',
            'selectedGroup',
            'reportMode'
        ));
    }

    /**
     * Memeriksa apakah host merupakan domain *.hsu.go.id atau instansi vertikal yang masuk whitelist.
     */
    public static function isHostWhitelisted(string $host): bool
    {
        $host = strtolower(trim($host));
        if (str_contains($host, ':')) {
            $host = explode(':', $host)[0];
        }

        $allowedRoots = config('hsu.allowed_roots', [
            'hsu.go.id',
            'kab-hulusungaiutara.kpu.go.id',
            'pa-amuntai.go.id',
            'pn-amuntai.go.id',
            'hulusungaiutara.kalsel.polri.go.id',
            'hulusungaiutara.bawaslu.go.id',
            'hulusungaiutarakab.bps.go.id',
            'hsu.bps.go.id',
        ]);

        foreach ($allowedRoots as $root) {
            if ($host === $root || str_ends_with($host, '.' . $root)) {
                return true;
            }
        }

        return false;
    }

    public function scan(Request $request)
    {
        $rawUrl = trim($request->input('url', ''));
        if (!empty($rawUrl) && !preg_match('#^https?://#i', $rawUrl)) {
            $rawUrl = 'https://' . $rawUrl;
            $request->merge(['url' => $rawUrl]);
        }

        $request->validate(['url' => 'required|url']);
        $url = trim($request->input('url'));

        // Kunci Domain: Hanya izinkan website resmi Pemkab HSU (*.hsu.go.id) & Instansi Vertikal Whitelist
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        if (!self::isHostWhitelisted($host)) {
            return back()->with('error', 'Akses Ditolak: Sistem HSU Sentinel dikunci khusus untuk mengaudit website resmi Pemerintah Kabupaten Hulu Sungai Utara (*.hsu.go.id) serta instansi vertikal HSU yang terdaftar di whitelist (KPU, Bawaslu, PA/PN Amuntai, Polres, BPS). Target domain selain HSU tidak diizinkan.');
        }

        // Teruskan environment sistem (terutama SystemRoot & PATH pada Windows)
        // Tanpa SystemRoot, modul jaringan/DNS Windows (getaddrinfo) akan gagal me-resolve domain
        $env = array_merge($_ENV, [
            'SystemRoot' => getenv('SystemRoot') ?: 'C:\Windows',
            'SYSTEMROOT' => getenv('SYSTEMROOT') ?: 'C:\Windows',
            'windir'     => getenv('windir') ?: 'C:\Windows',
            'PATH'       => getenv('PATH') ?: 'C:\Windows\system32;C:\Windows',
            'TEMP'       => getenv('TEMP') ?: 'C:\Windows\Temp',
            'TMP'        => getenv('TMP') ?: 'C:\Windows\Temp',
        ]);

        $process = new Process(['python', base_path('scanner.py'), $url], base_path(), $env);
        $process->setTimeout(60); // Beri batas waktu maksimal 60 detik (15+ filter aktif)
        $process->run();

        // Cek jika perintah Python gagal total dieksekusi oleh OS
        if (!$process->isSuccessful()) {
            return back()->with('error', 'Sistem Gagal: Script Python tidak dapat dijalankan di server ini.');
        }

        // Ambil output dari Python dan ubah dari JSON ke Array PHP
        $output = $process->getOutput();
        $result = json_decode($output, true);

        // Cek apakah Python mengembalikan pesan error (misal target web mati)
        if (!$result || (isset($result['error']) && $result['error'] !== null)) {
            $pesanError = $result['error'] ?? 'Terjadi kesalahan saat memproses data dari Python.';
            return back()->with('error', $pesanError);
        }

        // Jika berhasil, simpan riwayat ke Database
        $history = ScanHistory::create([
            'url' => $url,
            'score' => $result['score'],
            'header_results' => $result['passed'],
            'file_results' => $result['failed']
        ]);

        return view('scanner.result', compact('history'));
    }
}