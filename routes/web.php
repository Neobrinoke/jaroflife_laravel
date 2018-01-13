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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get( '/', function ()
{
	return redirect()->route( 'todo.index' );
} );

/**
 * Auth routes
 */
Auth::routes();

/**
 * Todos Routes
 */
Route::get( '/todos/', 'TodoController@index' )->name( 'todo.index' );
Route::get( '/todo/edit/{todo}/', 'TodoController@edit' )->name( 'todo.edit' );
Route::get( '/todo/{todo}/tasks/', 'TodoController@show' )->name( 'todo.show' );
Route::post( '/todos/create', 'TodoController@store' )->name( 'todo.store' );
Route::post( '/todo/edit/{todo}/editCollab', 'TodoController@editCollab' )->name( 'todo.editCollab' );
Route::post( '/todo/edit/{todo}/addCollab', 'TodoController@addCollab' )->name( 'todo.addCollab' );
Route::post( '/todo/edit/{todo}/update', 'TodoController@update' )->name( 'todo.update' );
Route::post( '/todo/edit/{todo}/destroy', 'TodoController@destroy' )->name( 'todo.destroy' );

/**
 * Tasks routes
 */
Route::post( '/todo/{todo}/tasks/store', 'TaskController@store' )->name( 'task.store' );
Route::post( '/todo/{todo}/tasks/{task}/update', 'TaskController@update' )->name( 'task.update' );
Route::post( '/todo/{todo}/tasks/{task}/destroy', 'TaskController@destroy' )->name( 'task.destroy' );