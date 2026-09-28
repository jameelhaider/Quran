<?php

namespace App\Http\Controllers;

use App\Models\Quran;
use App\Models\Surah;


class QuranController extends Controller
{

    public function surah(Surah $surah)
    {

        $surah->load([
            'ayahs.translations'
        ]);


        return view(
            'quran.surah',
            compact('surah')
        );

    }


}
