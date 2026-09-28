<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juz extends Model
{


protected $fillable = [

    'quran_id',

    'number',

    'name_arabic',

    'name_english',

    'name_urdu',

    'start_surah',

    'start_ayah',

    'end_surah',

    'end_ayah'

];


    public function quran()
    {
        return $this->belongsTo(Quran::class);
    }


}
