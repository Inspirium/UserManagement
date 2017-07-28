<?php

namespace Inspirium\UserManagement\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Phoenix\EloquentMeta\MetaTrait;

/**
 * Class User
 * @package Inspirium\UserManagement\Models
 *
 * @property $id
 * @property $name
 * @property $email
 * @property $password
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 */
class User extends Authenticatable
{
    use Notifiable, MetaTrait, HasApiTokens;

    protected $meta_model = 'Inspirium\UserManagement\Models\UserModelMeta';

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

    protected $appends = ['image'];

    protected $guarded = [];

    public function roles() {
        return $this->belongsToMany('Inspirium\UserManagement\Models\Role', 'users_roles');
    }

    public function hasRole($check) {
        return in_array($check, array_pluck($this->roles->toArray(), 'name'));
    }

    public function getImageAttribute() {
    	return 'https://www.gravatar.com/avatar/' . md5( $this->email ) . '?s=50&d=wavatar';
    }

    public function employee() {
    	return $this->hasOne('Inspirium\HumanResources\Models\Employee');
    }
}
