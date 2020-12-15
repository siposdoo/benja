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
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('image', 'ImageController@store')->middleware('auth:api');
    Route::post('addproduct', 'ProductController@store')->middleware('auth:api');
    Route::post('deleteimage', 'ImageController@deleteImage')->middleware('auth:api');
    
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('products', 'ProductController@index')->middleware('auth:api');
    Route::get('kompanije', 'KompanijaController@index')->middleware('auth:api');
    });