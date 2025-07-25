@extends('layouts.sb2-layout')

@section('title', 'Lead Assignments')

@section('content')
    <main>
        <!-- Page Header -->
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-fluid px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                All Lead Assignments
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container-fluid px-4 mt-n10">
            <div class="row">
                <!-- Dashboard Cards -->
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Total Leads</div>
                                <div class="text-lg fw-bold">{{ $totalLeads }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Assigned Leads</div>
                                <div class="text-lg fw-bold">{{ $assignedLeads }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="user-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">New Leads</div>
                                <div class="text-lg fw-bold">{{ $newLeads }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="plus-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Follow Ups</div>
                                <div class="text-lg fw-bold">{{ $followUps }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lead Assignment Table -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Lead Assignments</h4>
                    <a class="btn btn-success" href="{{ route('admin.lead_assignments.create') }}">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Lead Status</th>
                                <th>Assigned To</th>
                                <th>Assigned By</th>
                                <th>Note</th>
                                <th>Assigned At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $index => $assign)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $assign->profile->name ?? '-' }}</td>
                                    <td>
                                        @php
                                            $status = $assign['lead']['status'] ?? '-';
                                            $badgeClass = 'bg-secondary'; // default

                                            if ($status === 'New') {
                                                $badgeClass = 'bg-primary';
                                            } elseif ($status === 'Contacted') {
                                                $badgeClass = 'bg-info text-dark';
                                            } elseif ($status === 'Interested') {
                                                $badgeClass = 'bg-success';
                                            } elseif ($status === 'Not Interested') {
                                                $badgeClass = 'bg-danger';
                                            } elseif ($status === 'Follow Up') {
                                                $badgeClass = 'bg-warning text-dark';
                                            }
                                        @endphp
                                        <div class="badge {{ $badgeClass }} rounded-pill"> {{ $status }}</div>


                                    </td>
                                    <td>{{ $assign->assignedTo->name ?? '-' }}</td>
                                    <td>{{ $assign->assignedBy->name ?? '-' }}</td>
                                    <td>{{ $assign->note }}</td>
                                    <td>{{ $assign->created_at->format('d M Y h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
