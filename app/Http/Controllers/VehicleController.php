<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the vehicles.
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number_plate' => 'required|string|max:50|unique:vehicles',
            'model' => 'nullable|string|max:255',
            'make' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $vehicle = Vehicle::create($request->all());

        return response()->json([
            'message' => 'Vehicle created successfully',
            'vehicle' => $vehicle
        ], 201);
    }

    /**
     * Display the specified vehicle.
     */
    public function show($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        return response()->json($vehicle);
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'number_plate' => 'required|string|max:50|unique:vehicles,number_plate,' . $id,
            'model' => 'nullable|string|max:255',
            'make' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $vehicle->update($request->all());

        return response()->json([
            'message' => 'Vehicle updated successfully',
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        $vehicle->delete();

        return response()->json([
            'message' => 'Vehicle deleted successfully'
        ]);
    }
}
