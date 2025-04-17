<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function storeUser(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->roles);

        return to_route('admin.users')->with('success', 'User created successfully');
    }
}
