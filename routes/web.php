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

        Route::group([
            'middleware' => 'is.helper:0'
        ], function(){
            Route::get('needs/create', 'NeedsController@create')->name('need.create');        
            Route::post('needs/store', 'NeedsController@store')->name('need.store');  
               
            Route::patch('needs/{need}', 'NeedsController@update')->name('need.update');
            Route::get('needs/{need}/edit', 'NeedsController@edit')->name('need.edit');   
            Route::post('needs/{need}/image', 'NeedImagesController@update')->name('need.image');
            Route::delete('needs/{need}', 'NeedsController@destroy')->name('need.destroy');
            Route::put('needs/{need}/assign', 'NeedsController@assign')->name('need.assign');
            Route::put('needs/{need}/complete', 'NeedsController@complete')->name('need.complete');
            Route::put('needs/{need}/reopen', 'NeedsController@reopen')->name('need.reopen');

            Route::put('/helps/{help}/assign', 'HelpsController@assign')->name('help.assign');
            Route::put('/helps/{help}/reject', 'HelpsController@reject')->name('help.reject');
        });

        Route::group([
            'middleware' => 'is.helper:1'
        ], function(){            
            Route::post('needs/{need}/question', 'NeedQuestionsController@create')->name('need.question');  
            Route::post('needs/{need}/help', 'HelpsController@store')->name('help.store');
            
            Route::delete('/helps/{help}', 'HelpsController@destroy')->name('help.destroy');
                    
        });   
        
        Route::put('/helps/{help}/complete', 'HelpsController@complete')->name('help.complete');   
        Route::post('helps/{help}/comment', 'CommentsController@store')->name('comment.store');
        Route::put('comments/{comment}', 'CommentsController@update')->name('comment.update');
        Route::delete('comments/{comment}', 'CommentsController@destroy')->name('comment.destroy');
    });
});

Route::get('/needs', 'NeedsController@index')->name('needs');
Route::get('/needs/{need}', 'NeedsController@show')->name('need');

Route::get('/imprint', 'StaticPagesController@imprint')->name('imprint');
Route::get('/privacy', 'StaticPagesController@privacy')->name('privacy');
Route::get('/terms', 'StaticPagesController@terms')->name('terms');
Route::get('/faq', 'StaticPagesController@faq')->name('faq');

Route::get('mail', function () {     
    $admin = App\User::where('email', config('doinggood.administrators')[0])
        ->first();   
        
    $user = App\User::where('id', 2)->first();
    $need = App\Need::first();
    $help = App\Help::first();
        
    return (new App\Notifications\HelpWasCompleted($help, 'hallo'))
                ->toMail($user);
});