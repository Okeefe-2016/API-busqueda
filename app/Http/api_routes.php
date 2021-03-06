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

Route::get('sugeridos/{id}', 'SuggestedAPIController@show');

Route::get('propiedades/lists', 'PropiedadAPIController@byIds');

Route::get('propiedades/lastest/{total}', 'PropiedadAPIController@lastCreated');

Route::get('propiedades/{tipo}/{operacion}', 'UbicacionPropiedadAPIController@getUbicacionPropiedad');

Route::get('ubicacion/{zona}/{tipo}/{operacion}', 'UbicacionAPIController@index');

Route::get('emprendimientos', 'EmprendimientoAPIController@index');

Route::resource('jobApplication', 'jobApplicationController');

Route::resource ('propertypdf', 'PdfController');