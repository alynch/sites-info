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

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard');

Route::resource('/environments', EnvironmentsController::class);
Route::resource('/application-groups', ApplicationGroupsController::class);
Route::resource('/applications', ApplicationsController::class);

Route::get('/timeline', 'TimelineController@index');

Route::get('/applications/{id}/status', 'ApplicationsController@status');
