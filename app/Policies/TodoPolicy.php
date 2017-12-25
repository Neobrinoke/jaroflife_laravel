<?php

namespace App\Policies;

use App\User;
use App\Todo;
use App\Task;
use App\TodosUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the todo.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @return mixed
	 */
	public function show_todo( User $user, Todo $todo )
	{
		$todo_user = TodosUser::findByTodoAndUser( $todo, $user );
		if( $todo_user ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Determine whether the user can edit (update and delete) the todo.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @return mixed
	 */
	public function edit_todo( User $user, Todo $todo )
	{
		$todo_user = TodosUser::findByTodoAndUser( $todo, $user );
		if( $todo_user && ( $todo_user->authority_id == 1 ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Determine if the user can create a task.
	 * 
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @return boolean
	 */
	public function create_task( User $user, Todo $todo )
	{
		$todo_user = TodosUser::findByTodoAndUser( $todo, $user );
		if( $todo_user ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Determine if the user can edit (update and delete) the task.
	 * User can update and delete if he's admin or if the task was created by him
	 *
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @param  \App\Task  $task
	 * @return boolean
	 */
	public function edit_task( User $user, Todo $todo, Task $task )
	{
		$todo_user = TodosUser::findByTodoAndUser( $todo, $user );
		if( $todo_user && $task->todo_id == $todo->id && ( $todo_user->authority_id == 1 || $task->author_id == $user->id ) ) {
			return true;
		} else {
			return false;
		}
	}
}
