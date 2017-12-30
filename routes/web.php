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
	return redirect()->route('todo.index');
});

// Auth routes
Auth::routes();

/**
 * Todo routes
 */
Route::get('/todos/', 'TodoController@index')->name('todo.index');
Route::get('/todo/edit/{todo}/', 'TodoController@edit')->name('todo.edit');
Route::get('/todo/{todo}/tasks/', 'TodoController@show')->name('todo.show');
Route::post('/todos/create', 'TodoController@store')->name('todo.store');
Route::post('/todo/edit/{todo}/edit_collab', 'TodoController@edit_collab')->name('todo.edit_collab');
Route::post('/todo/edit/{todo}/add_collab', 'TodoController@add_collab')->name('todo.add_collab');
Route::post('/todo/edit/{todo}/update', 'TodoController@update')->name('todo.update');
Route::post('/todo/edit/{todo}/destroy', 'TodoController@destroy')->name('todo.destroy');

/**
 * Task routes
 */
Route::post('/todo/{todo}/tasks/store', 'TaskController@store')->name('task.store');
Route::post('/todo/{todo}/tasks/{task}/update', 'TaskController@update')->name('task.update');
Route::post('/todo/{todo}/tasks/{task}/destroy', 'TaskController@destroy')->name('task.destroy');