<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Todo $todo
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Todo $todo)
    {
        $this->authorize('create_task', $todo);

        $validate_data = $request->validate([
            'name' => 'required|string|max:255|min:4',
            'description' => 'required|string|max:255|min:10',
            'priority' => 'required|int'
        ]);
        $validate_data['author_id'] = Auth::id();
        $validate_data['todo_id'] = $todo->id;

        Task::create($validate_data);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Todo $todo
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Todo $todo, Task $task)
    {
        $this->authorize('edit_task', [$todo, $task]);

        $validate_data = $request->validate([
            'name' => 'required|string|max:255|min:4',
            'description' => 'required|string|max:255|min:10',
            'priority' => 'required|int'
        ]);

        $task->fill($validate_data);
        $task->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Todo $todo
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Todo $todo, Task $task)
    {
        $this->authorize('edit_task', [$todo, $task]);

        $task->delete();

        return redirect()->back();
    }
}
