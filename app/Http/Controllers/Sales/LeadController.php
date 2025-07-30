<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Profile;
use App\Models\ProfileSource;
use App\Models\LeadActivity;
use App\Models\User;
use App\Models\LeadLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\{GeneratesProfileId, HasDatatable};
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    use GeneratesProfileId, HasDatatable;
    public function index(Request $request)
    {
        $source = ProfileSource::all();
        return view('sales.leads.index', compact('source'));
    }

    public function showAll(Request $request)
    {
        $dbColumns = (new Lead())->getFillable();
        $order = $request->post('order');
        $start = $request->post('start') ?? 0;
        $length = $request->post('length') ?? 10;
        $search = $request->post('search')['value'] ?? null;

        // $query = Lead::selectRaw('*')->with(['profile:id,name,email,phone_number']);
        $query = Lead::with([
            'profile:id,name,email,phone_number,profile_source_id,profile_source_comment',
            'profile.profileSource:id,name'
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
            $dir = $order[0]['dir'];
            $colIndex = $order[0]['column'] ?? false;
            $col = $dbColumns[$colIndex] ?? false;
            if ($col) {
                $query->orderBy($col, $dir);
            }
        } else {
            $query->orderBy('Leads.id', 'desc');
        }

        // Count recordsFiltered before applying limit & offset
        $recordsFiltered = $query->count(DB::raw($start ? "$start" : '1'));

        // Pagination
        $data = $query->offset($start)->limit($length)->get()->toArray();
        // Add serial number manually based on pagination offset
        foreach ($data as $index => &$item) {
            $item['s_no'] = $start + $index + 1;
            $item['follow_up_row'] = $item['follow_up'];

            $item['created_at'] = \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y h:i A');
            $item['updated_at'] = \Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y h:i A');
            $item['follow_up'] = \Carbon\Carbon::parse($item['follow_up'])->format('d/m/Y h:i A');
        }
        // Total records
        $recordsTotal = Lead::count();

        // Prepare response
        $draw = $request->post('draw');

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsFiltered),
            'data' => $data,
        ];

        return response()->json($response);
    }

    public function create()
    {
        $profiles = Profile::all();
        return response()->json([
            'profiles' => $profiles,
            'message' => 'Profiles fetched successfully',
        ]);
    }



    public function store(Request $request)
    {
        try {
            $request->merge([
                'phone_number' => $request->phone_code . preg_replace('/\s+/', '', $request->phone_number),
            ]);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:225',
                'email' => 'required|email|unique:profiles,email',
                'phone_number' => 'required|string|unique:profiles,phone_number',
                'status' => 'required|string|in:New,Contacted,Follow Up,Qualified,Not Interested,Lost,Converted',
                'profile_source_id' => 'required|exists:profile_sources,id',
                'note' => 'nullable|string',
                'source_comment' => 'nullable|string',
                'follow_up' => 'nullable|date_format:Y-m-d\TH:i',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'validationError' => $validator->errors(),
                    'message' => 'Validation failed',
                ], 422);
            }

            DB::beginTransaction();

            // Profile
            $profile = Profile::create([
                'profile_id' => $this->generateProfileId($request->name, $request->phone_number),
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'profile_source_id' => $request->profile_source_id,
                'profile_source_comment' => $request->source_comment,
            ]);

            // Lead
            $lead = Lead::create([
                'profile_id' => $profile->id,
                'status' => $request->status,
                'note' => $request->note,
                'follow_up' => $request->follow_up,
                'created_by' => auth()->id(),
            ]);

            // Log Entry
            LeadLog::create([
                'lead_id' => $lead->id,
                'profile_id' => $profile->id,
                'action' => 'created',
                'user_id' => auth()->id(),
                'changes' => json_encode([
                    'status' => $request->status,
                    'note' => $request->note,
                ])
            ]);

            // Optionally: create initial lead activity (basic)
            LeadActivity::create([
                'lead_id' => $lead->id,
                'type' => 'Call',
                'notes' => $request->note ?? 'Initial creation',
                'status' => $request->status,
                'outcome' => null,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Lead and profile added successfully.',
                'tableReload' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'validationError' => $e->getMessage(),
                'message' => 'An error occurred while saving.',
            ], 500);
        }
    }



 

    public function update(Request $request, $id)
{
    try {
        $request->merge([
            'phone_number' => $request->phone_code . preg_replace('/\s+/', '', $request->phone_number),
        ]);

        $lead = Lead::findOrFail($id);
        $profile = $lead->profile;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'email' => 'required|email|unique:profiles,email,' . $profile->id,
            'phone_number' => 'required|string|max:20',
            'status' => 'required|string|in:New,Contacted,Follow Up,Qualified,Not Interested,Lost,Converted',
            'profile_source_id' => 'required|exists:profile_sources,id',
            'note' => 'nullable|string',
            'source_comment' => 'nullable|string',
            'follow_up' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'validationError' => $validator->errors(),
                    'message' => 'Validation failed',
                ],
                422,
            );
        }

        DB::beginTransaction();

        $profile->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'profile_source_id' => $request->profile_source_id,
            'profile_source_comment' => $request->source_comment,
        ]);

        $lead->update([
            'status' => $request->status,
            'note' => $request->note,
            'follow_up' => $request->follow_up,
        ]);

        DB::commit();

        return response()->json([
            'success' => 'Lead and profile updated successfully.',
            'tableReload' => true,
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(
            [
                'validationError' => $e->getMessage(),
                'message' => 'An error occurred while updating.',
            ],
            500,
        );
    }
}

    public function destroy(Request $request, $id){
        $lead = Lead::findOrFail($id);
        $lead->delete();
        return response()->json([
            'success' => 'Lead deleted successfully.',
            'tableReload'=> true,
            ]);
            
    }


    public function convertToClient(Lead $lead)
    {
        try {
            if (!$lead->profile_id) {
                $profile = Profile::create([
                    'name' => $lead->profile_name ?? 'New Client',
                    'email' => null,
                    'phone_number' => null,
                ]);
                $lead->update(['profile_id' => $profile->id]);
            }

            return response()->json([
                'success' => 'Lead converted to client.',
                'redirectTo' => route('profiles.show', $lead->profile_id),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => 'Conversion failed. ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
}