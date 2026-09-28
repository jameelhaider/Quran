<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manzil;


class ManzilSeeder extends Seeder
{

    public function run(): void
    {


        $manzils = [


            [
                'number'=>1,

                'start_surah'=>1,
                'start_ayah'=>1,

                'end_surah'=>4,
                'end_ayah'=>176
            ],


            [
                'number'=>2,

                'start_surah'=>5,
                'start_ayah'=>1,

                'end_surah'=>9,
                'end_ayah'=>93
            ],


            [
                'number'=>3,

                'start_surah'=>9,
                'start_ayah'=>94,

                'end_surah'=>16,
                'end_ayah'=>128
            ],


            [
                'number'=>4,

                'start_surah'=>17,
                'start_ayah'=>1,

                'end_surah'=>25,
                'end_ayah'=>20
            ],


            [
                'number'=>5,

                'start_surah'=>25,
                'start_ayah'=>21,

                'end_surah'=>36,
                'end_ayah'=>27
            ],


            [
                'number'=>6,

                'start_surah'=>36,
                'start_ayah'=>28,

                'end_surah'=>49,
                'end_ayah'=>18
            ],


            [
                'number'=>7,

                'start_surah'=>50,
                'start_ayah'=>1,

                'end_surah'=>114,
                'end_ayah'=>6
            ],


        ];



        foreach($manzils as $manzil)
        {


            Manzil::create([

                'quran_id'=>1,

                ...$manzil

            ]);


        }


    }

}
