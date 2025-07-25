<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\WelcomeCall;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FollowUpHistory;
use App\Models\ProfileEmployeeAssignment;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;

class WelcomeCallController extends Controller
{
   

    public function index()
    {
        $employeeId = Auth::id();
        $assignProfileIds = ProfileEmployeeAssignment::where('employee_id', $employeeId)->pluck('profile_id');
        $calls = WelcomeCall::with(['profile:id,name,email,phone', 'profileAssignment.assignedByUser', 'followUpHistories' => function ($query) {
            $query->latest('follow_up_date')->first(); // Works with datetime
        }])
        ->whereIn('profile_id', $assignProfileIds)
        ->get();
        // dd($calls->toArray());
        return view('services.welcome-calls.index', compact('calls'));
    }

    public function create()
    {
        $profiles = Profile::all();
        $employees = User::whereNotIn('role', ['admin', 'super-admin'])->get();
        return view('welcome-calls.create', compact('profiles', 'employees'));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'employee_id' => 'nullable|exists:users,id',
            'status' => 'required|string',
            'comment' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);
        
        WelcomeCall::create($request->all());
        return redirect()->route('services.welcome-calls.index')->with('success', 'Welcome Call created.');
    }

    public function show(WelcomeCall $welcomeCall)
{
    $welcomeCall->load('profile', 'followUpHistories.employee'); // Eager load profile and follow-up histories with employee
    return view('services.welcome-calls.show', compact('welcomeCall'));
}

    public function edit(WelcomeCall $welcomeCall)
    {
        $profiles = Profile::all();
        $employees = User::whereNotIn('role', ['admin', 'super-admin'])->get();
        $welcomeCall->load('followUpHistories.employee'); // Load all follow-up histories with employee
        return view('services.welcome-calls.edit', compact('welcomeCall', 'profiles', 'employees'));
    }

 public function update(Request $request, WelcomeCall $welcomeCall)
{
    $request->merge([
    'follow_up_date' => str_replace('T', ' ', $request->follow_up_date)
    ]);
    $profileId = $welcomeCall->profile->id ?? null;

    $validator = Validator::make($request->all(), [
    'name' => 'required|string',
    'phone_code' => 'required|string',
      'email' => 'nullable|email|unique:profiles,email,' . $profileId,
    'phone' => 'nullable|unique:profiles,phone,' . $profileId,
    'status' => 'required|string',
    'follow_up_date' => 'nullable|date_format:Y-m-d H:i',
    'comment' => 'nullable|string',
]);

    if ($validator->fails()) {
        return ApiResponse::error('Validation failed.', $validator->errors(), 422);
    }

    try {

        // Update related Profile if exists
        if ($welcomeCall->profile) {
    $welcomeCall->profile->update([
        'name' => Str::ucfirst($request->name),
        'phone' =>$request->phone_code . "-" .  $request->phone,
        'email' => $request->email,
    ]);
}
        FollowUpHistory::create([
            'welcome_call_id' => $welcomeCall->id,
            'employee_id' => auth()->id(),
            'follow_up_date' => $request->follow_up_date,
            'status' => $request->status,
            'comment' => $request->comment,
        ]);

        $welcomeCall->update($request->only(['status', 'comment', 'follow_up_date']));

        return ApiResponse::success('Welcome Call updated successfully.');
    } catch (\Exception $e) {
        return ApiResponse::error('Server error.', ['exception' => $e->getMessage()], 500);
    }
}

    public function destroy(WelcomeCall $welcomeCall)
    {
        $welcomeCall->delete();
        return redirect()->route('services.welcome-calls.index')->with('success', 'Deleted.');
    }

   
}