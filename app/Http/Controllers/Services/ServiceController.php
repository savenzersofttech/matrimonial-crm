<?php
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentLink;
use Carbon\Carbon;

class ServiceController extends Controller
{

    //uisng PaymentLink  table data 
    public function index()
    {
        $services = PaymentLink::with(['profile:id,name', 'package:id,name'])
            ->where('status', 'Paid')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->get();

            // dd('', $services->toArray());
        return view('services.services.index', compact('services'));
    }

    

}
