<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the permissions.
     */
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        // Validate that 'name' is an array and each permission name is unique
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !is_array($value)) {
                        $fail('The ' . $attribute . ' must be a string or an array of strings.');
                    }
                }
            ],
            'name.*' => 'sometimes|required|string|max:255|unique:permissions,name',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('permissions.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Handle if the name is a string (single permission)
        if (is_string($request->name)) {
            Permission::create(['name' => $request->name]);
        } elseif (is_array($request->name)) {
            // Handle if the name is an array (multiple permissions)
            foreach ($request->name as $permissionName) {
                Permission::create(['name' => $permissionName]);
            }
        }
        
        return redirect()->route('users.index')
            ->with('success', 'Permission(s) created successfully.');

    }
            /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        return view('pages.permissions.create');
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('pages.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('permissions.edit', $permission->id)
                ->withErrors($validator)
                ->withInput();
        }

        // Update the permission's name
        $permission->update(['name' => $request->name]);

        return redirect()->route('users.index')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully'
        ]);
    }
}
