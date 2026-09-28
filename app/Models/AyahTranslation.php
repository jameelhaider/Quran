<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AyahTranslation extends Model
{


protected $fillable=[

'ayah_id',
'language_id',
'translator_id',
'translation'

];




public function ayah()
{

return $this->belongsTo(Ayah::class);

}



public function language()
{

return $this->belongsTo(Language::class);

}



public function translator()
{

return $this->belongsTo(Translator::class);

}


}
