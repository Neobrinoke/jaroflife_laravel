<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // RELATIONS
    public function todos() {
        return $this->hasMany( 'App\TodosUser' );
    }

    // SCOPES
    public function scopeFindAllWithoutMe( $query ) {
        return $query->where( 'id', '!=', Auth::id() )->get();
    }
}
