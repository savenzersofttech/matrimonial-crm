<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeadActivity;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\LeadLog;
use Carbon\Carbon;

class LeadActivityController extends Controller
{


    public function index()
    {
        $logs = LeadLog::with(['user', 'lead.profile'])
            ->latest()
            ->take(50)
            ->get()
            ->map(function ($log) {
                return [
                    'time_ago' => $this->formatTimeDiff($log->created_at),
                    'color' => $this->getColor($log->action),
                    'message' => $this->formatLogMessage($log),
                ];
            });

        $leadActivitys  = LeadActivity::with(['creator', 'lead.profile'])->get();
        // dd($leadActivitys->toArray());

        return view('sales.lead-activities.index', compact('logs','leadActivitys'));
    }

    private function formatTimeDiff($time)
    {
        return Carbon::parse($time)->diffForHumans(null, true); // e.g., "2 hrs", "1 day"
    }

    private function getColor($action)
    {
        return match ($action) {
            'created' => 'bg-green',
            'updated' => 'bg-blue',
            'deleted' => 'bg-red',
            'assigned' => 'bg-yellow',
            default => 'bg-gray',
        };
    }

    private function formatLogMessage($log)
    {
        $userName = optional($log->user)->name ?? 'System';
        $profileName = optional($log->lead?->profile)->name ?? 'N/A';
        $by = $log->user_id === Auth::id() ? 'You' : $userName;

        return "Lead for <strong>{$profileName}</strong> was <strong>{$log->action}</strong> by {$by}.";
    }


    // Show form to log a new activity
    public function create()
    {
        $leads = Lead::with('profile')->get();

        return view('sales.lead-activities.create', compact('leads'));
    }

    // Store a new activity
    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'type' => 'required|in:Call,Email,Meeting,Proposal',
            'notes' => 'nullable|string',
            'outcome' => 'nullable|string',
            'status' => 'required|string',
            'activity_at' => 'required|date',
        ]);

        LeadActivity::create([
            'lead_id' => $request->lead_id,
            'type' => $request->type,
            'notes' => $request->notes,
            'outcome' => $request->outcome,
            'status' => $request->status,
            'activity_at' => $request->activity_at,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('sales.lead-activities.index')->with('success', 'Activity logged successfully.');
    }
}
