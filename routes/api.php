<?php

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


use Dingo\Api\Routing\Router;
/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('register', 'App\\Api\\V1\\Controllers\\RegisterController@register');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');
    });

    $api->group(['middleware' => 'jwt.auth|bindings', 'prefix' => 'contacts'], function(Router $api) {
        $api->post('create', 'App\\Api\\V1\\Controllers\\ContactsController@create');
        $api->get('get', 'App\\Api\\V1\\Controllers\\ContactsController@getAll');
        $api->get('get/{contact}', 'App\\Api\\V1\\Controllers\\ContactsController@get');
        $api->post('update/{contact}', 'App\\Api\\V1\\Controllers\\ContactsController@update');
        $api->delete('delete/{contact}', 'App\\Api\\V1\\Controllers\\ContactsController@delete');
    });
});
