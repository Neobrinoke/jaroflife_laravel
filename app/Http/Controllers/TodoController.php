<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Task;
use App\TodosUser;

class TodoController extends Controller
{
	public function __construct() {
		$this->middleware( 'auth' );
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view( 'todo.index', ['todos' => Auth::user()->todos] );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request )
	{
		$validate_data = $request->validate([
            'name' => 'required|string|max:255|min:4',
            'description' => 'required|string|max:255|min:10',
		]);
		$validate_data['author_id'] = Auth::id();
		
		$todo = Todo::create( $validate_data );
		
		TodosUser::create([
			'user_id' => Auth::id(),
			'todo_id' => $todo->id,
			'authority_id' => 1
		]);
		return redirect()->route( 'todo.index' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function show( Todo $todo )
	{
		$this->authorize( 'show_todo', $todo );

		$title = "Mes tâches pour la liste [$todo->name]";
		return view( 'todo.show', compact( 'todo', 'title' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Todo $todo )
	{
		$this->authorize( 'edit_todo', $todo );

		$title = "Détails de la liste [$todo->name]";
		return view( 'todo.edit', compact( 'todo', 'title' ) );
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
		$this->authorize( 'edit_todo', $todo );

		if( $request->has( 'edit_todo' ) )
		{
			$validate_data = $request->validate([
				'name' => 'required|string|max:255|min:4',
				'description' => 'required|string|max:255|min:10',
			]);

			$todo->fill( $validate_data );
			$todo->save();
		}
		else if( $request->has( 'edit_member' ) || $request->has( 'expulse_member' ) )
		{
			$todo_user = TodosUser::findByTodoAndUser( $todo->id, $request->input( 'user_id' ) );
			if( $request->has( 'edit_member' ) )
			{
				$todo_user->authority_id = $request->input( 'authority_id' );
				$todo_user->save();
			}
			else $todo_user->delete();
		}
		return redirect()->route( 'todo.edit', compact( 'todo' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Todo $todo )
	{
		$this->authorize( 'edit_todo', $todo );

		TodosUser::where( 'todo_id', $todo->id )->delete();
		Task::where( 'todo_id', $todo->id )->delete();
		$todo->delete();
		return redirect()->route( 'todo.index' );
	}
}
