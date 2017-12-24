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
		Task::create([
			'name' => $request->input( 'name' ),
			'description' => $request->input( 'description' ),
			'priority' => $request->input( 'priority' ),
			'author_id' => Auth::id(),
			'todo_id' => $todo->id
		]);
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
		$task = Task::findOrFail( $request->input( 'task_id' ) );
		$this->authorize( 'edit', $todo, $task );

		$task->name = $request->input( 'name' );
		$task->description = $request->input( 'description' );
		$task->priority = $request->input( 'priority' );
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

		$this->authorize( 'delete', $task );

		$task->delete();
		return redirect()->route( 'todo.show', compact( 'todo' ) );
	}
}
