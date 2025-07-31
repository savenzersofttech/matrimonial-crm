<?php
namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\LeadLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadActivityController extends Controller
{

    public function showAll(Request $request)
    {
        $dbColumns = (new LeadActivity())->getFillable();
        $order     = $request->post('order');
        $start     = $request->post('start') ?? 0;
        $length    = $request->post('length') ?? 10;
        $search    = $request->post('search')['value'] ?? null;

        // $query = LeadActivity::selectRaw('*')->with(['profile:id,name,email,phone_number']);
        $query = LeadActivity::with([
            'lead.profile' => function ($q) {
                $q->select('id', 'profile_id', 'name'); // Ensure 'user_id' matches the foreign key
            },
        ]);

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($dbColumns, $search) {
                foreach ($dbColumns as $key => $column) {
                    if ($key === 0) {
                        $q->where($column, 'like', "%$search%");
                    } else {
                        $q->orWhere($column, 'like', "%$search%");
                    }
                }
            });
        }

        // Order
        if (isset($order[0]['dir'])) {
            $dir      = $order[0]['dir'];
            $colIndex = $order[0]['column'] ?? false;
            $col      = $dbColumns[$colIndex] ?? false;
            if ($col) {
                $query->orderBy($col, $dir);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        // Count recordsFiltered before applying limit & offset
        $recordsFiltered = $query->count(DB::raw($start ? "$start" : '1'));

        // Pagination
        $data = $query->offset($start)->limit($length)->get()->toArray();
        // Add serial number manually based on pagination offset
        foreach ($data as $index => &$item) {
            $item['s_no'] = $start + $index + 1;

            $item['created_at'] = \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y h:i A');
            $item['updated_at'] = \Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y h:i A');
        }
        // Total records
        $recordsTotal = LeadActivity::count();

        $draw = $request->post('draw');

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => intval($recordsTotal),
            'recordsFiltered' => intval($recordsFiltered),
            'data'            => $data,
        ];

        return response()->json($response);
    }

    public function index()
    {
        $logs = LeadLog::with(['user', 'lead.profile'])
            ->latest()
            ->take(50)
            ->get()
            ->map(function ($log) {
                return [
                    'time_ago' => $this->formatTimeDiff($log->created_at),
                    'color'    => $this->getColor($log->action),
                    'message'  => $this->formatLogMessage($log),
                ];
            });

        $leadActivitys = LeadActivity::with(['creator', 'lead.profile'])->get();
        // dd($leadActivitys->toArray());

        return view('sales.lead-activities.index', compact('logs', 'leadActivitys'));
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
        $userName    = optional($log->user)->name ?? 'System';
        $profileName = optional($log->lead?->profile)->name ?? 'N/A';
        $by          = $log->user_id === Auth::id() ? 'You' : $userName;

        return "Lead for <strong>{$profileName}</strong> was <strong>{$log->action}</strong> by {$by}.";
    }

    // Show form to log a new activity
    public function create()
    {
        $leads = Lead::with('profile')->get();

        return view('sales.lead-activities.create', compact('leads'));
    }

    // Update existing activity
    public function update(Request $request, $id)
    {
        $request->validate([
            'type'    => 'required|in:Call,Email,Meeting,Proposal',
            'notes'    => 'required|string',
             'follow_up' => 'nullable|date_format:Y-m-d\TH:i',
            'outcome' => 'required|string',
            'status'  => 'required|string',
        ]);

        try {
            $activity = LeadActivity::findOrFail($id);

             // Log Entry
            // LeadLog::create([
            //     'lead_id' => $lead->id,
            //     'profile_id' => $profile->id,
            //     'action' => 'created',
            //     'user_id' => auth()->id(),
            //     'changes' => json_encode([
            //         'status' => $request->status,
            //         'note' => $request->note,
            //     ])
            // ]);

            $activity->update([
                'type'        => $request->type,
                'notes'        => $request->notes,
                'follow_up'        => $request->follow_up,
                'outcome'     => $request->outcome,
                'status'      => $request->status,
                'updated_by'  => auth()->id(), // Optional
            ]);

            return response()->json([
                'success'     => 'Activity updated successfully',
                'tableReload' => true, 
            ]);
        } catch (\Exception $e) {
            return response()->json([
                 'validationError' => $e->getMessage(),
                'message' => 'An error occurred while saving.',
            ], 500);
        }
    }

}
