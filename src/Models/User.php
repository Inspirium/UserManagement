<?php

namespace Inspirium\UserManagement\Models;

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
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany('Inspirium\UserManagement\Models\Role', 'users_roles');
    }

    public function hasRole($check) {
        return in_array($check, array_pluck($this->roles->toArray(), 'name'));
    }
}
