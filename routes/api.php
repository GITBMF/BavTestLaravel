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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'JwtAuthController@login');
Route::post('register', 'JwtAuthController@register');

Route::post('logout', 'JwtAuthController@logout');


Route::group(['middleware' => 'auth.jwt'], function () {
    // Products
    Route::post('/storeProduct','ProductsModelController@store');
    Route::get('/products', 'ProductsModelController@index');
    Route::post('/deleteProduct/{id}', 'ProductsModelController@destroy');
    Route::post('/editProducts/{id}', 'ProductsModelController@edit');

    Route::get('user-info', 'JwtAuthController@getUser');
    
});
