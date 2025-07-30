<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesTarget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesTargetController extends Controller
{
    public function index()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereNotIn('name', ['admin','sales', 'super-admin']);
        })->get();

        return view('admin.sales-targets.index', compact('users'));
    }

    public function showAll(Request $request)
    {
        $columns = (new SalesTarget)->getFillable();
        $order = $request->post('order')[0] ?? null;
        $search = $request->post('search')['value'] ?? '';
        $start = $request->post('start') ?? 0;
        $length = $request->post('length') ?? 10;

        $query = SalesTarget::with('user:id,name');

        if ($search) {
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $i => $col) {
                    $i === 0
                        ? $q->where($col, 'like', "%$search%")
                        : $q->orWhere($col, 'like', "%$search%");
                }
            });
        }

        if ($order) {
            $orderCol = $columns[$order['column']] ?? 'id';
            $query->orderBy($orderCol, $order['dir'] ?? 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $recordsFiltered = $query->count();
        $data = $query->skip($start)->take($length)->get()->toArray();
        foreach ($data as $index => &$row) {
            $row['s_no'] = $start + $index + 1;
        }

        return response()->json([
            'draw' => intval($request->post('draw')),
            'recordsTotal' => SalesTarget::count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'period' => 'required|string|max:50', // e.g. Monthly, Quarterly
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'contacted_lead' => 'required|integer|min:0',
        'converted_lead' => 'required|integer|min:0',
        'revenue' => 'required|integer|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json(['validationError' => $validator->errors()], 200);
    }

    SalesTarget::create([
        'user_id' => $request->user_id,
        'contacted_lead' => $request->contacted_lead,
        'converted_lead' => $request->converted_lead,
        'revenue' => $request->revenue,
        'period' => $request->period,
        'achieved' => 0,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    return response()->json([
        'success' => 'Sales Target added successfully.',
        'tableReqload' => true
    ], 200);
}
    public function update(Request $request, $id)
    {
        $target = SalesTarget::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:Contacted,Converted,Revenue',
            'time_period' => 'required|string',
            'target' => 'required|integer|min:1',
            'achieved' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationError' => $validator->errors()], 200);
        }

        $target->update($request->only([
            'user_id', 'type', 'time_period', 'target', 'achieved', 'start_date', 'end_date'
        ]));

        return response()->json([
            'success' => 'Sales Target updated successfully.',
            'tableReqload' => true
        ], 200);
    }

    public function destroy($id)
    {
        try {
            $target = SalesTarget::findOrFail($id);
            $target->delete();

            return response()->json([
                'success' => 'Sales Target deleted successfully.',
                'tableReqload' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete Sales Target.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
