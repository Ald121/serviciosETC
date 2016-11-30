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
    return view('welcome');
});

Route::group(['middleware' => 'cors'], function(){
	Route::get('Login','loginController@Acceso');
	Route::get('Registro','loginController@Registro');

	Route::group(['middleware' => ['jwt.auth']], function ()
        {
		Route::get('getRooms','roomsController@getRooms');
		Route::get('getAmigos','usuariosController@getAmigos');
		Route::get('addRoom','roomsController@addRoom');
		Route::get('addAmigo','usuariosController@addAmigo');
		Route::get('getRoomsCliente','roomsController@getRoomsCliente');
		Route::get('getEstadoRoom','roomsController@getEstadoRoom');
		Route::get('startRoom','roomsController@startRoom');
		Route::get('pausaRoom','roomsController@pausaRoom');
		Route::get('stopRoom','roomsController@stopRoom');
		Route::get('deleteRoom','roomsController@deleteRoom');
		});
});

