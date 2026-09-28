<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ayah extends Model
{


protected $fillable=[

'surah_id',
'ayah_number',
'arabic_text',
'transliteration',
'page_number',
'juz_number',
'hizb_number',
'is_sajdah'

];



protected $casts=[

'is_sajdah'=>'boolean'

];



public function surah()
{

return $this->belongsTo(Surah::class);

}




public function translations()
{

return $this->hasMany(
AyahTranslation::class
);

}




public function tafsirs()
{

return $this->hasMany(Tafsir::class);

}




public function audio()
{

return $this->hasMany(AyahAudio::class);

}


}
