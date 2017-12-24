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
     * Determine whether the user can view the task.
     *
     * @param  \App\User  $user
     * @param  \App\Todo  $todo
     * @param  \App\Task  $task
     * @return mixed
     */
    public function show( User $user, Todo $todo, Task $task )
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
     * Determine whether the user can create tasks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create( User $user ) {
        return true;
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function edit( User $user, Task $task ) {
        return true;
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function delete( User $user, Task $task ) {
        return true;
    }
}
