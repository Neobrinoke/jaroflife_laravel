<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TodosUser
 *
 * @property int id
 * @property User user_id
 * @property Todo todo_id
 * @property int authority_id
 * @package App
 */
class TodosUser extends Model
{
    /**
     * Defined if this object use timestamps values
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'todo_id',
        'authority_id'
    ];

    /**
     * Return todo of the TodosUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function todo()
    {
        return $this->hasOne('App\Todo', 'id', 'todo_id');
    }

    /**
     * Return user of the TodosUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Find TodosUser by Todo and User
     *
     * @param Builder $query
     * @param int $todoId
     * @param int $userId
     * @return Model|static
     */
    public function scopeFindByTodoAndUser(Builder $query, int $todoId, int $userId)
    {
        return $query->where([
            'user_id' => $userId,
            'todo_id' => $todoId
        ])->firstOrFail();
    }
}
