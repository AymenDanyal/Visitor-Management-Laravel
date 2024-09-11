<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purpose;
use Illuminate\Support\Facades\Validator;

class PurposeController extends Controller
{
    /**
     * Display a listing of the purposes.
     */
    public function index(Request $request)
    {
        $purposes = Purpose::all();
        if ($request->is('api/*')) {
            return response()->json($purposes);
        } else {

            return view('pages.purposes.index', compact('purposes'));
        }
    }
    public function create()
    {
        return view('pages.purposes.create');
    }

    public function edit($id)
    {
        // Find the visitor by ID.
        $purposes = Purpose::find($id);

        // Check if the visitor exists.
        if (!$purposes) {
            // Redirect to a 404 page or show an error if the visitor does not exist.
            return redirect()->route('purposes.index')->with('error', 'Purposes not found.');
        }

        // Return the view with the visitor data.
        return view('pages.purposes.edit', compact('purposes'));

    }
    /**
     * Store a newly created purpose in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:purposes',
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

        $purpose = Purpose::create($request->all());

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Department created successfully',
                'purpose' => $purpose
            ], 201);
        }

        // For web request, redirect back with a success message
        return redirect()->route('purposes.index')
            ->with('success', 'Purpose added successfully');
    }

    /**
     * Display the specified purpose.
     */
    public function show($id,Request $request)
    {
        $purpose = Purpose::find($id);

        if (!$purpose) {
            return $request->is('api/*')
                ? response()->json(['error' => 'Department not found'], 404)
                : redirect()->route('departments.index')->with('error', 'Department not found.');
        }
        

        return response()->json($purpose);

    }

    /**
     * Update the specified purpose in storage.
     */
    public function update(Request $request, $id)
    {
        $purpose = Purpose::find($id);

        if (!$purpose) {
            return $request->is('api/*')
                ? response()->json(['error' => 'Department not found'], 404)
                : redirect()->route('purposes.index')->with('error', 'Purpose not found.');
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:purposes,name,' . $id,
        ]);

        if ($validator->fails()) {
            return $request->is('api/*')
                ? response()->json($validator->errors(), 422)
                : redirect()->back()->withErrors($validator)->withInput();
        }

        $purpose->update($request->all());

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Purpose updated successfully',
                'purpose' => $purpose
            ]);
        } else {
            return redirect()->route('purposes.index')
                ->with('success', 'Purpose updated successfully');
        }
    }

    /**
     * Remove the specified purpose from storage.
     */
    public function destroy($id,Request $request)
    {
        $purpose = Purpose::find($id);

        if (!$purpose) {
            return $request->is('api/*')
                ? response()->json(['error' => 'Purpose not found'], 404)
                : redirect()->route('purposes.index')->with('error', 'Department not found.');
        }
        
        $purpose->delete();
        
        return $request->is('api/*')
            ? response()->json(['message' => 'Purpose deleted successfully'])
            : redirect()->route('purposes.index')->with('success', 'Department deleted successfully');
        
    }
}
