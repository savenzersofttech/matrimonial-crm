<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchSendProfilesController extends Controller
{
    public function index()
    {
        return view('services.reports.index');
    }

    public function create()
    {
        return view('services.reports.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('services.reports.index')->with('success', 'Profile created.');
    }

    public function show($id)
    {
        return view('services.reports.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('services.profile-reports-edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('services.reports.index')->with('success', 'Profile updated.');
    }

    public function destroy($id)
    {
        return redirect()->route('services.reports.index')->with('success', 'Profile deleted.');
    }
}