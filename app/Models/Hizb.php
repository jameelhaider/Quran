<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Hizb extends Model
{


protected $fillable=[

'quran_id',
'number',
'juz_number',
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
