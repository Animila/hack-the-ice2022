<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('main');
})->name('main');

Route::prefix('/redactor')->group(function () {
    Route::get('/', SelectController::class)->name('redactor.select');
    Route::get('/{nick}', Git\Account\GetController::class)->name("redactor.index");
});


Route::prefix('/social-auth/github')->group(function () {
    Route::get('/', function () {return Socialite::driver("github")->scopes(['groups'])->redirect();})->name('auth.social');
    Route::get('/callback', Auth\SocialController::class)->name('auth.social.callback');
    Route::get('/delete', function (){auth()->logout(); return view('main');})->name('auth.delete');

});

