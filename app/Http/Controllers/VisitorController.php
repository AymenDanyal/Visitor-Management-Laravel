<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Validator;
use App\Events\CheckInUpdated;


class VisitorController extends Controller
{
    /**
     * Display a listing of the visitors.
     */
    public function index()
    {
        $visitors = Visitor::all();
        return response()->json($visitors);
    }

    /**
     * Store a newly created visitor in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'group' => 'required|boolean',
            'name' => 'required_if:group,false|string|max:255',
            'phone' => 'required_if:group,false|string|max:20',
            'cnic_front_image' => 'required_if:group,false|string|max:255',
            'cnic_back_image' => 'required_if:group,false|string|max:255',
            'user_image' => 'required_if:group,false|string|max:255',
            'name.*' => 'required_if:group,true|string|max:255',
            'phone.*' => 'required_if:group,true|string|max:20',
            'cnic_front_image.*' => 'required_if:group,true|string|max:255',
            'cnic_back_image.*' => 'required_if:group,true|string|max:255',
            'user_image.*' => 'required_if:group,true|string|max:255',

            'gatekeeper_id' => 'required|string|max:255',
            'purpose_of_visit' => 'required|in:interview,meeting,delivery,other',
            'department' => 'required|string|max:255',
            'department_person_name' => 'required|string|max:255',
            'organization_name' => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:50',
            'comments' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $visitors = [];

        if ($request->group) {
            // Handle multiple visitors
            $names = $request->input('name');
            $phones = $request->input('phone');
            $cnicFrontImages = $request->input('cnic_front_image');
            $cnicBackImages = $request->input('cnic_back_image');
            $userImages = $request->input('user_image');

            foreach ($names as $index => $name) {
                $visitor = Visitor::create([
                    'name' => $name,
                    'phone' => $phones[$index],
                    'cnic_front_image' => $cnicFrontImages[$index],
                    'cnic_back_image' => $cnicBackImages[$index],
                    'user_image' => $userImages[$index],
                    'purpose_of_visit' => $request->input('purpose_of_visit'),
                    'department' => $request->input('department'),
                    'department_person_name' => $request->input('department_person_name'),
                    'organization_name' => $request->input('organization_name'),
                    'vehicle_number' => $request->input('vehicle_number'),
                    'comments' => $request->input('comments'),
                ]);

                $visitors[] = $visitor;

                CheckIn::create([
                    'visitor_id' => $visitor->id, // Use the visitor's ID from the created visitor
                    'gatekeeper_id' => $request->input('gatekeeper_id'),
                ]);
            }
        } else {
            // Handle single visitor
            $visitor = Visitor::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'cnic_front_image' => $request->input('cnic_front_image'),
                'cnic_back_image' => $request->input('cnic_back_image'),
                'user_image' => $request->input('user_image'),
                'purpose_of_visit' => $request->input('purpose_of_visit'),
                'department' => $request->input('department'),
                'department_person_name' => $request->input('department_person_name'),
                'organization_name' => $request->input('organization_name'),
                'vehicle_number' => $request->input('vehicle_number'),
                'comments' => $request->input('comments'),
            ]);

            $visitors[] = $visitor;

            CheckIn::create([
                'visitor_id' => $visitor->id, // Use the visitor's ID from the created visitor
                'gatekeeper_id' => $request->input('gatekeeper_id'),
            ]);
        }

        return response()->json([
            'message' => 'Visitor(s) created successfully',
            'visitors' => $visitors,
        ], 201);
    }



    /**
     * Display the specified visitor.
     */
    public function show($id)
    {
        $visitor = Visitor::find($id);
        
        if (!$visitor) {
            return response()->json(['error' => 'Visitor not found'], 404);
        }

        return response()->json($visitor);
    }

    /**
     * Update the specified visitor in storage.
     */
    public function update(Request $request, $id)
    {
        $visitor = Visitor::find($id);
        
        if (!$visitor) {
            return response()->json(['error' => 'Visitor not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'phone' => 'string|max:20',
            'cnic_front_image' => 'string|max:255',
            'cnic_back_image' => 'string|max:255',
            'user_image' => 'string|max:255',
            'purpose_of_visit' => 'in:interview,meeting,delivery,other',
            'department' => 'string|max:255',
            'department_person_name' => 'string|max:255',
            'organization_name' => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:50',
            'comments' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $visitor->update($request->all());

        return response()->json([
            'message' => 'Visitor updated successfully',
            'visitor' => $visitor
        ]);
    }

    /**
     * Remove the specified visitor from storage.
     */
    public function destroy($id)
    {
        $visitor = Visitor::find($id);
        event(new CheckInUpdated($visitor));

        if (!$visitor) {
            return response()->json(['error' => 'Visitor not found'], 404);
        }

        $visitor->delete();

        return response()->json([
            'message' => 'Visitor deleted successfully'
        ]);
    }

    /**
     * Check-in a visitor.
     */
    public function checkIn(Request $request)
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
            'check_in_time' => now(),
        ]);
        event(new CheckInUpdated($checkIn));
        return response()->json([
            'message' => 'Visitor checked in successfully',
            'check_in' => $checkIn
        ], 201);
    }

    /**
     * Check-out a visitor.
     */
    public function checkOut($id)
    {
        $checkIn = CheckIn::find($id);

        if (!$checkIn) {
            return response()->json(['error' => 'Check-in record not found'], 404);
        }

        if ($checkIn->check_out_time) {
            return response()->json(['error' => 'Visitor already checked out'], 422);
        }

        $checkIn->update([
            'check_out_time' => now(),
        ]);
        
        event(new CheckInUpdated($checkIn));
        return response()->json([
            'message' => 'Visitor checked out successfully',
            'check_in' => $checkIn
        ]);
    }
}
