<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Manzil extends Model
{


protected $fillable=[

'quran_id',
'number',
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
