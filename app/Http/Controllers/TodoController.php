<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Todo;
use App\Task;
use App\TodosUser;

class TodoController extends Controller
{
	public function __construct()
	{
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
	public function create()
	{
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
			'authority_id' => 3
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
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $todoId
	 * @return \Illuminate\Http\Response
	 */
	public function edit($todoId)
	{
		$todo = Todo::find($todoId);
		return view('todo.edit', compact('todo'));
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
		if($request->has('edit_todo'))
		{
			$todo = Todo::find($todoId);
			$todo->name = $request->input('name');
			$todo->description = $request->input('description');
			$todo->save();
		}
		else if($request->has('edit_member'))
		{
			$todo_user = TodosUser::where('user_id', $request->input('user_id'))->first();
			$todo_user->authority_id = $request->input('authority_id');
			$todo_user->save();
		}
		else if($request->has('expulse_member'))
		{
			$todo_user = TodosUser::where('user_id', $request->input('user_id'))->first()->delete();
		}
		return redirect()->route('todo.edit', ['todoId' => $todoId]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $todoId
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($todoId)
	{
		TodosUser::where('todo_id', $todoId)->delete();
		Task::where('todo_id', $todoId)->delete();
		Todo::find($todoId)->delete();
		return redirect()->route('todo.browse');
	}
}
