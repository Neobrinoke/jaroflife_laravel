<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Return todos list of user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todos()
    {
        return $this->hasMany('App\TodosUser');
    }

    /**
     * Find all user without current logged user
     *
     * @param Builder $query
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function scopeFindAllWithoutMe(Builder $query)
    {
        return $query->where('id', '!=', Auth::id())->get();
    }
}
