<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('addperson', 'App\Http\Controllers\Api\PersonController@store');
Route::post('change', 'App\Http\Controllers\Api\PersonController@changestatus');

Route::get('people', 'App\Http\Controllers\Api\PersonController@index');


// Route::get('register', 'App\Http\Controllers\Api\RegisterController@register');




	
