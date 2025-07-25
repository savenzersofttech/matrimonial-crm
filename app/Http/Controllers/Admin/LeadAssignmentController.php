<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Models\Profile;
use App\Models\LeadAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadAssignmentController extends Controller
{
    public function index()
    {
        $assignments = LeadAssignment::with(['lead.profile:id,name', 'assignedTo', 'assignedBy'])->latest()->get();
    // dd($assignments->toArray());
        $totalLeads = Lead::count();
        $assignedLeads = LeadAssignment::count();
        $newLeads = Lead::where('status', 'New')->count();
        $followUps = Lead::where('status', 'Follow Up')->count();

        return view('admin.lead_assignments.index', compact('assignments', 'totalLeads', 'assignedLeads', 'newLeads', 'followUps'));
    }

    public function create()
    {
        $profiles = Profile::select('id','name')->get();
        $employees = User::whereNotIn('role', ['admin', 'super-admin'])->get();

        return view('admin.lead_assignments.create', compact('profiles', 'employees'));
    }

   public function store(Request $request)
{
    $request->validate([
        'profile_ids' => 'required|array|min:1',
        'profile_ids.*' => 'exists:profiles,id',
        'assigned_to' => 'required|exists:users,id',
        'note' => 'nullable|string|max:1000',
    ]);

    $createdLeads = [];

    foreach ($request->profile_ids as $profileId) {
        // Check for existing active lead
        $existingLead = Lead::where('profile_id', $profileId)
            ->whereIn('status', ['New', 'Follow Up'])
            ->first();

        if ($existingLead) {
            // Skip or handle error for this profile
            continue;
        }

        // Create new lead
        $lead = Lead::create([
            'profile_id' => $profileId,
            'status' => 'New',
            'created_by' => Auth::id(),
            'note' => $request->note,
        ]);

        // Assign the lead
        LeadAssignment::create([
            'lead_id' => $lead->id,
            'assigned_to' => $request->assigned_to,
            'assigned_by' => Auth::id(),
            'note' => $request->note,
        ]);

        $createdLeads[] = $lead;
    }

    if (count($createdLeads) === 0) {
        return back()->withErrors(['profile_ids' => 'All selected profiles already have active leads.'])->withInput();
    }

    return redirect()->route('admin.lead_assignments.index')->with('success', count($createdLeads).' leads created and assigned.');
}




public function edit($id)
{
    $leadAssignment = LeadAssignment::with('lead.profile', 'assignedTo')->findOrFail($id);
    dd($leadAssignment->toArray());
    $users = User::whereNotIn('role', ['admin', 'super-admin'])->get();
    $profiles = Profile::select('id', 'name')->get(); 
    return view('admin.lead_assignments.edit', compact('leadAssignment', 'users', 'profiles'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'note' => 'nullable|string|max:1000',
            // 'profile_id' => 'required|exists:profiles,id', // Only if editing lead's profile
        ]);

        $assignment = LeadAssignment::findOrFail($id);

        // Optionally update related lead’s profile or status
        // $assignment->lead->update([
        //     'profile_id' => $request->profile_id,
        // ]);

        $assignment->update([
            'assigned_to' => $request->assigned_to,
            'note' => $request->note,
        ]);

        return redirect()->route('admin.lead_assignments.index')->with('success', 'Lead assignment updated successfully.');
    }


    public function destroy(LeadAssignment $lead_assignment)
    {
        $lead_assignment->delete();

        return redirect()->route('admin.lead_assignments.index')->with('success', 'Lead assignment deleted.');
    }
}
