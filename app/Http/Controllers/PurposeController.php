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
    public function index()
    {
        $purposes = Purpose::all();
        return response()->json($purposes);
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
            return response()->json($validator->errors(), 422);
        }

        $purpose = Purpose::create($request->all());

        return response()->json([
            'message' => 'Purpose created successfully',
            'purpose' => $purpose
        ], 201);
    }

    /**
     * Display the specified purpose.
     */
    public function show($id)
    {
        $purpose = Purpose::find($id);

        if (!$purpose) {
            return response()->json(['error' => 'Purpose not found'], 404);
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
            return response()->json(['error' => 'Purpose not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:purposes,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $purpose->update($request->all());

        return response()->json([
            'message' => 'Purpose updated successfully',
            'purpose' => $purpose
        ]);
    }

    /**
     * Remove the specified purpose from storage.
     */
    public function destroy($id)
    {
        $purpose = Purpose::find($id);

        if (!$purpose) {
            return response()->json(['error' => 'Purpose not found'], 404);
        }

        $purpose->delete();

        return response()->json([
            'message' => 'Purpose deleted successfully'
        ]);
    }
}
