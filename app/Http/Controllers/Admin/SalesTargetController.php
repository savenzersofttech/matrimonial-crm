<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesTarget;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesTargetController extends Controller
{
    public function index()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereNotIn('name', ['admin', 'services', 'super-admin']);
        })->get();

        return view('admin.sales-targets.index', compact('users'));
    }

    public function showAll(Request $request)
    {
        $columns = (new SalesTarget)->getFillable();
        $order   = $request->post('order')[0] ?? null;
        $search  = $request->post('search')['value'] ?? '';
        $start   = $request->post('start') ?? 0;
        $length  = $request->post('length') ?? 10;

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
        $data            = $query->skip($start)->take($length)->get()->toArray();
        foreach ($data as $index => &$row) {
            $row['s_no']      = $start + $index + 1;
            $startDate        = Carbon::parse($row['start_date']);
            $endDate          = Carbon::parse($row['end_date']);
            $row['time_diff'] = $startDate->diffInDays($endDate);
        }

        return response()->json([
            'draw'            => intval($request->post('draw')),
            'recordsTotal'    => SalesTarget::count(),
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'        => 'required|exists:users,id',
            'period'         => 'required|string|max:50',
            'custom_period'  => 'nullable|string|max:250',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'contacted_lead' => 'required|integer|min:0',
            'converted_lead' => 'required|integer|min:0',
            'revenue'        => 'required|integer|min:0',
            'conform'        => 'nullable|string|in:yes',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationError' => $validator->errors()], 200);
        }

        // Check for overlapping only if user has not confirmed
        if ($request->conform !== 'yes') {
            $hasOverlap = SalesTarget::where('user_id', $request->user_id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                        });
                })
                ->exists();

            if ($hasOverlap) {
                return response()->json([
                    'confirmation' => true,
                    'success'      => 'This user already has a target assigned during the selected date range. Do you want to overwrite?',
                ], 200);
            }
        }

        SalesTarget::create([
            'user_id'        => $request->user_id,
            'contacted_lead' => $request->contacted_lead,
            'converted_lead' => $request->converted_lead,
            'revenue'        => $request->revenue,
            'period'         => $request->filled('custom_period') ? $request->custom_period : $request->period,
            'achieved'       => 0,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
        ]);

        return response()->json([
            'success'     => 'Sales Target added successfully.',
            'tableReload' => true,
        ], 200);
    }

    public function update(Request $request, $id)
{
    $target = SalesTarget::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'user_id'        => 'required|exists:users,id',
        'period'         => 'required|string|max:50',
        'custom_period'  => 'nullable|string|max:250',
        'start_date'     => 'required|date',
        'end_date'       => 'required|date|after_or_equal:start_date',
        'contacted_lead' => 'required|integer|min:0',
        'converted_lead' => 'required|integer|min:0',
        'revenue'        => 'required|integer|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json(['validationError' => $validator->errors()], 200);
    }

   

    $finalPeriod = $request->period === '0' && $request->filled('custom_period')
        ? $request->custom_period
        : $request->period;

    $target->update([
        'user_id'        => $request->user_id,
        'period'         => $finalPeriod,
        'start_date'     => $request->start_date,
        'end_date'       => $request->end_date,
        'contacted_lead' => $request->contacted_lead,
        'converted_lead' => $request->converted_lead,
        'revenue'        => $request->revenue,
    ]);

    return response()->json([
        'success'     => 'Sales Target updated successfully.',
        'tableReload' => true,
    ], 200);
}


    public function destroy($id)
    {
        try {
            $target = SalesTarget::findOrFail($id);
            $target->delete();

            return response()->json([
                'success'     => 'Sales Target deleted successfully.',
                'tableReload' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Failed to delete Sales Target.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
