<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

/**
 * Satu-satunya tempat yang menerjemahkan skor (0-100) menjadi predikat & status.
 *
 * Seluruh controller dan view WAJIB memakai class ini agar website dengan skor
 * yang sama selalu mendapat predikat yang sama di dashboard, rekap, detail
 * hasil audit, maupun laporan cetak resmi. Batas skor diatur di config/hsu.php.
 */
class SecurityGrade
{
    /** Kelas Tailwind per warna (ditulis lengkap agar mudah dicari & konsisten). */
    private const STYLES = [
        'emerald' => [
            'badge' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'soft'  => 'bg-emerald-50/80 border-emerald-200/60',
            'dot'   => 'bg-emerald-500',
            'text'  => 'text-emerald-700',
            'title' => 'text-emerald-800',
            'hex'   => '#059669',
        ],
        'blue' => [
            'badge' => 'bg-blue-50 text-blue-800 border-blue-200',
            'soft'  => 'bg-blue-50/80 border-blue-200/60',
            'dot'   => 'bg-blue-500',
            'text'  => 'text-blue-700',
            'title' => 'text-blue-800',
            'hex'   => '#0284c7',
        ],
        'amber' => [
            'badge' => 'bg-amber-50 text-amber-800 border-amber-200',
            'soft'  => 'bg-amber-50/80 border-amber-200/60',
            'dot'   => 'bg-amber-500',
            'text'  => 'text-amber-700',
            'title' => 'text-amber-800',
            'hex'   => '#d97706',
        ],
        'rose' => [
            'badge' => 'bg-rose-50 text-rose-800 border-rose-200',
            'soft'  => 'bg-rose-50/80 border-rose-200/60',
            'dot'   => 'bg-rose-500',
            'text'  => 'text-rose-700',
            'title' => 'text-rose-800',
            'hex'   => '#e11d48',
        ],
    ];

    /**
     * Daftar predikat dari skor tertinggi ke terendah.
     */
    public static function scale(): array
    {
        $scale = config('hsu.grades', []);
        usort($scale, fn ($a, $b) => $b['min'] <=> $a['min']);

        return $scale;
    }

    /**
     * Informasi lengkap predikat untuk sebuah skor.
     *
     * @return array{grade:string,min:int,max:int,label:string,status:string,status_label:string,risk:string,desc:string,range:string,styles:array}
     */
    public static function for(int|float|null $score): array
    {
        $score = (int) round(max(0, min(100, (float) $score)));
        $scale = self::scale();
        $row = end($scale);

        foreach ($scale as $candidate) {
            if ($score >= $candidate['min']) {
                $row = $candidate;
                break;
            }
        }

        return array_merge($row, [
            'score'        => $score,
            'status_label' => self::statusLabel($row['status']),
            'range'        => self::gradeRangeLabel($row),
            'styles'       => self::styles($row['color'] ?? 'emerald'),
        ]);
    }

    /**
     * Kelompok status ringkas: secure | warning | critical.
     */
    public static function status(int|float|null $score): string
    {
        return self::for($score)['status'];
    }

    public static function statuses(): array
    {
        return config('hsu.statuses', []);
    }

    public static function statusLabel(string $status): string
    {
        return self::statuses()[$status]['label'] ?? ucfirst($status);
    }

    public static function statusStyles(string $status): array
    {
        return self::styles(self::statuses()[$status]['color'] ?? 'emerald');
    }

    public static function styles(string $color): array
    {
        return self::STYLES[$color] ?? self::STYLES['emerald'];
    }

    /**
     * Rentang skor [min, max] untuk sebuah status (gabungan seluruh predikat berstatus tsb).
     */
    public static function statusRange(string $status): ?array
    {
        $rows = array_filter(self::scale(), fn ($g) => $g['status'] === $status);
        if (empty($rows)) {
            return null;
        }

        return [min(array_column($rows, 'min')), max(array_column($rows, 'max'))];
    }

    /**
     * Label rentang status, contoh: "≥ 70", "50–69", "< 50".
     */
    public static function statusRangeLabel(string $status): string
    {
        $range = self::statusRange($status);
        if (!$range) {
            return '-';
        }

        return self::rangeText($range[0], $range[1]);
    }

    /**
     * Label lengkap status untuk filter / legenda, contoh: "Aman (≥ 70)".
     */
    public static function statusFilterLabel(string $status): string
    {
        return self::statusLabel($status) . ' (' . self::statusRangeLabel($status) . ')';
    }

    public static function gradeRangeLabel(array $row): string
    {
        return $row['min'] . '–' . $row['max'];
    }

    /**
     * Terapkan filter status pada query Eloquent.
     */
    public static function applyStatusFilter(Builder $query, ?string $status): Builder
    {
        $range = $status ? self::statusRange($status) : null;
        if ($range) {
            $query->whereBetween('score', $range);
        }

        return $query;
    }

    /**
     * Hitung jumlah audit per status dari koleksi / array model yang memiliki atribut score.
     *
     * @return array{secure:int,warning:int,critical:int}
     */
    public static function countByStatus(iterable $scans): array
    {
        $counts = array_fill_keys(array_keys(self::statuses()), 0);
        foreach ($scans as $scan) {
            $status = self::status(is_array($scan) ? ($scan['score'] ?? 0) : $scan->score);
            $counts[$status] = ($counts[$status] ?? 0) + 1;
        }

        return $counts;
    }

    /**
     * Hitung jumlah audit per predikat huruf (A, B, C, D).
     */
    public static function countByGrade(iterable $scans): array
    {
        $counts = array_fill_keys(array_column(self::scale(), 'grade'), 0);
        foreach ($scans as $scan) {
            $grade = self::for(is_array($scan) ? ($scan['score'] ?? 0) : $scan->score)['grade'];
            $counts[$grade]++;
        }

        return $counts;
    }

    private static function rangeText(int $min, int $max): string
    {
        if ($max >= 100) {
            return '≥ ' . $min;
        }
        if ($min <= 0) {
            return '< ' . ($max + 1);
        }

        return $min . '–' . $max;
    }
}

