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

Route::get('login', 'JwtAuthController@login');
Route::post('register', 'JwtAuthController@register');



Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'JwtAuthController@logout');
    // Users
    Route::get('/users', 'UsersController@index');
    Route::delete('/deleteUser/{id}', 'UsersController@destroy');
    // Products
    Route::post('/storeProduct','ProductsModelController@store');
    Route::get('/products', 'ProductsModelController@index');
    Route::delete('/deleteProduct/{id}', 'ProductsModelController@destroy');
    Route::post('/editProducts/{id}', 'ProductsModelController@edit');

    Route::get('user-info', 'JwtAuthController@getUser');
    
});
