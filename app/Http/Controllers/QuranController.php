<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Quran;
use App\Models\Surah;
use Illuminate\Support\Facades\DB;


class QuranController extends Controller
{

    // public function surah(Surah $surah)
    // {

    //     $surah->load([
    //         'ayahs.translations'
    //     ]);


    //     return view(
    //         'quran.surah',
    //         compact('surah')
    //     );

    // }



    public function surahs()
    {
        $surahs=DB::table('surahs')->get();
        return view('quran.surah',compact('surahs'));
    }


}
