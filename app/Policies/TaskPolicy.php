<?php

namespace App\Policies;

use App\User;
use App\Task;
use App\Todo;
use App\TodosUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine if the user are in the todo group.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @return boolean
	 */
	public function create( User $user, Todo $todo )
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
	public function edit( User $user, Todo $todo, Task $task )
	{
		$todo_user = TodosUser::findByTodoAndUser( $todo, $user );
		if( $todo_user && $task->todo_id == $todo->id && $task->author_id == $user->id ) {
			return true;
		} else {
			return false;
		}
	}
}
