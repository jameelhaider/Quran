<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Juz;


class JuzSeeder extends Seeder
{

    public function run(): void
    {


        $juzs = [

            ['number'=>1,'name_english'=>'Alif Lam Meem','name_arabic'=>'الم','name_urdu'=>'الم','start_surah'=>1,'start_ayah'=>1,'end_surah'=>2,'end_ayah'=>141],
            ['number'=>2,'name_english'=>'Sayaqool','name_arabic'=>'سيقول','name_urdu'=>'سیقول','start_surah'=>2,'start_ayah'=>142,'end_surah'=>2,'end_ayah'=>252],
            ['number'=>3,'name_english'=>'Tilkal Rusul','name_arabic'=>'تلك الرسل','name_urdu'=>'تلک الرسل','start_surah'=>2,'start_ayah'=>253,'end_surah'=>3,'end_ayah'=>92],
            ['number'=>4,'name_english'=>'Lan Tana Loo','name_arabic'=>'لن تنالوا','name_urdu'=>'لن تنالوا','start_surah'=>3,'start_ayah'=>93,'end_surah'=>4,'end_ayah'=>23],
            ['number'=>5,'name_english'=>'Wal Mohsanat','name_arabic'=>'والمحصنات','name_urdu'=>'والمحصنات','start_surah'=>4,'start_ayah'=>24,'end_surah'=>4,'end_ayah'=>147],
            ['number'=>6,'name_english'=>'La Yuhibbullah','name_arabic'=>'لا يحب الله','name_urdu'=>'لا یحب اللہ','start_surah'=>4,'start_ayah'=>148,'end_surah'=>5,'end_ayah'=>81],
            ['number'=>7,'name_english'=>'Wa Iza Samiu','name_arabic'=>'وإذا سمعوا','name_urdu'=>'واذا سمعوا','start_surah'=>5,'start_ayah'=>82,'end_surah'=>6,'end_ayah'=>110],
            ['number'=>8,'name_english'=>'Wa Lau Annana','name_arabic'=>'ولو أننا','name_urdu'=>'ولو اننا','start_surah'=>6,'start_ayah'=>111,'end_surah'=>7,'end_ayah'=>87],
            ['number'=>9,'name_english'=>'Qalal Malao','name_arabic'=>'قال الملأ','name_urdu'=>'قال الملا','start_surah'=>7,'start_ayah'=>88,'end_surah'=>8,'end_ayah'=>40],
            ['number'=>10,'name_english'=>'Wa A\'lamu','name_arabic'=>'واعلموا','name_urdu'=>'واعلموا','start_surah'=>8,'start_ayah'=>41,'end_surah'=>9,'end_ayah'=>92],
            ['number'=>11,'name_english'=>'Yatazeroon','name_arabic'=>'يعتذرون','name_urdu'=>'یعتذرون','start_surah'=>9,'start_ayah'=>93,'end_surah'=>11,'end_ayah'=>5],
            ['number'=>12,'name_english'=>'Wa Mamin Da\'abat','name_arabic'=>'وما من دابة','name_urdu'=>'وما من دابہ','start_surah'=>11,'start_ayah'=>6,'end_surah'=>12,'end_ayah'=>52],
            ['number'=>13,'name_english'=>'Wa Ma Ubrioo','name_arabic'=>'وما أبرئ','name_urdu'=>'وما ابری','start_surah'=>12,'start_ayah'=>53,'end_surah'=>14,'end_ayah'=>52],
            ['number'=>14,'name_english'=>'Rubama','name_arabic'=>'ربما','name_urdu'=>'ربما','start_surah'=>15,'start_ayah'=>1,'end_surah'=>16,'end_ayah'=>128],
            ['number'=>15,'name_english'=>'Subhanallazi','name_arabic'=>'سبحان الذي','name_urdu'=>'سبحان الذی','start_surah'=>17,'start_ayah'=>1,'end_surah'=>18,'end_ayah'=>74],
            ['number'=>16,'name_english'=>'Qal Alam','name_arabic'=>'قال ألم','name_urdu'=>'قال الم','start_surah'=>18,'start_ayah'=>75,'end_surah'=>20,'end_ayah'=>135],
            ['number'=>17,'name_english'=>'Aqtarabo','name_arabic'=>'اقترب','name_urdu'=>'اقترب','start_surah'=>21,'start_ayah'=>1,'end_surah'=>22,'end_ayah'=>78],
            ['number'=>18,'name_english'=>'Qadd Aflaha','name_arabic'=>'قد أفلح','name_urdu'=>'قد افلح','start_surah'=>23,'start_ayah'=>1,'end_surah'=>25,'end_ayah'=>20],
            ['number'=>19,'name_english'=>'Wa Qalallazina','name_arabic'=>'وقال الذين','name_urdu'=>'وقال الذین','start_surah'=>25,'start_ayah'=>21,'end_surah'=>27,'end_ayah'=>55],
            ['number'=>20,'name_english'=>'A\'man Khalaq','name_arabic'=>'أمن خلق','name_urdu'=>'امن خلق','start_surah'=>27,'start_ayah'=>56,'end_surah'=>29,'end_ayah'=>45],
            ['number'=>21,'name_english'=>'Utlu Ma Oohi','name_arabic'=>'اتل ما أوحي','name_urdu'=>'اتل ما اوحی','start_surah'=>29,'start_ayah'=>46,'end_surah'=>33,'end_ayah'=>30],
            ['number'=>22,'name_english'=>'Wa Manyaqnut','name_arabic'=>'ومن يقنت','name_urdu'=>'ومن یقنت','start_surah'=>33,'start_ayah'=>31,'end_surah'=>36,'end_ayah'=>27],
            ['number'=>23,'name_english'=>'Wa Mali','name_arabic'=>'وما لي','name_urdu'=>'وما لی','start_surah'=>36,'start_ayah'=>28,'end_surah'=>39,'end_ayah'=>31],
            ['number'=>24,'name_english'=>'Faman Azlam','name_arabic'=>'فمن أظلم','name_urdu'=>'فمن اظلم','start_surah'=>39,'start_ayah'=>32,'end_surah'=>41,'end_ayah'=>46],
            ['number'=>25,'name_english'=>'Elahe Yuruddo','name_arabic'=>'إليه يرد','name_urdu'=>'الیہ یرد','start_surah'=>41,'start_ayah'=>47,'end_surah'=>45,'end_ayah'=>37],
            ['number'=>26,'name_english'=>'Ha\'a Meem','name_arabic'=>'حم','name_urdu'=>'حم','start_surah'=>46,'start_ayah'=>1,'end_surah'=>51,'end_ayah'=>30],
            ['number'=>27,'name_english'=>'Qala Fama Khatbukum','name_arabic'=>'قال فما خطبكم','name_urdu'=>'قال فما خطبکم','start_surah'=>51,'start_ayah'=>31,'end_surah'=>57,'end_ayah'=>29],
            ['number'=>28,'name_english'=>'Qad Sami Allah','name_arabic'=>'قد سمع الله','name_urdu'=>'قد سمع اللہ','start_surah'=>58,'start_ayah'=>1,'end_surah'=>66,'end_ayah'=>12],
            ['number'=>29,'name_english'=>'Tabarakallazi','name_arabic'=>'تبارك الذي','name_urdu'=>'تبارک الذی','start_surah'=>67,'start_ayah'=>1,'end_surah'=>77,'end_ayah'=>50],
            ['number'=>30,'name_english'=>'Amma','name_arabic'=>'عم','name_urdu'=>'عم','start_surah'=>78,'start_ayah'=>1,'end_surah'=>114,'end_ayah'=>6],

        ];



        foreach($juzs as $juz)
        {


            Juz::create([

                'quran_id'=>1,

                ...$juz

            ]);


        }


    }

}
