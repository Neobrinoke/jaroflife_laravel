<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodosUser extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'user_id',
		'todo_id',
		'authority_id'
	];

	// RELATIONS
	public function todo() {
		return $this->hasOne( 'App\Todo', 'id', 'todo_id' );
	}

	public function user() {
		return $this->hasOne( 'App\User', 'id', 'user_id' );
	}

	// SCOPES
	public function scopeFindByTodoAndUser( $query, $todoId, $userId ) {
		return $query->where([
			'user_id' => $userId,
			'todo_id' => $todoId
		])->firstOrFail();
	}
}
