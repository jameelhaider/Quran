<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuranController;
use App\Models\Quran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
     $totalsurahs=DB::table('surahs')->count();
     $totalAyahs=DB::table('ayahs')->count();
     $totalJuzs=DB::table('juzs')->count();
     $totalManzils=DB::table('manzils')->count();
    return view('welcome',compact('totalsurahs','totalAyahs','totalManzils','totalJuzs'));
});

   Route::get(
    '/surahs',
    [QuranController::class,'surahs']
)
->name('quran.read');



//     Route::get(
//     '/quran/surah/{surah}',
//     [QuranController::class,'surah']
// )
// ->name('quran.surah');




Route::middleware(['auth'])->group(function () {
    //user auth routes there
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
