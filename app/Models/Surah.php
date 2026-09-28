<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Surah extends Model
{


protected $fillable=[

'quran_id',
'number',
'name_arabic',
'name_english',
'name_urdu',
'revelation_type',
'total_ayahs',
'description'

];



public function quran()
{

return $this->belongsTo(Quran::class);

}




public function ayahs()
{

return $this->hasMany(Ayah::class);

}


}
