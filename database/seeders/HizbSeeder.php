<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hizb;


class HizbSeeder extends Seeder
{

    public function run(): void
    {


        $hizbs = [

            ['number'=>1,'juz_number'=>1,'start_surah'=>1,'start_ayah'=>1,'end_surah'=>2,'end_ayah'=>74],
            ['number'=>2,'juz_number'=>1,'start_surah'=>2,'start_ayah'=>75,'end_surah'=>2,'end_ayah'=>141],
            ['number'=>3,'juz_number'=>2,'start_surah'=>2,'start_ayah'=>142,'end_surah'=>2,'end_ayah'=>202],
            ['number'=>4,'juz_number'=>2,'start_surah'=>2,'start_ayah'=>203,'end_surah'=>2,'end_ayah'=>252],
            ['number'=>5,'juz_number'=>3,'start_surah'=>2,'start_ayah'=>253,'end_surah'=>3,'end_ayah'=>14],
            ['number'=>6,'juz_number'=>3,'start_surah'=>3,'start_ayah'=>15,'end_surah'=>3,'end_ayah'=>92],
            ['number'=>7,'juz_number'=>4,'start_surah'=>3,'start_ayah'=>93,'end_surah'=>3,'end_ayah'=>170],
            ['number'=>8,'juz_number'=>4,'start_surah'=>3,'start_ayah'=>171,'end_surah'=>4,'end_ayah'=>23],
            ['number'=>9,'juz_number'=>5,'start_surah'=>4,'start_ayah'=>24,'end_surah'=>4,'end_ayah'=>87],
            ['number'=>10,'juz_number'=>5,'start_surah'=>4,'start_ayah'=>88,'end_surah'=>4,'end_ayah'=>147],
            ['number'=>11,'juz_number'=>6,'start_surah'=>4,'start_ayah'=>148,'end_surah'=>5,'end_ayah'=>26],
            ['number'=>12,'juz_number'=>6,'start_surah'=>5,'start_ayah'=>27,'end_surah'=>5,'end_ayah'=>81],
            ['number'=>13,'juz_number'=>7,'start_surah'=>5,'start_ayah'=>82,'end_surah'=>6,'end_ayah'=>35],
            ['number'=>14,'juz_number'=>7,'start_surah'=>6,'start_ayah'=>36,'end_surah'=>6,'end_ayah'=>110],
            ['number'=>15,'juz_number'=>8,'start_surah'=>6,'start_ayah'=>111,'end_surah'=>6,'end_ayah'=>165],
            ['number'=>16,'juz_number'=>8,'start_surah'=>7,'start_ayah'=>1,'end_surah'=>7,'end_ayah'=>87],
            ['number'=>17,'juz_number'=>9,'start_surah'=>7,'start_ayah'=>88,'end_surah'=>7,'end_ayah'=>170],
            ['number'=>18,'juz_number'=>9,'start_surah'=>7,'start_ayah'=>171,'end_surah'=>8,'end_ayah'=>40],
            ['number'=>19,'juz_number'=>10,'start_surah'=>8,'start_ayah'=>41,'end_surah'=>9,'end_ayah'=>33],
            ['number'=>20,'juz_number'=>10,'start_surah'=>9,'start_ayah'=>34,'end_surah'=>9,'end_ayah'=>92],
            ['number'=>21,'juz_number'=>11,'start_surah'=>9,'start_ayah'=>93,'end_surah'=>10,'end_ayah'=>25],
            ['number'=>22,'juz_number'=>11,'start_surah'=>10,'start_ayah'=>26,'end_surah'=>11,'end_ayah'=>5],
            ['number'=>23,'juz_number'=>12,'start_surah'=>11,'start_ayah'=>6,'end_surah'=>11,'end_ayah'=>83],
            ['number'=>24,'juz_number'=>12,'start_surah'=>11,'start_ayah'=>84,'end_surah'=>12,'end_ayah'=>52],
            ['number'=>25,'juz_number'=>13,'start_surah'=>12,'start_ayah'=>53,'end_surah'=>13,'end_ayah'=>18],
            ['number'=>26,'juz_number'=>13,'start_surah'=>13,'start_ayah'=>19,'end_surah'=>14,'end_ayah'=>52],
            ['number'=>27,'juz_number'=>14,'start_surah'=>15,'start_ayah'=>1,'end_surah'=>16,'end_ayah'=>50],
            ['number'=>28,'juz_number'=>14,'start_surah'=>16,'start_ayah'=>51,'end_surah'=>16,'end_ayah'=>128],
            ['number'=>29,'juz_number'=>15,'start_surah'=>17,'start_ayah'=>1,'end_surah'=>17,'end_ayah'=>98],
            ['number'=>30,'juz_number'=>15,'start_surah'=>17,'start_ayah'=>99,'end_surah'=>18,'end_ayah'=>74],
            ['number'=>31,'juz_number'=>16,'start_surah'=>18,'start_ayah'=>75,'end_surah'=>19,'end_ayah'=>98],
            ['number'=>32,'juz_number'=>16,'start_surah'=>20,'start_ayah'=>1,'end_surah'=>20,'end_ayah'=>135],
            ['number'=>33,'juz_number'=>17,'start_surah'=>21,'start_ayah'=>1,'end_surah'=>21,'end_ayah'=>112],
            ['number'=>34,'juz_number'=>17,'start_surah'=>22,'start_ayah'=>1,'end_surah'=>22,'end_ayah'=>78],
            ['number'=>35,'juz_number'=>18,'start_surah'=>23,'start_ayah'=>1,'end_surah'=>24,'end_ayah'=>20],
            ['number'=>36,'juz_number'=>18,'start_surah'=>24,'start_ayah'=>21,'end_surah'=>25,'end_ayah'=>20],
            ['number'=>37,'juz_number'=>19,'start_surah'=>25,'start_ayah'=>21,'end_surah'=>26,'end_ayah'=>110],
            ['number'=>38,'juz_number'=>19,'start_surah'=>26,'start_ayah'=>111,'end_surah'=>27,'end_ayah'=>55],
            ['number'=>39,'juz_number'=>20,'start_surah'=>27,'start_ayah'=>56,'end_surah'=>28,'end_ayah'=>50],
            ['number'=>40,'juz_number'=>20,'start_surah'=>28,'start_ayah'=>51,'end_surah'=>29,'end_ayah'=>45],
            ['number'=>41,'juz_number'=>21,'start_surah'=>29,'start_ayah'=>46,'end_surah'=>31,'end_ayah'=>21],
            ['number'=>42,'juz_number'=>21,'start_surah'=>31,'start_ayah'=>22,'end_surah'=>33,'end_ayah'=>30],
            ['number'=>43,'juz_number'=>22,'start_surah'=>33,'start_ayah'=>31,'end_surah'=>34,'end_ayah'=>23],
            ['number'=>44,'juz_number'=>22,'start_surah'=>34,'start_ayah'=>24,'end_surah'=>36,'end_ayah'=>27],
            ['number'=>45,'juz_number'=>23,'start_surah'=>36,'start_ayah'=>28,'end_surah'=>37,'end_ayah'=>144],
            ['number'=>46,'juz_number'=>23,'start_surah'=>37,'start_ayah'=>145,'end_surah'=>39,'end_ayah'=>31],
            ['number'=>47,'juz_number'=>24,'start_surah'=>39,'start_ayah'=>32,'end_surah'=>40,'end_ayah'=>40],
            ['number'=>48,'juz_number'=>24,'start_surah'=>40,'start_ayah'=>41,'end_surah'=>41,'end_ayah'=>46],
            ['number'=>49,'juz_number'=>25,'start_surah'=>41,'start_ayah'=>47,'end_surah'=>43,'end_ayah'=>23],
            ['number'=>50,'juz_number'=>25,'start_surah'=>43,'start_ayah'=>24,'end_surah'=>45,'end_ayah'=>37],
            ['number'=>51,'juz_number'=>26,'start_surah'=>46,'start_ayah'=>1,'end_surah'=>48,'end_ayah'=>17],
            ['number'=>52,'juz_number'=>26,'start_surah'=>48,'start_ayah'=>18,'end_surah'=>51,'end_ayah'=>30],
            ['number'=>53,'juz_number'=>27,'start_surah'=>51,'start_ayah'=>31,'end_surah'=>54,'end_ayah'=>55],
            ['number'=>54,'juz_number'=>27,'start_surah'=>55,'start_ayah'=>1,'end_surah'=>57,'end_ayah'=>29],
            ['number'=>55,'juz_number'=>28,'start_surah'=>58,'start_ayah'=>1,'end_surah'=>61,'end_ayah'=>14],
            ['number'=>56,'juz_number'=>28,'start_surah'=>62,'start_ayah'=>1,'end_surah'=>66,'end_ayah'=>12],
            ['number'=>57,'juz_number'=>29,'start_surah'=>67,'start_ayah'=>1,'end_surah'=>71,'end_ayah'=>28],
            ['number'=>58,'juz_number'=>29,'start_surah'=>72,'start_ayah'=>1,'end_surah'=>77,'end_ayah'=>50],
            ['number'=>59,'juz_number'=>30,'start_surah'=>78,'start_ayah'=>1,'end_surah'=>86,'end_ayah'=>17],
            ['number'=>60,'juz_number'=>30,'start_surah'=>87,'start_ayah'=>1,'end_surah'=>114,'end_ayah'=>6],

        ];



        foreach($hizbs as $hizb)
        {

            Hizb::create([

                'quran_id'=>1,

                ...$hizb

            ]);

        }


    }

}
