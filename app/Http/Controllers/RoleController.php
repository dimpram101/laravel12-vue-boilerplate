<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller {
    public function index(Request $request) {
        $roles = Role::all();
        return inertia('dashboard/admin/roles/RoleIndex', [
            'roles' => $roles
        ]);
    }

    public function create(Request $request) {
        $permissions = Permission::all();
        return inertia('dashboard/admin/roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
        ]);

        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function show(Request $request, $role) {
        return inertia('dashboard/admin/roles/Edit');
    }

    public function destroy(Request $request, Role $role) {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
    }
}
