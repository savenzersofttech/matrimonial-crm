<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Profile;
use App\Models\WelcomeCall;
use App\Models\FollowUpHistory;
use App\Models\Service;
use App\Models\PaymentLink;
use App\Models\Package;
use App\Models\Lead;

class ServicesController extends Controller
{
 public function dashboard()
{
    $totalPaymentLinks = PaymentLink::count();
    $totalPendingPaymentLinks = PaymentLink::where('status', 'Pending')->count();
    $totalPaidPaymentLinks = PaymentLink::where('status', 'Paid')->count();
    $totalFailedPaymentLinks = PaymentLink::where('status', 'Failed')->count();

    $totalProfiles = Profile::count();
    $totalWelcomeCalls = WelcomeCall::count();
    $totalFollowUpHistories = FollowUpHistory::count();
    $totalServices = Service::count();
    $totalPackages = Package::count();
    $totalLeads = Lead::count();

    return view('services.dashboard', compact(
        'totalPaymentLinks',
        'totalPendingPaymentLinks',
        'totalPaidPaymentLinks',
        'totalFailedPaymentLinks',
        'totalProfiles',
        'totalWelcomeCalls',
        'totalFollowUpHistories',
        'totalServices',
        'totalPackages',
        'totalLeads'
    ));
}

}
