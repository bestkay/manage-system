<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
	$router->resource('doctors', DoctorController::class);
	$router->resource('diseases', DiseaseController::class);
	$router->resource('media', MediaController::class);
	$router->resource('departments', DepartmentController::class);
	$router->resource('engines', EngineController::class);
	$router->resource('areas', AreaController::class);
	$router->resource('patients', PatientController::class);
});
