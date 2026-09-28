<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translator;


class TranslatorSeeder extends Seeder
{

public function run(): void
{


Translator::create([

'name'=>'Sahih International',

'language'=>'English',

'bio'=>'English translation of the Quran'

]);


Translator::create([

'name'=>'Fateh Muhammad Jalandhari',

'language'=>'Urdu',

'bio'=>'Urdu translation of Quran'

]);


}

}
