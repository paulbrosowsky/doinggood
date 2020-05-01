<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes(['verify' => true]);

Route::get('/home', function(){
    return redirect(route('profile', auth()->user()->username));
})->name('home');

Route::get('/', function () {
    return redirect('needs');
});

Route::get('/needs', 'NeedsController@index')->name('needs');
Route::get('/needs/{need}', 'NeedsController@show')->name('need');

Route::group([
    'middleware' => 'auth'
], function(){

    Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

});




