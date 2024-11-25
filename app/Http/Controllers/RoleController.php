<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::all();
            $roles = Role::with('permissions')->get();
            return response()->json(['roles'=>$roles, 'permissions'=>$permissions], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array|exists:permissions,id', // Validate permission IDs
        ]);

        $role->syncPermissions($request->permissions); // Sync permissions
        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all(); // Fetch all permissions
        $rolePermissions = $role->permissions->pluck('id')->toArray(); // Get current permissions for the role

        return view('roles.assign-permissions', compact('role', 'permissions', 'rolePermissions'));
    }
}
