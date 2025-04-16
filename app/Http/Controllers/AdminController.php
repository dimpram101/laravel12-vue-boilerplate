<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function index(Request $request) {
        $users = User::factory()->count(20)->make();

        return inertia('dashboard/admin/Users', [
            'users' => $users,
        ]);
    }
}
