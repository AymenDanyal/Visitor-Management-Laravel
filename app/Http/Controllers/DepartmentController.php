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
    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
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
            return response()->json($validator->errors(), 422);
        }

        $department = Department::create($request->all());

        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department
        ], 201);
    }

    /**
     * Display the specified department.
     */
    public function show($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
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
            return response()->json(['error' => 'Department not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $department->update($request->all());

        return response()->json([
            'message' => 'Department updated successfully',
            'department' => $department
        ]);
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully'
        ]);
    }
}
