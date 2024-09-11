<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
{
    // Fetch all users with their roles and permissions
    $users = User::with('roles.permissions')->get();

    if ($request->is('api/*')) {
        // Prepare the data structure for API response
        $users = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->map(function($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name,
                        'permissions' => $role->permissions->map(function($permission) {
                            return [
                                'id' => $permission->id,
                                'name' => $permission->name,
                            ];
                        }),
                    ];
                }),
            ];
        });

        return response()->json($users);
    } else {
        // For non-API requests
        $roles = Role::all();
        $permissions = Permission::all();

        return view('pages.users.index', compact('users', 'roles', 'permissions'));
    }
}

    public function create()
    {
        $user = User::all();
        $roles = Role::all()->pluck('name');
        return view('pages.users.create', compact('user', 'roles'));
    }
    public function edit($id)
    {
        // Find the visitor by ID.
        $user = User::find($id);
        $roles = Role::all()->pluck('name');

        // Check if the visitor exists.
        if (!$user) {
            // Redirect to a 404 page or show an error if the visitor does not exist.
            return redirect()->route('visitors.index')->with('error', 'Visitor not found.');
        }

        // Return the view with the visitor data.
        return view('pages.users.edit', compact('user', 'roles'));
    }
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required_without:phone|email|unique:users,email',
            'phone' => 'required_without:email|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6',
            'role' => 'required|string|max:255|exists:roles,name',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // If it's an API request, return JSON error response
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // For web request, return with validation errors to be displayed in Blade
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Assign the role to the user
        $user->assignRole($request->role);

        // If it's an API request, return success response in JSON format
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user
            ], 201);
        }

        // For web request, redirect back with a success message
        return redirect()->route('users.index')
            ->with('success', 'User added successfully');
    }
    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }
    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $request->is('api/*')
                ? response()->json(['error' => 'User not found'], 404)
                : redirect()->route('users.index')->with('error', 'User not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $id,
            'phone' => 'string|max:20|unique:users,phone,' . $id,
            'password' => 'string|min:6|nullable',
            'role' => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return $request->is('api/*')
                ? response()->json($validator->errors(), 422)
                : redirect()->back()->withErrors($validator)->withInput();
        }

        // Update user fields
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->phone = $request->phone ?? $user->phone;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sync the role using Spatie roles package
        $user->syncRoles([$request->role]);

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ]);
        } else {
            return redirect()->route('users.index')
                ->with('success', 'User updated successfully');
        }
    }
    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
