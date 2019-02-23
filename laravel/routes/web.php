<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/i', function () {
    $pdo     = \DB::connection()->getPdo();

    $db_version = $pdo->query('select version()')->fetchColumn();

    $laravel_version = app()::VERSION;

    dd($db_version, $laravel_version);
});



Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard');

Route::resource('/units', UnitsController::class);
Route::resource('/features', FeaturesController::class);
Route::resource('/environments', EnvironmentsController::class);
Route::resource('/application-groups', ApplicationGroupsController::class);
Route::resource('/applications', ApplicationsController::class);

Route::get('/timeline', 'TimelineController@index');
Route::delete('/timeline/{id}', 'TimelineController@destroy');

Route::get('/applications/{id}/status', 'ApiController@status');
Route::post('/applications/clear', 'ApiController@clear');


Route::get('/info', 'ApiController@info');
