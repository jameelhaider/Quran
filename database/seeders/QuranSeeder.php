<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quran;


class QuranSeeder extends Seeder
{

    public function run(): void
    {

        Quran::create([

            'name'=>'The Holy Quran',

            'slug'=>'quran',

            'language'=>'Arabic',

            'description'=>
            'The complete Holy Quran containing 114 Surahs and 6236 verses.'

        ]);

    }

}
