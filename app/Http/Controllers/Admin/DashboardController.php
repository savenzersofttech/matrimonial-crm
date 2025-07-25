<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\PaymentLink;
use App\Models\Profile;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalLeads = Lead::count();
        $totalPaymentLinks = PaymentLink::count();
        $totalProfiles = Profile::count(); // Optional

        return view('admin.dashboard', compact('totalEmployees', 'totalLeads', 'totalPaymentLinks', 'totalProfiles'));
    }
}
