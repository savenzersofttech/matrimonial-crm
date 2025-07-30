@extends('layouts.sb2-layout')
@section('title', 'Sales Tracking')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Sales Activity
                        </h1>

                    </div>
                    {{-- <div class="col-12 col-xl-auto mt-4">
                            <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                                    placeholder="Select date range..." />
                            </div>
                        </div> --}}
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-n10">
        <div class="row">

            <div class="col-xxl-12 col-xl-12 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Recent Activity
                    </div>
                    <div class="card-body p-3">
                        <div class="timeline timeline-xs">
                            @forelse ($logs as $log)
                            <div class="timeline-item mb-2">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-text text-muted small">{{ $log['time_ago'] }}</div>
                                    <div class="timeline-item-marker-indicator {{ $log['color'] }}"></div>
                                </div>
                                <div class="timeline-item-content">{!! $log['message'] !!}</div>
                            </div>
                            @empty
                            <div class="text-muted small">No activity found.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="card mb-4">
            <div class="card-header">Table</div>
            <div class="card-body">
                <table id="simpleDatatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Notes</th>
                            <th>Outcome</th>
                           
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                           <th>Name</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Notes</th>
                            <th>Outcome</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($leadActivitys as $activity)
                        <tr>
                            <td>{{ $activity->lead->profile->name ?? 'N/A' }}</td>
                                                        <td>{{ $activity->created_at->format('d/m/Y h:i A') }}
</td>
                            <td>{{ $activity->type }}</td>
                            <td>{{ $activity->notes }}</td>
                            <td>{{ $activity->outcome ?? 'N/A' }}</td>
                            
                            <td>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark me-2">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <button class="btn btn-datatable btn-icon btn-transparent-dark">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</main>
@endsection
