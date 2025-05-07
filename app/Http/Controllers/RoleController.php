<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\Admin\CreateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller {
    public function index(Request $request) {
        $roles = Role::with('permissions')->get();
        $user = $request->user();
        return inertia('dashboard/admin/roles/RoleIndex', [
            'roles' => $roles,
            'can' => [
                'create' => $user->can('create role'),
                'edit' => $user->can('update role'),
                'delete' => $user->can('delete role'),
            ],
        ]);
    }

    public function create(Request $request) {
        $permissions = Permission::all();
        return inertia('dashboard/admin/roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    public function show(Request $request, Role $role) {
        $user = $request->user();

        if ($role->name == RoleEnum::SUPER_ADMIN->value && !$user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return redirect()->route('admin.roles.index')->with('error', 'You cannot edit the super admin role.');
        }

        return inertia('dashboard/admin/roles/Edit', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name'),
            ],
            'permissions' => Permission::all(),
        ]);
    }

    public function update(Request $request, Role $role) {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => ['array'],
            'permissions.*' => ['string'],
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function store(CreateRoleRequest $request) {
        $validated = $request->validated();

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }
    

    public function destroy(Request $request, Role $role) {
        if ($role->name == RoleEnum::SUPER_ADMIN->value) {
            return redirect()->route('admin.roles.index')->with('error', 'You cannot delete the super admin role.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')->with('error', 'Cannot delete role: it is currently assigned to one or more users.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
