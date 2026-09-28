<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuranSource;


class QuranSourceSeeder extends Seeder
{

public function run(): void
{


QuranSource::create([


'quran_id'=>1,


'name'=>'Tanzil Quran Text',


'publisher'=>'Tanzil Project',


'description'=>
'Verified Quran Arabic text source.',


'url'=>'https://tanzil.net',


'version'=>'1.1',


'language'=>'Arabic',


'type'=>'arabic_text',


'status'=>'verified',


'verified_by'=>'Admin',


'verified_at'=>now()


]);


}

}
