<?php

namespace Inspirium\UserManagement\Models;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller {

    public function showRoles() {
        $roles = Role::all();
        return view(config('app.template') . '::user.role.list', ['roles' => $roles]);
    }

    public function showRole($id = null) {
        if ($id) {
            $role = Role::findOrFail( $id );
        }
        else {
            $role = new Role();
        }
        return view(config('app.template') . '::user.role.edit', ['role', $role]);
    }

    public function submitRole(Request $request, $id = null) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if ($id) {
            /** @var Role $role */
            $role = Role::findOrFail( $id );
            $role->name = $request->input('name');
            $role->description = $request->input('description');
            $role->save();
        }
        else {
            $role = Role::create([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);
        }
        return redirect('user/roles', ['role' => $role]);
    }

    public function deleteRole($id) {
        Role::destroy($id);
        return redirect('user/roles');
    }
}
