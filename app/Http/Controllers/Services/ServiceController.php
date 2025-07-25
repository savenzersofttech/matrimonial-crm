<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    protected $planTypes;
    public function __construct()
    {
        $this->planTypes = [
            ['name' => 'Exclusive 1 month', 'duration' => '1 month'],
            ['name' => 'Exclusive 3 months', 'duration' => '3 months'],
            ['name' => 'Exclusive 6 months', 'duration' => '6 months'],
            ['name' => 'Elite 3 months', 'duration' => '3 months'],
            ['name' => 'Exclushiv 45 days', 'duration' => '45 days'],
            ['name' => '1 year Exclusive', 'duration' => '12 months'],
            ['name' => 'Open duration', 'duration' => 'unlimited'],
            ['name' => 'Exclusive', 'duration' => 'custom'],
        ];
    }
    /**
     * Display a filtered list of services.
     */
    public function index(Request $request)
    {
        $services = Service::with('profile')
            ->when($request->input('client_name'), function ($query, $clientName) {
                $query->whereHas('profile', function ($q) use ($clientName) {
                    $q->where('name', 'like', '%' . $clientName . '%');
                });
            })
            ->when($request->input('plan'), fn($q, $plan) => $q->where('plan', $plan))
            ->when($request->input('status'), fn($q, $status) => $q->where('status', $status))
            ->when($request->input('expiration_date'), fn($q, $date) => $q->where('end_date', $date))
            ->orderBy('end_date', 'asc')
            ->paginate(15);

        return view('services.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $profiles = Profile::all();
        return view('services.services.create', [
            'profiles' => $profiles,
            'planTypes' => $this->planTypes,
        ]);
    }

    /**
     * Display the service with history.
     */
    public function show($id)
    {
        $service = Service::with('profile', 'addedBy', 'updatedBy')->findOrFail($id);

        $history = Service::where('profile_id', $service->profile_id)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('services.services.show', [
            'service' => $service,
            'history' => $history,
            'planTypes' => $this->planTypes,
        ]);
    }

    /**
     * Show all plan history of profile.
     */
    public function showHistory($id)
    {
        $service = Service::with('profile')->findOrFail($id);
        $profile = $service->profile;

        $services = Service::where('profile_id', $profile->id)
            ->with(['addedBy', 'updatedBy'])
            ->orderByDesc('created_at')
            ->get();

        return view('services.services.history', compact('profile', 'services'));
    }

    /**
     * Store a new service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'price' => 'required|integer|min:0',
            'remarks' => 'nullable|string|max:255',
            'plan' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'profile_id.required' => 'Please select a profile.',
            'profile_id.exists' => 'Selected profile not found.',
            'price.required' => 'Price is required.',
            'price.integer' => 'Price must be a number.',
            'price.min' => 'Price cannot be negative.',
            'plan.required' => 'Please enter a plan name.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'End date must be a valid date.',
            'end_date.after_or_equal' => 'End date must be the same or after start date.',
        ]);

        Service::create([
            'profile_id' => $request->profile_id,
            'plan' => $request->plan,
            'remarks' => $request->remarks,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Active',
            'added_by' => Auth::id(),
        ]);

        return redirect()->route('services.services.index')
            ->with('success', 'New service assigned successfully.');
    }

    /**
     * Edit service view.
     */
public function edit($id)
{

    $statuses = [
    'Active' => 'Active',
    'Inactive' => 'Inactive',
    'Expired' => 'Expired',
];
    $service = Service::findOrFail($id);
    $profiles = Profile::all();

    return view('services.services.edit', [
        'service' => $service,
        'profiles' => $profiles,
        'planTypes' => $this->planTypes,
            'statuses' => $statuses,
    ]);
}


    /**
     * Update existing service.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'plan' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'remarks' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Active,Expiring Soon,Expired',
        ], [
            'plan.required' => 'Plan name is required.',
            'price.required' => 'Price is required.',
            'price.integer' => 'Price must be a valid number.',
            'start_date.required' => 'Start date is required.',
            'end_date.required' => 'End date is required.',
            'status.required' => 'Please select a valid status.',
        ]);

        $service = Service::findOrFail($id);

        $service->update([
            // profile_id NOT editable here
            'plan' => $request->plan,
            'remarks' => $request->remarks,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('services.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Delete a service.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
