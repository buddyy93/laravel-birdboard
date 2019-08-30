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

Route::get('/', 'ProjectController@index')->middleware('verified');;

Route::resource('projects', 'ProjectController');
Route::resource('projects/task', 'ProjectTaskController');

Route::post('projects/{project}/tasks', ['as' => 'project.add.task', 'uses' => 'ProjectTaskController@store']);
Route::post('projects/{project}/members', ['as' => 'project.add.member', 'uses' => 'ProjectMemberController@store']);
Route::patch('projects/{project}/tasks/{task}', ['as' => 'project.edit.task', 'uses' => 'ProjectTaskController@update']);

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/queue', function () {
    dispatch(function () {
        logger('Hello World again');
    })->delay(now()->addMinute(1));
});


Route::get('/throttle', function () {
    return 'hellow world';
})->middleware('throttle:4,1');


Route::get('/logoutOthers', function () {
    auth()->logoutOtherDevices('password');

    return redirect('/');
});

Route::get('email', function () {
    return new \App\Mail\ProjectMail();
});

Route::get('res', function () {
//    return \App\Project::with('tasks')->find(3);
    return new \App\Http\Resources\ProjectResource(\App\Project::find(2));
});

Route::get('echo', function () {
    event(new \App\Events\BirdEcho('Yeah'));
});
