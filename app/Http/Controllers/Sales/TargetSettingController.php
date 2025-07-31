<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesTarget;
use App\Models\User;
use Carbon\Carbon;

class TargetSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $salesTarget = SalesTarget::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($salesTarget->toArray());
        return view('sales.target.index', compact('salesTarget'));
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
