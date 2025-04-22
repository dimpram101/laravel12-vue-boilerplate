<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
        $user = User::with(['roles'])->find($user->id);
        return inertia('dashboard/admin/users/UserEdit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function updateUser(Request $request, User $user) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] ? bcrypt($data['password']) : $user->password,
        ]);

        $user->syncRoles($data['role']);

        return to_route('admin.users')->with('success', 'User updated successfully');
    }

    public function deleteUser(Request $request, User $user) {
        $user->delete();
        return to_route('admin.users')->with('success', 'User deleted successfully');
    }
}
