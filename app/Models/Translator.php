<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Translator extends Model
{


protected $fillable=[

'name',
'language',
'bio'

];



public function translations()
{

return $this->hasMany(
AyahTranslation::class
);

}


}
