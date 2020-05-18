<?php

use GuzzleHttp\Middleware;
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

    Route::patch('profiles/{user}/unlock', 'UnlockProfilesController@update')->name('profile.unlock');
    
    Route::group([
        'middleware' => 'fully.verified'
    ], function(){

        Route::get('needs/create', 'NeedsController@create')->name('need.create');
        Route::post('needs/store', 'NeedsController@store')->name('need.store');
        
    });
});

Route::get('/needs', 'NeedsController@index')->name('needs');
Route::get('/needs/{need}', 'NeedsController@show')->name('need');



// Route::get('mail', function () {     
//     $admin = App\User::where('email', config('doinggood.administrators')[0])
//         ->first();   
        
//     $user = App\User::where('id', 2)->first();
        
//     return (new App\Notifications\UnlockProfile($user))
//                 ->toMail($admin);
// });




