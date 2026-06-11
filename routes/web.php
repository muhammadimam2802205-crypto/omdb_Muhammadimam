<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelControl\DashboardController;
use App\Http\Controllers\PanelControl\MovieController;
use App\Http\Controllers\PanelControl\FavController;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'id'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);

    return redirect()->back();
})->name('lang.switch');
Route::get('/',[AuthController::class,'index'])->name('login');
Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/register',[AuthController::class,'register_process'])
->name('signup');
Route::post('/login',[AuthController::class,'login_process'])
->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('signout');

Route::post('favorites/add', [FavController::class, 'add']);
Route::delete('favorites/{imdbID}', [FavController::class, 'destroy']);
// Route::get('/dashboard', function(){
//     return view('controlpanel.dashboard');
// })->name('dashboard');

// Route::get('/Fav', function(){
//     return view('controlpanel.Fav');
// });

// Route group untuk panel admin
Route::prefix('panel-control')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [MovieController::class, 'index'])
        ->name('dashboard');
    Route::get('/Fav', [FavController::class, 'index'])
        ->name('Fav');
    Route::get('/movies/{imdbID}', [MovieController::class, 'detail'])
        ->name('movies.detail');

});