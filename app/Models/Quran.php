<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quran extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'language',
        'description'
    ];

    public function sources()
{

    return $this->hasMany(QuranSource::class);

}


    public function juzs()
    {
        return $this->hasMany(Juz::class);
    }


    public function hizbs()
    {
        return $this->hasMany(Hizb::class);
    }


    public function manzils()
    {
        return $this->hasMany(Manzil::class);
    }


    public function surahs()
    {
        return $this->hasMany(Surah::class);
    }

}
