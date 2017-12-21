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
// GET
Route::get('/todos/', 'TodoController@index')->name('todo.index');
Route::get('/todo/create/', 'TodoController@create')->name('todo.create');
Route::get('/todo/edit/{todo}/', 'TodoController@edit')->name('todo.edit');
Route::get('/todo/{todo}/tasks/', 'TodoController@show')->name('todo.show');

// POST
Route::post('/todo/create/', 'TodoController@store')->name('todo.store');
Route::post('/todo/edit/{todo}/', 'TodoController@update')->name('todo.update');

// DELETE
Route::delete('/todo/edit/{todo}/', 'TodoController@destroy')->name('todo.destroy');

/**
 * Task routes
 */
// GET
Route::get('/todo/{todo}/task/create/', 'TaskController@create')->name('task.create');
Route::get('/todo/{todo}/task/{task}/', 'TaskController@show')->name('task.show');
Route::get('/todo/{todo}/task/{task}/edit/', 'TaskController@edit')->name('task.edit');

// POST
Route::post('/todo/{todo}/task/create/', 'TaskController@store')->name('task.store');
Route::post('/todo/{todo}/task/{task}/edit/', 'TaskController@update')->name('task.update');

// DELETE
Route::delete('/todo/{todo}/tasks/', 'TaskController@destroy')->name('task.destroy');