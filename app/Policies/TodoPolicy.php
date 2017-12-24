<?php

namespace App\Policies;

use App\User;
use App\Todo;
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
	public function show( User $user, Todo $todo )
	{
		$todo_user = TodosUser::where([
			'user_id' => $user->id,
			'todo_id' => $todo->id
		])->firstOrFail();

		if( $todo_user ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Determine whether the user can create todos.
	 *
	 * @param  \App\User  $user
	 * @return mixed
	 */
	public function create( User $user ) {
		return true;
	}

	/**
	 * Determine whether the user can edit (update and delete) the todo.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Todo  $todo
	 * @return mixed
	 */
	public function edit( User $user, Todo $todo )
	{
		$todo_user = TodosUser::where([
			'user_id' => $user->id,
			'todo_id' => $todo->id
		])->first();

		if( $todo_user && ( $todo_user->authority_id == 1 ) ) {
			return true;
		} else {
			return false;
		}
	}
}
