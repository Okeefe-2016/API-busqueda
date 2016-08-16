<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/

Route::resource('caracteristicas', 'CaracteristicaAPIController');

Route::resource('domicilios', 'DomicilioAPIController');

Route::resource('localidades', 'LocalidadAPIController');

Route::resource('pais', 'PaisAPIController');

Route::get('propiedad', 'UbicacionPropiedadAPIController@getUbicacionPropiedad');

