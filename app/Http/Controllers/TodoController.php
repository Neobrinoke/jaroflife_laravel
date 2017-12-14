<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Todo;
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
	public function index()
	{
		$todos = TodosUser::where('user_id', Auth::user()->id)->get();
		return view('todo.browse', compact('todos'));
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
		return redirect()->route('todo.browse');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $todoId
	 * @return \Illuminate\Http\Response
	 */
	public function show($todoId)
	{
		$todo = Todo::find($todoId);
		if(Auth::user()->can('show', $todo))
		{
			$title = "Mes tâches pour la liste [$todo->name]";
			return view('task.browse', compact('todo', 'title'));
		}
		else return view('no_perm');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $todoId
	 * @return \Illuminate\Http\Response
	 */
	public function edit($todoId)
	{
		$todo = Todo::findOrFail($todoId);
		if(Auth::user()->can('edit', $todo))
		{
			$title = "Détails de la liste [$todo->name]";
			return view('todo.edit', compact('todo', 'title'));
		}
		else return view('no_perm');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $todoId
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $todoId)
	{
		$todo = Todo::findOrFail($todoId);
		if(Auth::user()->can('edit', $todo))
		{
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
			return redirect()->route('todo.edit', compact('todoId'));
		}
		else return view('no_perm');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $todoId
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($todoId)
	{
		$todo = Todo::findOrFail($todoId);
		if(Auth::user()->can('edit', $todo))
		{
			TodosUser::where('todo_id', $todo->id)->delete();
			Task::where('todo_id', $todo->id)->delete();
			$todo->delete();
			return redirect()->route('todo.browse');
		}
		else return view('no_perm');
	}
}
