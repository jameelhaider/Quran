<?php
use App\Http\Controllers\QuranController;
use App\Models\Quran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
     $quran = Quran::with([
            'surahs',
            'juzs',
            'hizbs',
            'manzils'
        ])
        ->first();
    return view('welcome',compact('quran'));
});


    Route::get(
    '/quran/surah/{surah}',
    [QuranController::class,'surah']
)
->name('quran.surah');




Route::middleware(['auth'])->group(function () {
    //user auth routes there
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
