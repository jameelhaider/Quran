<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('juzs', function(Blueprint $table){

    $table->id();


    $table->foreignId('quran_id')
    ->constrained()
    ->cascadeOnDelete();


    $table->unsignedInteger('number');


   $table->string('name_arabic')
->nullable();


$table->string('name_english')
->nullable();



    // Starting point

    $table->unsignedInteger('start_surah');

    $table->unsignedInteger('start_ayah');


    // Ending point

    $table->unsignedInteger('end_surah');

    $table->unsignedInteger('end_ayah');


    $table->timestamps();


    $table->unique([
        'quran_id',
        'number'
    ]);

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juzs');
    }
};
