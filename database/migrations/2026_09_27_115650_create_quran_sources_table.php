<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('quran_sources', function (Blueprint $table) {


            $table->id();


            /*
            Quran relation
            */

            $table->foreignId('quran_id')
                ->constrained()
                ->cascadeOnDelete();



            /*
            Source information
            */


            $table->string('name');


            /*
            Example:
            Tanzil Quran Text
            */


            $table->string('publisher')
                ->nullable();


            /*
            Organization/person
            */


            $table->text('description')
                ->nullable();



            /*
            Source website/document
            */

            $table->string('url')
                ->nullable();



            /*
            Dataset version
            */


            $table->string('version')
                ->nullable();



            /*
            Original language
            */


            $table->string('language')
                ->default('Arabic');



            /*
            Type:

            arabic_text
            translation
            tafsir
            audio

            */


            $table->enum('type',[

                'arabic_text',
                'translation',
                'tafsir',
                'audio'

            ]);



            /*
            Verification status

            pending
            verified
            rejected

            */


            $table->enum('status',[

                'pending',
                'verified',
                'rejected'

            ])
            ->default('pending');



            /*
            Who verified it
            */


            $table->string('verified_by')
                ->nullable();



            $table->timestamp('verified_at')
                ->nullable();



            $table->timestamps();



        });

    }


    public function down(): void
    {

        Schema::dropIfExists('quran_sources');

    }

};
