<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Todo;
use App\Task;

class TaskController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  \App\Todo  $todo
	 * @return \Illuminate\Http\Response
	 */
	public function create(Todo $todo) {
		return view('task.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Todo  $todo
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, Todo $todo)
	{
		Task::create([
			'name' => $request->input('name'),
			'description' => $request->input('description'),
			'priority' => $request->input('priority'),
			'author_id' => Auth::id(),
			'todo_id' => $todo->id
		]);
		return redirect()->route('todo.show', compact('todo'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Todo  $todo
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function show(Todo $todo, Task $task)
	{
		if(Auth::user()->can('show', $task))
		{
			$title = "Tâche - $task->name";
			return view('task.show', compact('todo', 'task', 'title'));
		}
		else return view('no_perm');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Todo  $todo
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Todo $todo, Task $task)
	{
		if(Auth::user()->can('edit', $task))
		{
			$title = "Modifier la tâche - $task->name";
			return view('task.edit', compact('todoId', 'task', 'title'));
		}
		else return view('no_perm');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Todo  $todo
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Todo $todo, Task $task)
	{
		if(Auth::user()->can('edit', $task))
		{
			$task->name = $request->input('name');
			$task->description = $request->input('description');
			$task->save();
			return redirect()->route('task.show', compact('todo', 'task'));
		}
		else return view('no_perm');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Todo  $todo
	 * @param  \App\Task  $task
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, Todo $todo)
	{
		$task = Task::findByTodo($todo->id, $request->input('task_id'));
		if(Auth::user()->can('edit', $task))
		{
			$task->delete();
			return redirect()->route('todo.show', compact('todo'));
		}
		else return view('no_perm');
	}
}
