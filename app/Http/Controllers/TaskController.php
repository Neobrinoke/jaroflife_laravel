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
	 * @return \Illuminate\Http\Response
	 */
	public function create($todoId) {
		return view('task.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $todoId)
	{
		Task::create([
			'name' => $request->input('name'),
			'description' => $request->input('description'),
			'priority' => $request->input('priority'),
			'author_id' => Auth::user()->id,
			'todo_id' => $todoId
		]);
		return redirect()->route('todo.show', compact('todoId'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($todoId, $taskId)
	{
		$task = Task::findByTodo($todoId, $taskId);
		if(Auth::user()->can('show', $task))
		{
			$title = "Tâche - $task->name";
			return view('task.show', compact('todoId', 'task', 'title'));
		}
		else return view('no_perm');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $todoId
	 * @param  int  $taskId
	 * @return \Illuminate\Http\Response
	 */
	public function edit($todoId, $taskId)
	{
		$task = Task::findByTodo($todoId, $taskId);
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
	 * @param  int  $todoId
	 * @param  int  $taskId
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $todoId, $taskId)
	{
		$task = Task::findByTodo($todoId, $taskId);
		if(Auth::user()->can('edit', $task))
		{
			$task->name = $request->input('name');
			$task->description = $request->input('description');
			$task->save();
			return redirect()->route('task.edit', compact('todoId', 'taskId'));
		}
		else return view('no_perm');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $todoId
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $todoId)
	{
		$task = Task::findByTodo($todoId, $request->input('task_id'));
		if(Auth::user()->can('edit', $task))
		{
			$task->delete();
			return redirect()->route('todo.show', compact('todoId'));
		}
		else return view('no_perm');
	}
}
