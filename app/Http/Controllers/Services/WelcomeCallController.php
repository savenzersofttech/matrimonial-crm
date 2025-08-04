<?php
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\ProfileEmployeeAssignment;
use App\Models\WelcomeCall;
use App\Models\WelcomeCallHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WelcomeCallController extends Controller
{

        //uisng PaymentLink Model to Create and Del recoreds in welcome call/ welcome call log create form here
    
    public function showAll(Request $request)
    {
        $dbColumns = (new WelcomeCall())->getFillable();
        $order     = $request->post('order');
        $start     = $request->post('start') ?? 0;
        $length    = $request->post('length') ?? 10;
        $search    = $request->post('search')['value'] ?? null;

        // $query = Lead::selectRaw('*')->with(['profile:id,name,email,phone_number']);
        $query = WelcomeCall::with([
            'profile:id,name,email,phone_number,profile_source_id,profile_source_comment',
            'employee:id,name',
                'paymentLink.package:id,name,slug,duration_days,type',
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
        $recordsTotal = WelcomeCall::count();

        // Prepare response
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
        $employeeId       = Auth::id();
        $assignProfileIds = ProfileEmployeeAssignment::where('employee_id', $employeeId)->pluck('profile_id');
        $calls            = WelcomeCall::with(['profile:id,name,email,phone_number', 'profileAssignment.assignedBy', 'history' => function ($query) {
            $query->latest('call_time')->first(); // Works with datetime
        }])
            ->whereIn('profile_id', $assignProfileIds)
            ->get();
        // dd($calls->toArray());
        return view('services.welcome-calls.index', compact('calls'));
    }

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'welcome_call_id' => 'required|exists:welcome_calls,id',
                'profile_id'      => 'required|exists:profiles,id',
                'status'          => 'required|string|in:New,Pending,Completed,Missed,Rescheduled',
                'outcome'         => 'required|string|in:Successfull,No Answer,Follow-up Needed,Client Unreachable',
                'call_time'       => 'nullable|date', // corrected 'timedate' to 'date'
                'notes'           => 'nullable|string',
            ]);

            $welcomeCall = WelcomeCall::findOrFail($validated['welcome_call_id']);
            $welcomeCall->update([
                'status'    => $validated['status'],
                'outcome'   => $validated['outcome'],
                'call_time' => $validated['call_time'],
                'notes'     => $validated['notes'],
            ]);

            $history = WelcomeCallHistory::create([
                'welcome_call_id' => $validated['welcome_call_id'],
                'profile_id'      => $validated['profile_id'],
                'status'          => $validated['status'],
                'outcome'         => $validated['outcome'],
                'call_time'       => $validated['call_time'],
                'notes'           => $validated['notes'],
            ]);

            return response()->json([
                'success'     => 'Welcome call log successfully.',
                'tableReload' => true,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'An error occurred while deleting the payment link.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function historyLogs(Request $request)
    {
        try {
            $validated = $request->validate([
                'welcome_call_id' => 'required|exists:welcome_calls,id',
            ]);

            $histories = WelcomeCallHistory::where('welcome_call_id', $validated['welcome_call_id'])
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($log, $index) {
                    return [
                        's_no'       => $index + 1,
                        'status'     => $log->status,
                        'outcome'    => $log->outcome,
                        'call_time'  => $log->call_time ? \Carbon\Carbon::parse($log->call_time)->format('d/m/Y h:i A') : '-',
                        'notes'      => $log->notes ?? '-',
                        'created_at' => $log->created_at->format('d/m/Y h:i A'),
                    ];
                });

            return response()->json([
                'success' => true,
                'data'    => $histories,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage(),
            ], 500);
        }

    }

}