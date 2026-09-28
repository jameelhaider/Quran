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
        Schema::create('manzils',function(Blueprint $table){


$table->id();


$table->foreignId('quran_id')
->constrained()
->cascadeOnDelete();


$table->unsignedInteger('number');


$table->unsignedInteger('start_surah');

$table->unsignedInteger('start_ayah');


$table->unsignedInteger('end_surah');

$table->unsignedInteger('end_ayah');


$table->timestamps();


});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manzils');
    }
};
