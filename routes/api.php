<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**LOGIN */
Route::post('/login', 'LoginController@check')->name('login.check');
/**Register */
Route::post('/register', 'RegisterController@store')->name('register.store');
/**Profile */
Route::resource('profile', 'ProfileController');
/**Pitstop */
Route::resource('pitstop', 'PitstopController');
Route::get('/pitstop/{latitude}/{longitude}', 'PitstopController@getRoute');
/**Review */
Route::resource('review', 'ReviewController');
/**Order */
Route::resource('order', 'OrderController');
