<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function index(Request $request) {
        $users = User::with(['roles'])->get();
        // dd($users);
        return inertia('dashboard/admin/Users', [
            'users' => $users,
        ]);
    }
}
