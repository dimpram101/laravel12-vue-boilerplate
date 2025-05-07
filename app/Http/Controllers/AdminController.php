<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller {
    //

    public function index(Request $request) {
        $users = User::with(['roles'])->get();
        // dd($users);
        return inertia('dashboard/admin/users/UserIndex', [
            'users' => $users,
        ]);
    }

    public function createUser(Request $request) {
        $roles = Role::all();
        return inertia('dashboard/admin/users/UserCreate', [
            'roles' => $roles,
        ]);
    }

    public function storeUser(CreateUserRequest $request) {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole($data['role']);

        return to_route('admin.users')->with('success', 'User created successfully');
    }

    public function editUser(Request $request, User $user) {
        $roles = Role::all();
        $permissions = Permission::all();
        $user = User::with(['roles', 'permissions'])->find($user->id);
        return inertia('dashboard/admin/users/UserEdit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function updateUser(UpdateUserRequest $request, User $user) {
        $data = $request->validated();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] ? bcrypt($data['password']) : $user->password,
        ]);

        $user->syncRoles($data['role']);
        $user->syncPermissions($data['permissions'] ?? []);

        return to_route('admin.users')->with('success', 'User updated successfully');
    }

    public function deleteUser(Request $request, User $user) {
        $auth = $request->user();

        if ($user->hasAnyRole(['super-admin']) && !$auth->hasRole('super-admin')) {
            return to_route('admin.users')->with('error', 'You are not authorized to delete this user');
        }

        $user->delete();

        return to_route('admin.users')->with('success', 'User deleted successfully');
    }
}
