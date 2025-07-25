<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileEmployeeAssignment;
use App\Models\User;
use App\Models\WelcomeCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileAssignmentController extends Controller
{

    // API CODE START
    public function userAndemployees(Request $request)
    {
        $mode = $request->query('mode', 'add'); // default is 'add'

        $employees = User::select('id as value', DB::raw('CONCAT(name, " - ", email) as label'))
            ->whereNotIn('role', ['admin', 'super-admin'])
            ->get();

        // Decide whether to return all profiles or only unassigned ones
        $profilesQuery = Profile::select('id as value', DB::raw('CONCAT(name, " - ", profile_id) as label'));

        if ($mode === 'add') {
            $profilesQuery->doesntHave('staffAssignment');
        }

        $profiles = $profilesQuery->get();

        return response()->json([
            'users'    => $employees,
            'profiles' => $profiles,
        ]);
    }

    // API CODE START

    public function index()
    {
        $assignments = ProfileEmployeeAssignment::with(['profile', 'employee'])->latest()->get();

        return view('assigns.index', compact('assignments'));
    }

    public function showAll(Request $request)
    {
        $dbColumns = (new ProfileEmployeeAssignment)->getFillable();
        $order     = $request->post('order');
        $start     = $request->post('start') ?? 0;
        $length    = $request->post('length') ?? 10;
        $search    = $request->post('search')['value'] ?? null;

        $query = ProfileEmployeeAssignment::with(['profile:id,name', 'employee', 'assignedBy:id,name'])->latest();

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
            $query->orderBy('profiles.id', 'desc');
        }

        // Count recordsFiltered before applying limit & offset
        $recordsFiltered = $query->count(DB::raw($start ? "$start" : "1"));

        // Pagination
        $data = $query->offset($start)->limit($length)->get()->toArray();
        // Add serial number manually based on pagination offset
        foreach ($data as $index => &$item) {
            $item['s_no'] = $start + $index + 1;

            $item['created_at']  = \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y h:i A');
            $item['updated_at']  = \Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y h:i A');
            $item['assigned_at'] = \Carbon\Carbon::parse($item['assigned_at'])->format('d/m/Y h:i A');
        }
        // Total records
        $recordsTotal = Profile::count();

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

    public function edit($id)
    {
        $assignment = ProfileEmployeeAssignment::findOrFail($id);

        $employees = User::whereNotIn('role', ['admin', 'super-admin'])->get();

        // Fetch all unassigned profiles + currently assigned one
        $profiles = Profile::whereDoesntHave('staffAssignment')
            ->orWhere('id', $assignment->profile_id)
            ->get();

        return view('assigns.edit', compact('assignment', 'employees', 'profiles'));
    }

    public function create()
    {
        $employees = User::whereNotIn('role', ['admin', 'super-admin'])->get();
        $profiles  = Profile::doesntHave('staffAssignment')->get(); // only unassigned
        return view('assigns.create', compact('employees', 'profiles'));
    }

  
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'profile_ids' => 'required|string',
        'profile_ids' => [
            'required',
            'exists:profiles,id',
            function ($attribute, $value, $fail) {
                $alreadyAssigned = ProfileEmployeeAssignment::where('profile_id', $value)->exists();
                if ($alreadyAssigned) {
                    $fail("Profile ID $value is already assigned.");
                }
            },
        ],
        'employee_id' => 'required|exists:users,id',
        'note'        => 'nullable|string|max:1000',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error.',
            'errors' => $validator->errors()
        ], 422);
    }
    
     $rawProfileIds = $request->profile_ids;

    if (is_string($rawProfileIds)) {
        $profileIds = explode(',', $rawProfileIds);
    } elseif (is_array($rawProfileIds)) {
        $profileIds = $rawProfileIds;
    } else {
        $profileIds = [$rawProfileIds];
    }


    // dd($profileIds);
    try {
        foreach ($profileIds  as $profile_id) {
            
            ProfileEmployeeAssignment::create([
                'profile_id'  => $profile_id,
                'employee_id' => $request->employee_id,
                'note'        => $request->note,
                'assigned_at' => now(),
                'assigned_by' => auth()->id(),
            ]);
        }

        return response()->json([
            'status' => true,
                            'tableReload' => true,

            'success' => 'Profiles assigned successfully.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}

  public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'profile_ids'   => [
                'required',
                'array',
            ],
            'profile_ids' => [
                'required',
                'exists:profiles,id',
                // function ($attribute, $value, $fail) use ($id) {
                //     $alreadyAssigned = ProfileEmployeeAssignment::where('profile_id', $value)
                //         ->where('id', '!=', $id)
                //         ->exists();
                //     if ($alreadyAssigned) {
                //         $fail("Profile ID {$value} is already assigned to another employee.");
                //     }
                // },
            ],
            'employee_id'   => 'required|exists:users,id',
            'note'          => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation errors occurred.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Delete existing assignments for this group (optional if replacing)
            ProfileEmployeeAssignment::where('employee_id', $request->employee_id)->delete();
            
            
              $rawProfileIds = $request->profile_ids;

                if (is_string($rawProfileIds)) {
                    $profileIds = explode(',', $rawProfileIds);
                } elseif (is_array($rawProfileIds)) {
                    $profileIds = $rawProfileIds;
                } else {
                    $profileIds = [$rawProfileIds];
                }


                // dd($profileIds);
            
            
            foreach ($profileIds as $profile_id) {
                ProfileEmployeeAssignment::updateOrCreate(
                    ['profile_id' => $profile_id],
                    [
                        'employee_id' => $request->employee_id,
                        'note'        => $request->note,
                        'assigned_at' => now(),
                        'assigned_by' => auth()->id(),
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success'     => 'updated successfully',
                'tableReload' => true,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong during the update.',
                'error'   => $e->getMessage(),
            ], 2);
        }
    }


    public function destroy($id)
    {
        try {
            $assignment = ProfileEmployeeAssignment::findOrFail($id);
            $assignment->delete();

            return response()->json([
                 'success'     => 'Assignment deleted successfully.',
                'tableReload' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to delete assignment.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

}
