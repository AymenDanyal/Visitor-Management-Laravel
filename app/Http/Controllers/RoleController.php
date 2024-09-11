<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'existing_permissions' => 'array',
            'existing_permissions.*' => 'exists:permissions,id',
            'new_permissions' => 'array',
            'new_permissions.*' => 'string|max:255|unique:permissions,name',
        ]);

        if ($validator->fails()) {
            dd('erroe');
            return redirect()->route('roles.create')
                ->withErrors($validator)
                ->withInput();
        }
       
        // Create the role
        $role = Role::create([
            'name' => $request->name,
        ]);
        
        // Collect all permission IDs to attach
        $permissionIds = [];

        // Attach existing permissions
        if ($request->has('existing_permissions')) {
            $permissionIds = array_merge($permissionIds, $request->existing_permissions);
        }

        // Create and attach new permissions
        if ($request->has('new_permissions')) {
            foreach ($request->new_permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                if (!in_array($permission->id, $permissionIds)) {
                    $permissionIds[] = $permission->id;
                }
            }
        }

        // Attach permissions to the role
        $role->permissions()->sync($permissionIds);
        
        return redirect()->route('users.index')
            ->with('success', 'Role created successfully.');
    }


    public function create()
    {
        $roles = Role::all();

        $permissions = Permission::all();
        return view('pages.roles.create', compact('roles', 'permissions'));
    }
    public function edit($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('roles.index')
                ->with('error', 'Role not found');
        }

        // Retrieve permissions associated with the role
        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        
        // Retrieve all available permissions
        $permissions = Permission::all();

        return view('pages.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Display the specified role.
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        return response()->json($role);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id', // Validate each permission ID
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update role name
        $role->update([
            'name' => $request->input('name'),
        ]);

        // Sync the role's permissions
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->input('permissions'));
        }

        return redirect()->route('users.index')
            ->with('success', 'Role updated successfully.');
    }


    /**
     * Remove the specified role from storage.
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $role->delete();

        return response()->json([
            'message' => 'Permission deleted successfully'
        ]);
    }
}
