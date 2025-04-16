<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller {
    public function index(Request $request) {
        return inertia('dashboard/admin/roles/RoleIndex');
    }

    public function create(Request $request) {
        return inertia('dashboard/admin/roles/Create');
    }

    public function show(Request $request, $role) {
        return inertia('dashboard/admin/roles/Edit');
    }
}
