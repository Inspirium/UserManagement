<?php

namespace Inspirium\UserManagement\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Inspirium\UserManagement\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Inspirium\HumanResources\Models\Employee $employee
 * @property-read mixed $image
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Inspirium\UserManagement\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\Inspirium\UserManagement\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Inspirium\UserManagement\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Inspirium\UserManagement\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Inspirium\UserManagement\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Inspirium\UserManagement\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Inspirium\UserManagement\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Inspirium\UserManagement\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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
