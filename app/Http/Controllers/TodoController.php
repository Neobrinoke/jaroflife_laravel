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
		$this->middleware('auth');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('todo.index', ['todos' => Auth::user()->todos]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('todo.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$todo = Todo::create([
			'name' => $request->input('name'),
			'description' => $request->input('description'),
			'author_id' => Auth::user()->id
		]);
		
		TodosUser::create([
			'user_id' => Auth::user()->id,
			'todo_id' => $todo->id,
			'authority_id' => 1
		]);
		return redirect()->route('todo.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function show(Todo $todo)
	{
		$this->authorize('show', $todo);

		$title = "Mes tâches pour la liste [$todo->name]";
		return view('task.index', compact('todo', 'title'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Todo $todo)
	{
		$this->authorize('edit', $todo);

		$title = "Détails de la liste [$todo->name]";
		return view('todo.edit', compact('todo', 'title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Todo $todo)
	{
		$this->authorize('edit', $todo);

		if( $request->has('edit_todo'))
		{
			$todo->name = $request->input('name');
			$todo->description = $request->input('description');
			$todo->save();
		}
		else if($request->has('edit_member') || $request->has('expulse_member'))
		{
			$todo_user = TodosUser::where([
				'user_id' => $request->input('user_id'),
				'todo_id' => $todo->id
			])->firstOrFail();

			if($request->has('edit_member'))
			{
				$todo_user->authority_id = $request->input('authority_id');
				$todo_user->save();
			}
			else $todo_user->delete();
		}
		return redirect()->route('todo.edit', compact('todo'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Todo $todo)
	{
		$this->authorize('edit', $todo);

		TodosUser::where('todo_id', $todo->id)->delete();
		Task::where('todo_id', $todo->id)->delete();
		$todo->delete();
		return redirect()->route('todo.index');
	}
}
