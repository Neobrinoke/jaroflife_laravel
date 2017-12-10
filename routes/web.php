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

// Todo routes
Route::get('/todos', 'TodoController@index')->name('todo.browse');
Route::get('/todo/create', 'TodoController@create')->name('todo.create');
Route::get('/todo/edit/{todoId}', 'TodoController@edit')->name('todo.edit');
Route::post('/todo/create', 'TodoController@store')->name('todo.store');
Route::post('/todo/edit/{todoId}', 'TodoController@update')->name('todo.update');
Route::delete('/todo/edit/{todoId}', 'TodoController@destroy')->name('todo.destroy');

// Task routes
Route::get('/todo/{todoId}/tasks', 'TaskController@index')->name('task.browse');
Route::get('/task/create/{todoId}', 'TaskController@create')->name('task.create');
Route::post('/task/create/{todoId}', 'TaskController@store')->name('task.store');
