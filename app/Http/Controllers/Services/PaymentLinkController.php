<?php
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;

use App\Models\PaymentLink;
use App\Models\{
    Profile,
    Service,
    Package,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentLinkController extends Controller
{
    // Show all payment links
    public function index()
    {
        // $payments = PaymentLink::with(['profile:id,name', 'package:id,name'])->latest()->get();
        $profiles = Profile::all();
        $packages = Package::all(); // <-- corrected variable name

        return view('services.payments.index', compact('profiles', 'packages'));
    }

    public function show()
    {
        return view('services.payments.index');
    }

    public function showAll(Request $request)
    {

        $dbColumns = (new PaymentLink)->getFillable();
        $order     = $request->post('order');
        $start     = $request->post('start') ?? 0;
        $length    = $request->post('length') ?? 10;
        $search    = $request->post('search')['value'] ?? null;

        $query = PaymentLink::selectRaw('*')
            ->with(['profile:id,name', 'package:id,name']);

        // $query =  PaymentLink::with(['profile:id,name', 'package:id,name'])
        //     ->get();

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
            $query->orderBy('payment_links.id', 'desc');
        }

        // Count recordsFiltered before applying limit & offset
        $recordsFiltered = $query->count(DB::raw($start ? "$start" : "1"));

        // Pagination
        $data = $query->offset($start)->limit($length)->get()->toArray();
        // Add serial number manually based on pagination offset
        foreach ($data as $index => &$item) {
            $item['s_no'] = $start + $index + 1;
        }
        // Total records
        $recordsTotal = PaymentLink::count();

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

    // Store new payment link
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profile_id' => 'required|exists:profiles,id',
                'plan_id'    => 'required|string',
                'currency'   => 'required|string|in:INR,USD',
                'price'      => 'required|numeric|min:1',
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
                'discount'   => 'nullable|numeric|min:0|max:100',
            ], [
                'profile_id.required'     => 'Profile is required.',
                'profile_id.exists'       => 'Selected profile does not exist.',
                'plan_id.required'        => 'Plan is required.',
                'currency.required'       => 'Select currency acc to plan',
                'price.required'          => 'Price is required.',
                'price.numeric'           => 'Price must be a number.',
                'price.min'               => 'Price must be at least 1.',
                'discount.numeric'        => 'Discount must be a number.',
                'discount.min'            => 'Discount cannot be negative.',
                'discount.max'            => 'Discount cannot exceed 100.',
                'start_date.required'     => 'Start date is required.',
                'start_date.date'         => 'Start date must be a valid date.',
                'end_date.required'       => 'End date is required.',
                'end_date.date'           => 'End date must be a valid date.',
                'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            ])->setAttributeNames([
                'profile_id' => 'Profile',
                'plan_id'    => 'Plan ',
                'price'      => 'Price',
                'currency'   => 'Currency',
                'discount'   => 'Discount',
                'start_date' => 'Start Date',
                'end_date'   => 'End Date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'validationError' => $validator->errors(),
                ], 200);
            }

            $finalAmount = $request->price - ($request->price * ($request->discount / 100));
            // $userId = Auth::check() ? Auth::id() : null;

            $paymentLink = PaymentLink::create([
                'profile_id'   => $request->profile_id,
                // 'user_id' => $userId,
                'plan_id'      => $request->plan_id,
                'status'       => 'Pending',
                'price'        => $request->price,
                'currency'     => $request->currency,
                'gateway'      => $request->currency === 'USD' ? 'paypal' : 'razorpay',
                'discount'     => $request->discount,
                'final_amount' => round($finalAmount),
                'payment_link' => 'https://payment.example.com/' . Str::random(32),
                'start_date'   => $request->start_date,
                'end_date'     => $request->end_date,
                'sent_at'      => now(),
            ]);

            return response()->json([
                'success'     => 'Payment link created successfully.',
                'tableReload' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 200);
        }
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'plan'       => 'required|string',
            'price'      => 'required|numeric|min:1',
            'discount'   => 'nullable|numeric|min:0|max:100',
        ], );
    }

    // Update record
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profile_id' => 'required|exists:profiles,id',
                'plan_id'    => 'required|string',
                'currency'   => 'required|string|in:INR,USD',
                'price'      => 'required|numeric|min:1',
                'status'     => 'required|in:Pending,Paid,Failed',
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
                'discount'   => 'nullable|numeric|min:0|max:100',
            ], [
                'profile_id.required'     => 'Profile is required.',
                'profile_id.exists'       => 'Selected profile does not exist.',
                'plan_id.required'        => 'Plan is required.',
                'currency.required'       => 'Select currency acc to plan',
                'price.required'          => 'Price is required.',
                'status.required'         => 'Status is required.',
                'price.numeric'           => 'Price must be a number.',
                'price.min'               => 'Price must be at least 1.',
                'discount.numeric'        => 'Discount must be a number.',
                'discount.min'            => 'Discount cannot be negative.',
                'discount.max'            => 'Discount cannot exceed 100.',
                'start_date.required'     => 'Start date is required.',
                'start_date.date'         => 'Start date must be a valid date.',
                'end_date.required'       => 'End date is required.',
                'end_date.date'           => 'End date must be a valid date.',
                'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            ])->setAttributeNames([
                'profile_id' => 'Profile',
                'plan_id'    => 'Plan',
                'price'      => 'Price',
                'currency'   => 'Currency',
                'discount'   => 'Discount',
                'start_date' => 'Start Date',
                'end_date'   => 'End Date',
                'status'     => 'Status',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'validationError' => $validator->errors(),
                ], 200);
            }

            $paymentLink = PaymentLink::findOrFail($id);
            // dd($request->status);
            $finalAmount = $request->price - ($request->price * ($request->discount / 100));

            $paymentLink->update([
                'profile_id'   => $request->profile_id,
                'plan_id'      => $request->plan_id,
                'status'       => $request->status,
                'price'        => $request->price,
                'currency'     => $request->currency,
                'gateway'      => $request->currency === 'USD' ? 'paypal' : 'razorpay',
                'discount'     => $request->discount,
                'final_amount' => round($finalAmount),
                'start_date'   => $request->start_date,
                'end_date'     => $request->end_date,
            ]);

            if ($paymentLink->status === 'Paid' || $paymentLink->status === 'paid') {
                $existingActiveService = Service::where('profile_id', $request->profile_id)
                    ->where('plan', $request->plan)
                    ->where('status', 'Active')
                    ->first();

                if ($existingActiveService) {
                    if (Carbon\Carbon::parse($request->start_date)->lte(Carbon\Carbon::parse($existingActiveService->end_date))) {
                        return response()->json([
                            'warning' => 'An active service already exists for this plan. Please choose a start date after ' . $existingActiveService->end_date,
                        ], 200);
                    }
                }

                // Service::create([
                //     'profile_id' => $request->profile_id,
                //     'plan' => $request->plan,
                //     'price' => round($finalAmount),
                //     'start_date' => $request->start_date,
                //     'end_date' => $request->end_date,
                //     'status' => 'Active',
                //     'added_by' => Auth::id(),
                // ]);
            }

            return response()->json([
                'success'     => 'Payment link updated successfully.',
                'tableReload' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 200);
        }
    }

    public function destroy($id)
    {
        try {
            $payment = PaymentLink::findOrFail($id);
            $payment->delete();

            return response()->json([
                'success'     => 'Payment link deleted successfully.',
                'tableReload' => true,
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Payment link not found.',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'An error occurred while deleting the payment link.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
