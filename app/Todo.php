<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
	protected $fillable = [
		'name', 'description', 'author_id'
	];

	public function todos_users() {
		return $this->hasMany('App\TodosUser', 'todo_id', 'id');
	}

	public function tasks() {
		return $this->hasMany('App\Task', 'todo_id', 'id');
	}
	
	public function user() {
		return $this->hasOne('App\User', 'id', 'author_id');
	}
}
