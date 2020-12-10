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

Route::prefix('auth')->group(function () {
    Route::post('sign-up', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Route::prefix('post')->group(function () {
    Route::get('all', 'PostsController@index');
    Route::post('new', 'PostsController@store')->middleware('auth:api');
});
