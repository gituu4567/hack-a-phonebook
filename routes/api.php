<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

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

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('phonebook/create', 'PhonebookController@create');
    Route::get('phonebook/read', 'PhonebookController@read');
    Route::get('phonebook/update', 'PhonebookController@update');
    Route::get('phonebook/delete', 'PhonebookController@delete');
    Route::get('phonebook/remove', 'PhonebookController@remove');
});
