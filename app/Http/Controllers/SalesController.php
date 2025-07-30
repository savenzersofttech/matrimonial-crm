<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class SalesController extends Controller
{
    public function index()
    {
        // Grouped counts by status
        $leadsByStatus = Lead::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        // Or if you want all leads categorized by status
        $leads = Lead::all()->groupBy('status');
        // dd($leadsByStatus->toArray());
        return view('sales.dashboard', [
            'leadsByStatus' => $leadsByStatus,
            'leads' => $leads
        ]);
    }
}
