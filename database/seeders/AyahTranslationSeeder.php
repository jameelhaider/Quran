<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AyahTranslation;

class AyahTranslationSeeder extends Seeder
{
    public function run(): void
    {
        // CHANGE THESE to match your languages / translators tables
        $languageId   = 9; // English
        $translatorId = 34; // Saheeh International

        $path = database_path('seeders/data/uz.sodik.txt');

        if (!file_exists($path)) {
            $this->command->error("File not found: {$path}");
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Remove UTF-8 BOM from the first line if present
        if (isset($lines[0])) {
            $lines[0] = preg_replace('/^\xEF\xBB\xBF/', '', $lines[0]);
        }

        // Keep only real translation lines (skip blanks and # comments)
        $lines = array_values(array_filter(
            array_map('trim', $lines),
            fn ($l) => $l !== '' && !str_starts_with($l, '#')
        ));

        if (count($lines) !== 6236) {
            $this->command->error('Expected 6236 lines but found ' . count($lines) . '. Nothing was inserted.');
            return;
        }

        $now = now();
        $rows = [];

        foreach ($lines as $index => $translation) {
            $rows[] = [
                'ayah_id'       => $index + 1, // 1 to 6236
                'language_id'   => $languageId,
                'translator_id' => $translatorId,
                'translation'   => $translation,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        DB::transaction(function () use ($rows, $languageId, $translatorId) {
            // Makes re-running safe: clears only this language + translator
            AyahTranslation::where('language_id', $languageId)
                ->where('translator_id', $translatorId)
                ->delete();

            foreach (array_chunk($rows, 500) as $chunk) {
                AyahTranslation::insert($chunk);
            }
        });

        $this->command->info('Inserted ' . count($rows) . ' English translations.');
    }
}
