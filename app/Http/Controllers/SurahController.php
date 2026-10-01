<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurahController extends Controller
{
    private const RTL_CODES = ['ur', 'ar', 'fa', 'ps', 'sd', 'ug', 'he'];
    private const BISMILLAH = 'بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ';

    /** GET /surahs/{number} */
    public function show(int $number)
    {
        $surah = DB::table('surahs')->where('number', $number)->first();
        abort_if(! $surah, 404);

        $lastNumber = (int) DB::table('surahs')->where('quran_id', $surah->quran_id)->max('number');
        $quran      = DB::table('qurans')->where('id', $surah->quran_id)->first();

        // Default: Urdu + first added translator of that language
        $languages = $this->languages();

        // page opens with Urdu (or the first language that has translators)
        $usable = collect($languages)->filter(fn ($l) => ! empty($l['translators']))->values();
        abort_if($usable->isEmpty(), 500, 'No languages with translators found.');

        $lang = $usable->firstWhere('code', 'ur') ?? $usable->first();
        $tr   = collect($lang['translators'])->firstWhere('id', $lang['default_translator']);

        $ayahs = DB::table('ayahs as a')
            ->leftJoin('ayah_translations as at', function ($join) use ($lang, $tr) {
                $join->on('at.ayah_id', '=', 'a.id')
                    ->where('at.language_id', $lang['id'])
                    ->where('at.translator_id', $tr['id']);
            })
            ->where('a.surah_id', $surah->id)
            ->orderBy('a.ayah_number')
            ->get([
                'a.ayah_number', 'a.arabic_text', 'a.transliteration', 'a.page_number',
                'a.juz_number', 'a.hizb_number', 'a.is_sajdah', 'at.translation',
            ]);

        $sajdahAyahs = $ayahs->where('is_sajdah', 1)->pluck('ayah_number')->values();

        $manzils = DB::table('manzils')
            ->where('quran_id', $surah->quran_id)
            ->where('start_surah', '<=', $number)
            ->where('end_surah', '>=', $number)
            ->orderBy('number')->pluck('number');

        $source = DB::table('quran_sources')
            ->where('quran_id', $surah->quran_id)
            ->where('type', 'arabic_text')
            ->where('status', 'verified')
            ->first(['name', 'publisher']);

        $details = [
            'quran'        => $quran->name ?? null,
            'revelation'   => ucfirst($surah->revelation_type),
            'total_ayahs'  => $surah->total_ayahs,
            'juz'          => $this->range($ayahs->pluck('juz_number')),
            'hizb'         => $this->range($ayahs->pluck('hizb_number')),
            'pages'        => $this->range($ayahs->pluck('page_number')),
            'manzil'       => $manzils->implode(', '),
            'sajdah_count' => $sajdahAyahs->count(),
            'source'       => $source ? trim($source->name . ($source->publisher ? ' — ' . $source->publisher : '')) : null,
        ];

        $config = [
            'surahNumber'       => $number,
            'totalAyahs'        => (int) $ayahs->count(),
            'languages'         => $languages,
            'defaultLanguage'   => $lang['id'],
            'defaultTranslator' => $tr['id'],
            'translationsUrl'   => route('surahs.translations', $number),
        ];

        return view('quran.show', [
            'surah'                => $surah,
            'details'              => $details,
            'ayahs'                => $ayahs,
            'sajdahAyahs'          => $sajdahAyahs,
            'prevNumber'           => $number > 1 ? $number - 1 : null,
            'nextNumber'           => $number < $lastNumber ? $number + 1 : null,
            'showBismillah'        => ! in_array($number, [1, 9], true), // Al-Fatihah has it as ayah 1
            'bismillah'            => self::BISMILLAH,
            'bismillahTranslation' => $this->bismillahTranslation($lang['id'], $tr['id']),
            'languages'            => $languages,
            'lang'                 => $lang,
            'translator'           => $tr,
            'config'               => $config,
        ]);
    }

    /** GET /surahs/{number}/translations?language_id=&translator_id=  (JSON; page URL is untouched) */
    public function translations(Request $request, int $number)
    {
        $data = $request->validate([
            'language_id'   => 'required|integer',
            'translator_id' => 'required|integer',
        ]);

        $surah = DB::table('surahs')->where('number', $number)->first();
        abort_if(! $surah, 404);

        try {
            // Plain list ([{n, t}, ...]) so the JSON shape never depends on key numbering
            $items = DB::table('ayahs as a')
                ->join('ayah_translations as at', 'at.ayah_id', '=', 'a.id')
                ->where('a.surah_id', $surah->id)
                ->where('at.language_id', $data['language_id'])
                ->where('at.translator_id', $data['translator_id'])
                ->orderBy('a.ayah_number')
                ->get(['a.ayah_number as n', 'at.translation as t'])
                ->map(fn ($r) => ['n' => (int) $r->n, 't' => $this->clean($r->t)])
                ->all();

            $bismillah = $this->clean(
                $this->bismillahTranslation($data['language_id'], $data['translator_id'])
            );

            return response()->json(
                ['items' => $items, 'bismillah' => $bismillah],
                200,
                [],
                JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
            );
        } catch (\Throwable $e) {
            report($e); // full error goes to storage/logs/laravel.log

            return response()->json([
                'message' => config('app.debug') ? $e->getMessage() : 'Server error',
            ], 500);
        }
    }

    /** Removes invalid UTF-8 bytes so json_encode can never fail on stored text. */
    private function clean(?string $text): ?string
    {
        return $text === null ? null : mb_scrub($text, 'UTF-8');
    }

    /**
     * Every language in the languages table (even ones with no translators yet). A translator belongs to a language when
     * translators.language matches the language name or code (case-insensitive), or when
     * it already has rows in ayah_translations for that language.
     * Translators are ordered oldest first (by id).
     */
    private function languages(): array
    {
        return (function () {
            $languages   = DB::table('languages')->orderBy('name')->get();
            $translators = DB::table('translators')->orderBy('id')->get();

            // [language_id => [translator_id, ...]] that actually have translation rows
            $withData = DB::table('ayah_translations')
                ->select('language_id', 'translator_id')->distinct()->get()
                ->groupBy('language_id')
                ->map(fn ($g) => $g->pluck('translator_id')->map(fn ($id) => (int) $id)->all());

            $result = [];

            foreach ($languages as $l) {
                $name = mb_strtolower(trim($l->name));
                $code = mb_strtolower(trim((string) $l->code));
                $dataIds = $withData->get($l->id, []);

                $langId = (string) $l->id;

                $list = $translators->filter(function ($t) use ($name, $code, $langId, $dataIds) {
                    $tl = mb_strtolower(trim((string) $t->language));
                    return $tl === $name || ($code !== '' && $tl === $code) || $tl === $langId || in_array((int) $t->id, $dataIds, true);
                })->sortBy('id')->values();

                $mapped = $list->map(fn ($t) => [
                    'id'       => (int) $t->id,
                    'name'     => trim($t->name),
                    'has_data' => in_array((int) $t->id, $dataIds, true),
                ])->values()->all();

                // default = first added translator that has translations (falls back to first added)
                $default = collect($mapped)->firstWhere('has_data', true) ?? ($mapped[0] ?? null);

                $result[] = [
                    'id'                 => (int) $l->id,
                    'name'               => trim($l->name),
                    'code'               => trim((string) $l->code),
                    'class'              => 'lang-' . preg_replace('/\s+/', '-', $name),
                    'rtl'                => in_array($code, self::RTL_CODES, true),
                    'translators'        => $mapped,
                    'default_translator' => $default['id'] ?? null,
                ];
            }

            return $result;
        })();
    }

    private function bismillahTranslation($languageId, $translatorId): ?string
    {
        return DB::table('ayah_translations as at')
            ->join('ayahs as a', 'a.id', '=', 'at.ayah_id')
            ->join('surahs as s', 's.id', '=', 'a.surah_id')
            ->where('s.number', 1)
            ->where('a.ayah_number', 1)
            ->where('at.language_id', $languageId)
            ->where('at.translator_id', $translatorId)
            ->value('at.translation');
    }

    private function range($values): string
    {
        $values = $values->filter()->values();
        if ($values->isEmpty()) {
            return '—';
        }
        $min = $values->min();
        $max = $values->max();
        return $min === $max ? (string) $min : "$min – $max";
    }
}
