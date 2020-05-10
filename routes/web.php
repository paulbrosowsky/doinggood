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
    Route::get('/profiles/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
    Route::post('/profiles/{user}', 'ProfilesController@update')->name('profile.update');    
    Route::post('/profiles/{user}/avatar', 'UserAvatarsController@update')->name('profile.avatar');

    Route::post('/account/update/email', 'UserAccountsController@updateEmail' )->name('account.email');
    Route::post('/account/update/password', 'UserAccountsController@updatePassword' )->name('account.password');
    Route::delete('/account/destroy', 'UserAccountsController@destroy')->name('account.destroy');
});




