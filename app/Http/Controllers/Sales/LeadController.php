<?php

namespace App\Http\Controllers\Sales;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Profile;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Show all leads with filters.
     */
    public function index(Request $request)
    {
        $leads = Lead::with('profile:id,name,email,phone')
            ->when($request->name, fn($q, $name) => $q->whereHas('profile', fn($q2) => $q2->where('name', 'like', "%$name%")))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->when($request->source, fn($q, $source) => $q->where('source', $source))
            ->when($request->follow_up, fn($q, $date) => $q->whereDate('follow_up', $date))
            ->latest()
            ->get();
        // dd($leads->toArray()); // Debugging line, remove in production
        return view('sales.leads.index', compact('leads'));
    }

    /**
     * Show form to create a new lead.
     */
    public function create()
    {
        $profiles = Profile::all(); // for selecting existing client
        return view('leads.create', compact('profiles'));
    }

    /**
     * Store a new lead.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_id' => 'nullable|exists:profiles,id',
            'source' => 'nullable|string|max:255',
            'status' => 'required|in:New,Contacted,Qualified,Lost',
            'notes' => 'nullable|string',
            'follow_up' => 'nullable|date',
        ]);

        Lead::create($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead added successfully.');
    }

    /**
     * Edit lead.
     */
    public function edit(Lead $lead)
    {
        $profiles = Profile::all();
        return view('leads.edit', compact('lead', 'profiles'));
    }

    /**
     * Update lead.
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'profile_id' => 'nullable|exists:profiles,id',
            'source' => 'nullable|string|max:255',
            'status' => 'required|in:New,Contacted,Qualified,Lost',
            'notes' => 'nullable|string',
            'follow_up' => 'nullable|date',
        ]);

        $lead->update($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Convert to client (create profile if none exists).
     */
    public function convertToClient(Lead $lead)
    {
        if (!$lead->profile_id) {
            $profile = Profile::create([
                'name' => $lead->profile_name ?? 'New Client',
                'email' => null, // or get from form
                'contact_number' => null,
            ]);
            $lead->update(['profile_id' => $profile->id]);
        }

        return redirect()->route('profiles.show', $lead->profile_id)->with('success', 'Lead converted to client.');
    }
}
