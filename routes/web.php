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
Route::get('/todo/create/', 'TodoController@create')->name('todo.create');
Route::get('/todo/edit/{todo}/', 'TodoController@edit')->name('todo.edit');
Route::get('/todo/{todo}/tasks/', 'TodoController@show')->name('todo.show');
Route::post('/todo/create/', 'TodoController@store')->name('todo.store');
Route::post('/todo/edit/{todo}/', 'TodoController@update')->name('todo.update');
Route::delete('/todo/edit/{todo}/', 'TodoController@destroy')->name('todo.destroy');

/**
 * Task routes
 */
Route::post('/todo/{todo}/tasks/', 'TaskController@update')->name('task.update');
Route::put('/todo/{todo}/tasks/', 'TaskController@store')->name('task.store');
Route::delete('/todo/{todo}/tasks/', 'TaskController@destroy')->name('task.destroy');