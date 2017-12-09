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

	public function todo() {
		return $this->hasOne('App\Todo', 'id', 'todo_id');
	}

	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}
}
