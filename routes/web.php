<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('email_crear_sala');
});

Route::group(['middleware' => 'cors'], function(){
	Route::post('Login','loginController@Acceso');

	Route::group(['middleware' => ['jwt.auth']], function ()
        {
		Route::post('getRooms','roomsController@getRooms');
		Route::post('getAmigos','usuariosController@getAmigos');
		Route::post('addRoom','roomsController@addRoom');
		});
});

