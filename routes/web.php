<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\SurahController;
use App\Models\Quran;
use Database\Seeders\QuranSeeder;
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



Route::get('/surahs', [QuranController::class, 'surahs'])->name('surahs.index');
// Route::get('/surahs/{number}', [QuranController::class, 'show'])->name('surahs.show');


Route::get('/surahs/{number}', [SurahController::class, 'show'])
    ->whereNumber('number')->name('surahs.show');

Route::get('/surahs/{number}/translations', [SurahController::class, 'translations'])
    ->whereNumber('number')->name('surahs.translations');



Route::middleware(['auth'])->group(function () {
    //user auth routes there
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
