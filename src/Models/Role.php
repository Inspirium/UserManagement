<?php

namespace Inspirium\UserManagement\Models;

class Role extends Eloquent {

    public $timestamps = false;

    public function users() {
        return $this->belongsToMany('Inspirium\UserManagement\Models\User', 'users_roles');
    }
}
