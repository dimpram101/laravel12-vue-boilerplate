<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request) {
        return inertia('dashboard/admin/permissions/PermissionIndex');
    }

    public function create(Request $request)
    {
        $permissions = [
            'View Dashboard',
            'Edit Product',
            'Delete Product',
            'Add Product'
        ];

        try {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
            return response()->json(['message' => 'Permissions added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add permissions.'], 500);
        }
    }
}
