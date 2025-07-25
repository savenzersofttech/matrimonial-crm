<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\MotherTongue;
class ProfileSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tounges = MotherTongue::all();
        return view('services.reports.index', compact('tounges'));
    }

  public function search(Request $request)
{
    $query = Profile::query();

    // Full Name (partial match)
    if ($request->filled('name') && $request->name !== '0') {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // Gender
    if ($request->filled('gender') && $request->gender !== '0') {
        $query->where('gender', $request->gender);
    }

    // Marital Status
    if ($request->filled('marital_status') && $request->marital_status !== '0') {
        $query->where('marital_status', $request->marital_status);
    }

    // Age Range
    if ($request->filled('age_min') && $request->age_min !== '0') {
        $query->whereDate('dob', '<=', now()->subYears($request->age_min));
    }
    if ($request->filled('age_max') && $request->age_max !== '0') {
        $query->whereDate('dob', '>=', now()->subYears($request->age_max));
    }

    // Height Range
    if ($request->filled('height_min') && $request->height_min !== '0') {
        $query->where('height', '>=', $request->height_min);
    }
    if ($request->filled('height_max') && $request->height_max !== '0') {
        $query->where('height', '<=', $request->height_max);
    }

    // Religion
    if ($request->filled('religion') && $request->religion !== '0') {
        $query->where('religion', $request->religion);
    }

    // Community
    if ($request->filled('community') && $request->community !== '0') {
        $query->where('community', $request->community);
    }

    // Mother Tongue
    if ($request->filled('mother_tongue') && $request->mother_tongue !== '0') {
        $query->whereJsonContains('mother_tongue', $request->mother_tongue);
    }

    // Manglik Status
    if ($request->filled('manglik_status') && $request->manglik_status !== '0') {
        $query->where('manglik_status', $request->manglik_status);
    }

    // Education Level
    if ($request->filled('education_level') && $request->education_level !== '0') {
        $query->where('education_level', $request->education_level);
    }

    // Education Field
    if ($request->filled('education_field') && $request->education_field !== '0') {
        $query->where('education_field', $request->education_field);
    }

    // Job Sector
    if ($request->filled('job_sector') && $request->job_sector !== '0') {
        $query->where('job_sector', $request->job_sector);
    }

    // Annual Income
    if ($request->filled('annual_income') && $request->annual_income !== '0') {
        $query->where('annual_income', $request->annual_income);
    }

    // Country
    if ($request->filled('country') && $request->country !== '0') {
        $query->where('country', $request->country);
    }

    // State
    if ($request->filled('state') && $request->state !== '0') {
        $query->where('state', 'like', '%' . $request->state . '%');
    }

    // City
    if ($request->filled('city') && $request->city !== '0') {
        $query->where('city', 'like', '%' . $request->city . '%');
    }

    // Final result
    $profiles = $query->get();

    return response()->json([
        'data' => $profiles
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
