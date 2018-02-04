<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Todo
 *
 * @property int id
 * @property string name
 * @property string description
 * @property User author_id
 * @package App
 */
class Todo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'author_id'
    ];

    /**
     * Return members list of the todo without connected user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany('App\TodosUser', 'todo_id', 'id')->where('user_id', '!=', Auth::id());
    }

    /**
     * Return tasks list of the todo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Task', 'todo_id', 'id');
    }

    /**
     * Return user author of the todo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }
}
