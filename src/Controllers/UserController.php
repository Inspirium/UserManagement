<?php

namespace Inspirium\UserManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inspirium\UserManagement\Models\User;

class UserController extends Controller {

    public function showUsers() {
        $users = User::all();
        return view(config('app.template') . '::user.list', ['users' => $users]);
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
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect('user/show/' . $user->id);
    }

    public function deleteUser($id) {
        User::destroy($id);
        return redirect('users');
    }
}
