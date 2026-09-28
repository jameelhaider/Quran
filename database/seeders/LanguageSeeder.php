<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;


class LanguageSeeder extends Seeder
{


public function run(): void
{


$languages=[


[
'name'=>'Arabic',
'code'=>'ar'
],


[
'name'=>'English',
'code'=>'en'
],


[
'name'=>'Urdu',
'code'=>'ur'
],


];


foreach($languages as $language)
{

Language::create($language);

}


}


}
