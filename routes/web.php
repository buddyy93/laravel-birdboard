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
    return view('welcome');
});

Route::resource('projects', 'ProjectController');

Route::post('projects/{project}/tasks', ['as' => 'project.add.task', 'uses' => 'ProjectTaskController@store']);
Route::patch('projects/{project}/tasks/{task}', ['as' => 'project.edit.task', 'uses' => 'ProjectTaskController@update']);
Route::resource('projects/task', 'ProjectTaskController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
