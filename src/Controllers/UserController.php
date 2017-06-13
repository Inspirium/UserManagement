<?php

namespace Inspirium\UserManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inspirium\UserManagement\Models\Role;
use Inspirium\UserManagement\Models\User;

class UserController extends Controller {

    public function showUsers() {
        $elements = User::all();
        $columns = [
            'name' => [ 'title' => 'Name' ],
            'email' => [ 'title' => 'Email' ]
        ];
        $strings = [
            "title" => "Users",
            "add_new" => "Add New User",
        ];
        $links = [
            'add_new' => url('administration/user/edit'),
            'edit' => url('administration/user/edit/'),
            'delete' => url('administration/user/delete/')
        ];
        return view(config('app.template') . '::vue.table-search', compact( 'elements', 'columns', 'strings', 'links' ));
    }

    public function showUser($id) {
        $user = User::find($id);
        return view(config('app.template') . '::user.show', ['user' => $user]);
    }

    public function showEditForm($id = null) {
        if ($id) {
            $user = User::find($id);
        }
        else {
            $user = new User();
        }
        return view(config('app.template').'::user.edit', ['user' => $user]);
    }

    public function submitUser(Request $request, $id = null) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ($id?'':'required|').'min:6|confirmed',
        ]);
        if ($id) {
            $user = User::find($id);
            if (!$user) {
                //TODO:throw error
            }
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->has('password')) {
                $user->password = bcrypt( $request->input( 'password' ) );
            }
            $user->save();
        }
        else {
            $user = User::create( [
                'name'     => $request->input( 'name' ),
                'email'    => $request->input( 'email' ),
                'password' => bcrypt( $request->input( 'password' ) ),
            ] );
        }

        return redirect('administration/user/show/' . $user->id);
    }

    public function deleteUser($id) {
        User::destroy($id);
        return redirect('administration/users');
    }

    public function showUserRoles($id) {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view(config('app.template') . '::user.role.user_roles', ['user' => $user, 'roles' => $roles]);
    }

    public function updateUserRoles(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->roles()->sync($request->input('roles'));
        $user->save();
        return redirect('administration/user/show/'.$user->id);
    }
}
