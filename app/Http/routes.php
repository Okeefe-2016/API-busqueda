<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => '/', function () {
    return view('index');
}]);
Route::get('/home', function () {
    return redirect()->route('/');
});
/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api', 'namespace' => 'API', 'middleware' => '\Barryvdh\Cors\HandleCors::class'],
    function () {
        Route::group(['prefix' => 'v1'], function () {
            require config('infyom.laravel_generator.path.api_routes');
        });
    });

Route::group(['prefix' => 'api/v1', 'middleware' => '\Barryvdh\Cors\HandleCors::class'],
    function () {
        Route::get('propiedad/{id}', 'PropiedadesController@show');
    });

Route::resource('jobApplication', 'jobApplicationController', [])->middleware('\Barryvdh\Cors\HandleCors::class');
