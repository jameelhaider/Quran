<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Tafsir extends Model
{


protected $fillable=[

'ayah_id',
'name',
'text'

];



public function ayah()
{

return $this->belongsTo(Ayah::class);

}


}
