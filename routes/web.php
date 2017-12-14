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
	return redirect()->route('todo.browse');
});

// Auth routes
Auth::routes();

/**
 * Todo routes
 */
// GET
Route::get('/todos/', 'TodoController@index')->name('todo.browse');
Route::get('/todo/create/', 'TodoController@create')->name('todo.create');
Route::get('/todo/edit/{todoId}/', 'TodoController@edit')->name('todo.edit');
Route::get('/todo/{todoId}/tasks/', 'TodoController@show')->name('todo.show');

// POST
Route::post('/todo/create/', 'TodoController@store')->name('todo.store');
Route::post('/todo/edit/{todoId}/', 'TodoController@update')->name('todo.update');

// DELETE
Route::delete('/todo/edit/{todoId}/', 'TodoController@destroy')->name('todo.destroy');

/**
 * Task routes
 */
// GET
Route::get('/todo/{todoId}/task/create/', 'TaskController@create')->name('task.create');
Route::get('/todo/{todoId}/task/{taskId}/', 'TaskController@show')->name('task.show');
Route::get('/todo/{todoId}/task/{taskId}/edit/', 'TaskController@edit')->name('task.edit');

// POST
Route::post('/todo/{todoId}/task/create/', 'TaskController@store')->name('task.store');
Route::post('/todo/{todoId}/task/{taskId}/edit/', 'TaskController@update')->name('task.update');

// DELETE
Route::delete('/todo/{todoId}/tasks/', 'TaskController@destroy')->name('task.destroy');
