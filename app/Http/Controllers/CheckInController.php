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
        $validator = Validator::make($request->all(), [
            'visitor_id' => 'required|exists:visitors,id',
            'gatekeeper_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $checkIn = CheckIn::create([
            'visitor_id' => $request->visitor_id,
            'gatekeeper_id' => $request->gatekeeper_id,
        ]);
        event(new CheckInUpdated($checkIn));

        return response()->json([
            'message' => 'Visitor checked in successfully',
            'checkIn' => $checkIn
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
    public function update(Request $request, $id)
    {
        $checkIn = CheckIn::find($id);

        if (!$checkIn) {
            return response()->json(['error' => 'Check-in record not found'], 404);
        }

        $checkIn->update([
            'check_out_time' => now(),
        ]);

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
        $checkIn = CheckIn::find($id);

        if (!$checkIn) {
            return response()->json(['error' => 'Check-in record not found'], 404);
        }

        $checkIn->delete();

        return response()->json([
            'message' => 'Check-in record deleted successfully'
        ]);
    }

}
