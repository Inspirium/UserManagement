<?php

namespace Inspirium\UserManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inspirium\UserManagement\Models\Role;

class RoleController extends Controller {

    public function showRoles() {
        $elements = Role::all();
        $columns = [
            'name' => 'Name',
            'description' => 'Description'
        ];
        $strings = [
            'title' => 'Roles',
            'add_new' => 'Add New Roles',
        ];
        $links = [
            'add_new' => url('user/role/edit'),
            'edit' => url('user/role/edit/'),
            'delete' => url('user/role/delete/')
        ];
        return view(config('app.template') . '::vue.table-search', compact( 'elements', 'columns', 'strings', 'links' ));
    }

    public function showRole($id = null) {
        $role = Role::firstOrNew(['id' => $id]);
        return view(config('app.template') . '::user.role.edit', ['role' => $role]);
    }

    public function submitRole(Request $request, $id = null) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        $role = Role::updateOrCreate(['id' => $id], [
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);
        return redirect('user/roles');
    }

    public function deleteRole($id) {
        Role::destroy($id);
        return redirect('user/roles');
    }
}
