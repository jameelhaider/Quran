<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AyahAudio extends Model
{


protected $table='ayah_audio';



protected $fillable=[

'ayah_id',
'reciter',
'file'

];



public function ayah()
{

return $this->belongsTo(Ayah::class);

}


}
