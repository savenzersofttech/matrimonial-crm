<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCountries()
    {
        return Country::select('id','name')->orderBy('name')->get();
    }

    public function getStates(Request $request)
    {
        $countryId = $request->get('country_id');
        return State::where('country_id', $countryId)
            ->select('id','name')
            ->orderBy('name')
            ->get();
    }

    public function getCities(Request $request)
    {
        $stateId = $request->get('state_id');
        return City::where('state_id', $stateId)
            ->select('id','name')
            ->orderBy('name')
            ->get();
    }
}
