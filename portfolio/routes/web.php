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
    return view('index');
})->name("main");

Route::prefix('/social-auth/github')->group(function () {
    Route::get('/', function () {return Socialite::driver("github")->scopes(['groups'])->redirect();})->name('auth.social');
    Route::get('/callback', Auth\SocialController::class)->name('auth.social.callback');
    Route::get('/delete', function (){Auth\SocialAccount::where('id_user', auth()->id())->first()->delete();return back();})->name('auth.delete');

});
