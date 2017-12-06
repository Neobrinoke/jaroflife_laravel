<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = [
		'name',
		'description',
		'priority',
		'author_id',
		'todo_id'
	];

	public function todo() {
		return $this->hasOne('App\Todo', 'id', 'todo_id');
	}
	
	public function user() {
		return $this->hasOne('App\User', 'id', 'author_id');
	}
}
