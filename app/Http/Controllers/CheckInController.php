<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckIn;
use App\Models\Visitor;
use App\Models\User;
use App\Events\CheckInUpdated;
use Illuminate\Support\Facades\Validator;

class CheckInController extends Controller
{
    /**
     * Display a listing of all check-ins.
     */
    public function index()
    {
        $checkIns = CheckIn::with(['visitor', 'gatekeeper'])->get();
        return response()->json($checkIns);
    }

    /**
     * Store a newly created check-in in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'visitor_id' => 'required|exists:visitors,id',
            'gatekeeper_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create CheckIn record
        $checkIn = CheckIn::create([
            'visitor_id' => $request->visitor_id,
            'gatekeeper_id' => $request->gatekeeper_id,
        ]);

        // Get the visitor details
        $visitor = Visitor::find($request->visitor_id);

        // Prepare broadcast data
        $broadcastData = [
            'visitor' => $visitor,
            'gatekeeper_id' => $request->gatekeeper_id,
            'check_in_time' => $checkIn->created_at,
        ];

        // Broadcast the check-in event
        event(new CheckInUpdated($broadcastData, 'Check-in'));

        return response()->json([
            'message' => 'Visitor checked in successfully',
            'checkIn' => $checkIn,
        ], 201);
    }


    /**
     * Display the specified check-in record.
     */
    public function show($id)
    {


        $checkIn = CheckIn::with(['visitor', 'gatekeeper'])->find($id);
        if (!$checkIn) {
            return response()->json(['error' => 'Check-in record not found'], 404);
        }



        return response()->json($checkIn);
    }


    /**
     * Update the check-out time for a specific check-in record.
     */
    public function update(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:check_ins,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the CheckIn record
        $checkIn = CheckIn::find($request->id);

        if (!$checkIn) {
            return response()->json(['error' => 'Check-in record not found'], 404);
        }

        // Update the check-out time
        $checkIn->update([
            'check_out_time' => now(),
        ]);

        // Get the associated visitor details
        $visitor = Visitor::find($checkIn->visitor_id);

        // Prepare broadcast data
        $broadcastData = [
            'checkIn' => $checkIn,
            'visitor' => $visitor,
        ];

        // Broadcast the check-in update event
        event(new CheckInUpdated($broadcastData,'Check-out'));

        return response()->json([
            'message' => 'Visitor checked out successfully',
            'checkIn' => $checkIn
        ]);
    }

    /** 
     * Remove the specified check-in record from storage.
     */
    public function destroy($id)
    {
        // Validate request
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:check_ins,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the CheckIn record
        $checkIn = CheckIn::find($id);

        if (!$checkIn) {
            return response()->json(['error' => 'Check-in record not found'], 404);
        }

        // Get the associated visitor details
        $visitor = Visitor::find($checkIn->visitor_id);

        // Delete the CheckIn record
        $checkIn->delete();

        // Prepare broadcast data
        $broadcastData = [
            'checkIn' => $checkIn,
            'visitor' => $visitor,
        ];

        // Broadcast the check-in deletion event
        event(new CheckInUpdated($broadcastData,'Delete'));

        return response()->json([
            'message' => 'Check-in record deleted successfully'
        ]);
    }
}
