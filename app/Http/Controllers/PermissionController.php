<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
 

    /**
     * Display a list of roles with their permissions.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('permission.index', compact('roles'));
    }

    /**
     * Show the form to create a new role.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[1]; // Group by section (e.g., welcome-call, leads)
        });

        // dd($permissions->toArray());
        return view('permission.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.permissions.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form to edit a role and its permissions.
     */
    public function edit($id)
    {
        if($id == 1){
           return redirect()->route('admin.permissions.index')->with('error', 'Super admin can not be update');  
        }
        $role = Role::findOrFail($id);
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->name)[1]; // Group by section
        });
        return view('permission.edit', compact('role', 'permissions'));
    }

    /**
     * Update a role's name and permissions.
     */
    public function update(Request $request, $id)
    {
         if($id == 1){
           return redirect()->route('admin.permissions.index')->with('error', 'Super admin can not be update');  
        }
        
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $id . '|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.permissions.index')->with('success', 'Role updated successfully.');
    }
}