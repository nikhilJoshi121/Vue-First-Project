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

Route::resource('/add-category', 'CategoryController');
Route::get('/chat','ChatController@chat');

// Route::group(['prefix' => 'auth'], function () {
    
    route::post('register','Auth\AuthController@register');
    route::post('login','Auth\AuthController@login');
    
    Route::group(['middleware' => 'api'], function () {   
       Route::get('logout','Auth\AuthController@logout');   
    });
// });
