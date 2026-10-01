<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ayah;
use App\Models\Language;
use App\Models\Quran;
use App\Models\Surah;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QuranController extends Controller
{

public function surahs()
{
    $quran = Quran::with([
        'surahs'  => fn ($q) => $q->orderBy('number'),
        'manzils' => fn ($q) => $q->orderBy('number'),
    ])->firstOrFail();

    $ayahStats = Cache::remember("quran.{$quran->id}.surahs.ayah-stats", now()->addDay(), function () {
        return Ayah::query()
            ->select(
                'surah_id',
                DB::raw('MIN(juz_number) as first_juz'),
                DB::raw('MAX(juz_number) as last_juz'),
                DB::raw('MIN(page_number) as start_page'),
                DB::raw('SUM(is_sajdah) as sajdah_count')
            )
            ->groupBy('surah_id')
            ->get()
            ->keyBy('surah_id')
            ->toArray();
    });

    // Pre-calculate Manzil mapping for O(1) lookup during iteration
    $manzilMap = [];
    foreach ($quran->manzils as $manzil) {
        for ($i = $manzil->start_surah; $i <= $manzil->end_surah; $i++) {
            $manzilMap[$i] = $manzil->number;
        }
    }

    $surahs = $quran->surahs->map(function ($surah) use ($ayahStats, $manzilMap) {
        $stats = $ayahStats[$surah->id] ?? [];

        // Normalize revelation type
        $surah->revelation = str_contains(strtolower((string) $surah->revelation_type), 'medin')
            ? 'medinan'
            : 'meccan';

        // Append stats
        $surah->first_juz    = $stats['first_juz'] ?? null;
        $surah->last_juz     = $stats['last_juz'] ?? null;
        $surah->start_page   = $stats['start_page'] ?? null;
        $surah->sajdah_count = (int) ($stats['sajdah_count'] ?? 0);

        // Append manzil (O(1) lookup)
        $surah->manzil_number = $manzilMap[$surah->number] ?? null;

        return $surah;
    });

    $stats = [
        'total'   => $surahs->count(),
        'meccan'  => $surahs->where('revelation', 'meccan')->count(),
        'medinan' => $surahs->where('revelation', 'medinan')->count(),
        'ayahs'   => $surahs->sum('total_ayahs'),
        'sajdahs' => $surahs->sum('sajdah_count'),
    ];

    return view('quran.surah', compact('quran', 'surahs', 'stats'));
}


public function show($number)
{
    $surah=Surah::where('number',$number)->get();
    $ayahs=Ayah::where('surah_id',$number)->get();
    return view('quran.show',compact('surah','ayahs'));
}



}
