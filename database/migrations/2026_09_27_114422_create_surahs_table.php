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
     Schema::create('surahs',function(Blueprint $table){


$table->id();



$table->foreignId('quran_id')
->constrained()
->cascadeOnDelete();



$table->unsignedInteger('number');



$table->string('name_arabic');

$table->string('name_english');


$table->enum(
'revelation_type',
[
'meccan',
'medinan'
]
);



$table->unsignedInteger(
'total_ayahs'
);



$table->text('description')
->nullable();



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
        Schema::dropIfExists('surahs');
    }
};
