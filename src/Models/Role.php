<?php

namespace Inspirium\UserManagement\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package Inspirium\UserManagement\Models
 *
 * @property $id;
 * @property $name;
 * @property $description
 */
class Role extends Model {

    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    public function users() {
        return $this->belongsToMany('Inspirium\UserManagement\Models\User', 'users_roles');
    }
}
