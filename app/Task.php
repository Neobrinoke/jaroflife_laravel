<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @property int    id
 * @property string name
 * @property string description
 * @property int    priority
 * @property User   author_id
 * @property Todo   todo_id
 * @package App
 */
class Task extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description', 'priority', 'author_id', 'todo_id'];

	/**
	 * Return todo of the task
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function todo()
	{
		return $this->hasOne( 'App\Todo', 'id', 'todo_id' );
	}

	/**
	 * Return user author of the task
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user()
	{
		return $this->hasOne( 'App\User', 'id', 'author_id' );
	}

	/**
	 * Find task by todo
	 *
	 * @param Builder $query
	 * @param int     $todoId
	 * @param int     $taskId
	 * @return Model|static
	 */
	public function scopeFindByTodo( Builder $query, int $todoId, int $taskId )
	{
		return $query->where( ['todo_id' => $todoId, 'id' => $taskId] )->firstOrFail();
	}
}
