<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     */
    public function index(Request $request)
    {

        $departments = Department::get();

        if ($request->is('api/*')) {
            return response()->json($departments);
        } else {

            return view('pages.departments.index', compact('departments'));
        }
    }
    public function create()
    {
        $departments = Department::all();
        return view('pages.departments.create', compact('departments'));
    }

    public function edit($id)
    {
        // Find the visitor by ID.
        $department = Department::find($id);

        // Check if the visitor exists.
        if (!$department) {
            // Redirect to a 404 page or show an error if the visitor does not exist.
            return redirect()->route('departments.index')->with('error', 'Departments not found.');
        }

        // Return the view with the visitor data.
        return view('pages.departments.edit', compact('department'));

    }
    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments',
        ]);

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

        $department = Department::create($request->all());

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Department created successfully',
                'department' => $department
            ], 201);
        }

        // For web request, redirect back with a success message
        return redirect()->route('departments.index')
            ->with('success', 'Department added successfully');
    }

    /**
     * Display the specified department.
     */
    public function show($id,Request $request)
    {
        $department = Department::find($id);

        if (!$department) {
            return $request->is('api/*')
                ? response()->json(['error' => 'Department not found'], 404)
                : redirect()->route('departments.index')->with('error', 'Department not found.');
        }
        

        return response()->json($department);
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return $request->is('api/*')
                ? response()->json(['error' => 'Department not found'], 404)
                : redirect()->route('departments.index')->with('error', 'Department not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
        ]);

        if ($validator->fails()) {
            return $request->is('api/*')
                ? response()->json($validator->errors(), 422)
                : redirect()->back()->withErrors($validator)->withInput();
        }

        $department->update($request->all());

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Department updated successfully',
                'department' => $department
            ]);
        } else {
            return redirect()->route('departments.index')
                ->with('success', 'department updated successfully');
        }
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy($id,Request $request)
    {
        $department = Department::find($id);

        if (!$department) {
            return $request->is('api/*')
                ? response()->json(['error' => 'Department not found'], 404)
                : redirect()->route('departments.index')->with('error', 'Department not found.');
        }
        
        $department->delete();
        
        return $request->is('api/*')
            ? response()->json(['message' => 'Department deleted successfully'])
            : redirect()->route('departments.index')->with('success', 'Department deleted successfully');
        
    }
}
