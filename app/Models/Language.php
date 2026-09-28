<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Language extends Model
{


protected $fillable=[

'name',
'code'

];



public function translations()
{

return $this->hasMany(
AyahTranslation::class
);

}


}
