<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class QuranSource extends Model
{


    protected $fillable = [


        'quran_id',

        'name',

        'publisher',

        'description',

        'url',

        'version',

        'language',

        'type',

        'status',

        'verified_by',

        'verified_at'


    ];



    protected $casts = [

        'verified_at'=>'datetime'

    ];



    /*
    Relation:
    Source belongs to Quran
    */


    public function quran()
    {

        return $this->belongsTo(Quran::class);

    }


}
