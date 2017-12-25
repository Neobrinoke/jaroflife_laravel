<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Todo;
use App\Task;

class TaskController extends Controller
{
	public function __construct() {
		$this->middleware( 'auth' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Todo  $todo
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request, Todo $todo )
	{
		$this->authorize( 'create_task', $todo );

		$validate_data = $request->validate([
			'name' => 'required|string|max:255|min:4',
			'description' => 'required|string|max:255|min:10',
			'priority' => 'required|int'
		]);
		$validate_data['author_id'] = Auth::id();
		$validate_data['todo_id'] = $todo->id;

		Task::create( $validate_data );
		return redirect()->route( 'todo.show', compact( 'todo' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Todo $todo )
	{
		$task = Task::findByTodo( $todo->id, $request->input( 'task_id' ) );
		$this->authorize( 'edit_task', [$todo, $task] );

		$validate_data = $request->validate([
			'name' => 'required|string|max:255|min:4',
			'description' => 'required|string|max:255|min:10',
			'priority' => 'required|int'
		]);

		$task->fill( $validate_data );
		$task->save();
		return redirect()->route( 'todo.show', compact( 'todo' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Request $request, Todo $todo )
	{
		$task = Task::findByTodo( $todo->id, $request->input( 'task_id' ) );
		$this->authorize( 'edit_task', [$todo, $task] );

		$task->delete();
		return redirect()->route( 'todo.show', compact( 'todo' ) );
	}
}
