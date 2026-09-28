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
      Schema::create('ayah_translations',function(Blueprint $table){


$table->id();


$table->foreignId('ayah_id')
->constrained()
->cascadeOnDelete();



$table->foreignId('language_id')
->constrained();



$table->foreignId('translator_id')
->nullable()
->constrained();



$table->text('translation');



$table->timestamps();



});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayah_translations');
    }
};
