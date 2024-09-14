<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Validator;
use App\Events\CheckInUpdated;
use App\Models\Purpose;
use Exception;

class VisitorController extends Controller
{
    /**
     * Display a listing of the visitors.
     */
    public function index(Request $request)
    {
        try {
            $visitors = Visitor::with('checkIns')->get();
            if ($request->is('api/*')) {
                return response()->json($visitors);
            } else {
                return view('pages.visitors.index', compact('visitors'));
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        try {
            $purposes = Purpose::get();
            return view('pages.visitors.create', compact('purposes'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $visitor = Visitor::find($id);
            $purposes = Purpose::get();

            if (!$visitor) {
                return redirect()->route('visitors.index')->with('error', 'Visitor not found.');
            }

            return view('pages.visitors.edit', compact('visitor', 'purposes'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created visitor in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required_if:group,false|max:255',
                'phone' => 'required_if:group,false|max:20',
                'cnic_front_image' => 'required_if:group,false|image|max:5000',
                'cnic_back_image' => 'required_if:group,false|image|max:5000',
                'user_image' => 'required_if:group,false|image|max:5000',
                'purpose_of_visit' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'department_person_name' => 'required|string|max:255',
                'organization_name' => 'nullable|string|max:255',
                'vehicle_number' => 'nullable|string|max:50',
                'comments' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $cnicFrontImagePath = $request->file('cnic_front_image')->store('uploads', 'public');
            $cnicBackImagePath = $request->file('cnic_back_image')->store('uploads', 'public');
            $userImagePath = $request->file('user_image')->store('uploads', 'public');

            $visitor = Visitor::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'cnic_front_image' => $cnicFrontImagePath,
                'cnic_back_image' => $cnicBackImagePath,
                'user_image' => $userImagePath,
                'purpose_of_visit' => $request->input('purpose_of_visit'),
                'department' => $request->input('department'),
                'department_person_name' => $request->input('department_person_name'),
                'organization_name' => $request->input('organization_name'),
                'vehicle_number' => $request->input('vehicle_number'),
                'comments' => $request->input('comments'),
            ]);

            event(new CheckInUpdated($visitor, 'Visitor added'));

            return redirect()->route('visitors.index')
                ->with('success', 'Visitor added successfully');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeCheckin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'group' => 'required|boolean',
                'name' => 'required_if:group,0|max:255',
                'phone' => 'required_if:group,0|max:255',
                'cnic_front_image' => 'required_if:group,0|max:5000',
                'cnic_back_image' => 'required_if:group,0|max:5000',
                'user_image' => 'required_if:group,0|max:5000',

                'name.*' => 'required_if:group,true|max:255',
                'phone.*' => 'required_if:group,true|max:255',
                'cnic_front_image.*' => 'required_if:group,true|image|max:5000',
                'cnic_back_image.*' => 'required_if:group,true|image|max:5000',
                'user_image.*' => 'required_if:group,true|image|max:5000',

                'gatekeeper_id' => 'required|string|max:255',
                'purpose_of_visit' => 'required|string|max:255',
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
            $checkIns = [];

            if ($request->group) {
                $names = $request->input('name');
                $phones = $request->input('phone');
                $cnicFrontImages = $request->file('cnic_front_image');
                $cnicBackImages = $request->file('cnic_back_image');
                $userImages = $request->file('user_image');

                foreach ($names as $index => $name) {
                    $cnicFrontImagePath = $cnicFrontImages[$index]->store('uploads', 'public');
                    $cnicBackImagePath = $cnicBackImages[$index]->store('uploads', 'public');
                    $userImagePath = $userImages[$index]->store('uploads', 'public');

                    $visitor = Visitor::create([
                        'name' => $name,
                        'phone' => $phones[$index],
                        'cnic_front_image' => $cnicFrontImagePath,
                        'cnic_back_image' => $cnicBackImagePath,
                        'user_image' => $userImagePath,
                        'organization_name' => $request->input('organization_name'),
                        'vehicle_number' => $request->input('vehicle_number'),
                        'comments' => $request->input('comments'),
                    ]);

                    $visitors[] = $visitor;

                    $checkIn = CheckIn::create([
                        'visitor_id' => $visitor->id,
                        'gatekeeper_id' => $request->input('gatekeeper_id'),
                        'purpose_of_visit' => $request->input('purpose_of_visit'),
                        'department' => $request->input('department'),
                        'department_person_name' => $request->input('department_person_name'),
                    ]);

                    $checkIns[] = $checkIn;
                }
            } else {
                $cnicFrontImagePath = $request->file('cnic_front_image')->store('uploads', 'public');
                $cnicBackImagePath = $request->file('cnic_back_image')->store('uploads', 'public');
                $userImagePath = $request->file('user_image')->store('uploads', 'public');

                $visitor = Visitor::create([
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'cnic_front_image' => $cnicFrontImagePath,
                    'cnic_back_image' => $cnicBackImagePath,
                    'user_image' => $userImagePath,
                    'purpose_of_visit' => $request->input('purpose_of_visit'),
                    'department' => $request->input('department'),
                    'department_person_name' => $request->input('department_person_name'),
                    'organization_name' => $request->input('organization_name'),
                    'vehicle_number' => $request->input('vehicle_number'),
                    'comments' => $request->input('comments'),
                ]);

                $visitors[] = $visitor;

                $checkIn = CheckIn::create([
                    'visitor_id' => $visitor->id,
                    'gatekeeper_id' => $request->input('gatekeeper_id'),
                ]);

                $checkIns[] = $checkIn;
            }

            event(new CheckInUpdated($visitors, 'Check-in'));

            return response()->json([
                'message' => 'Visitor(s) created successfully',
                'data' => $visitors,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified visitor.
     */
    public function show($id)
    {
        try {
            $visitor = Visitor::with('checkIns')->find($id);

            if (!$visitor) {
                return response()->json(['error' => 'Visitor not found'], 404);
            }

            return response()->json($visitor);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified visitor in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $visitor = Visitor::find($id);

            if (!$visitor) {
                return response()->json(['error' => 'Visitor not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'phone' => 'string|max:20',
                'cnic_front_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                'cnic_back_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                'user_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                'purpose_of_visit' => 'string|max:255',
                'department' => 'string|max:255',
                'department_person_name' => 'string|max:255',
                'organization_name' => 'nullable|string|max:255',
                'vehicle_number' => 'nullable|string|max:50',
                'comments' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('cnic_front_image')) {
                $cnicFrontImagePath = $request->file('cnic_front_image')->store('public/uploads');
                $visitor->cnic_front_image = str_replace('public/', '', $cnicFrontImagePath);
            }

            if ($request->hasFile('cnic_back_image')) {
                $cnicBackImagePath = $request->file('cnic_back_image')->store('public/uploads');
                $visitor->cnic_back_image = str_replace('public/', '', $cnicBackImagePath);
            }

            if ($request->hasFile('user_image')) {
                $userImagePath = $request->file('user_image')->store('public/uploads');
                $visitor->user_image = str_replace('public/', '', $userImagePath);
            }

            $visitor->fill($request->except(['cnic_front_image', 'cnic_back_image', 'user_image']));
            $visitor->save();

            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Visitor updated successfully',
                    'visitor' => $visitor
                ]);
            } else {
                return redirect()->route('visitors.index')
                    ->with('success', 'Visitor updated successfully');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified visitor from storage.
     */
    public function destroy($id)
    {
        try {
            $visitor = Visitor::find($id);
            event(new CheckInUpdated($visitor, 'Deleted'));

            if (!$visitor) {
                return response()->json(['error' => 'Visitor not found'], 404);
            }

            $visitor->delete();

            return response()->json([
                'message' => 'Visitor deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
