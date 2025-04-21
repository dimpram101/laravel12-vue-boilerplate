<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request) {
        $permissions = Permission::all();

        return inertia('dashboard/admin/permissions/PermissionIndex', [
            'permissions' => $permissions
        ]);
    }

    public function create(Request $request) {
        return inertia('dashboard/admin/permissions/Create');
    }

    public function show(Request $request, Permission $permission) {
        return inertia('dashboard/admin/permissions/Edit', [
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, Permission $permission) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $permission->id],
        ], [
            'name.required' => 'The permission name is required.',
            'name.unique' => 'This permission has already been used.',
        ]);
    
        $permission->update([
            'name' => $validated['name'],
        ]);
    
        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ], [
            'name.required' => 'The permission name is required.',
            'name.unique' => 'The permission has already been used.',
        ]);
    
        Permission::create([
            'name' => $validated['name'],
        ]);
    
        return to_route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function destroy(Request $request, Permission $permission) {
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully');
    }
}
