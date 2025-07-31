@extends('layouts.sb2-layout')
@section('title', 'Target Setting')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            My Sales Targets
                        </h1>

                    </div>
                    
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
                        Progress Tracker
                       
                    </div>

                    
                    @php
                    function getProgressColor($value) {
                    if ($value < 40) return 'bg-danger' ; if ($value < 70) return 'bg-warning' ; if ($value < 90) return 'bg-info' ; return 'bg-success' ; } @endphp @foreach ($salesTarget as $target) @php $progressContacted=$target->contacted_lead > 0 ? round(($target->achieved / $target->contacted_lead) * 100) : 0;
                        $progressConverted = $target->converted_lead > 0 ? round(($target->achieved / $target->converted_lead) * 100) : 0;
                        $progressRevenue = $target->revenue > 0 ? round(($target->achieved / $target->revenue) * 100) : 0;
                        @endphp

                        <div class="cxard mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Sales Target: {{ $target->period }} ({{ $target->start_date }} to {{ $target->end_date }})</h5>

                                <h6 class="small">Leads Contacted <span class="float-end fw-bold">{{ $progressContacted }}%</span></h6>
                                <div class="progress mb-3">
                                    <div class="progress-bar {{ getProgressColor($progressContacted) }}" role="progressbar" style="width: {{ $progressContacted }}%" aria-valuenow="{{ $progressContacted }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <h6 class="small">Leads Converted <span class="float-end fw-bold">{{ $progressConverted }}%</span></h6>
                                <div class="progress mb-3">
                                    <div class="progress-bar {{ getProgressColor($progressConverted) }}" role="progressbar" style="width: {{ $progressConverted }}%" aria-valuenow="{{ $progressConverted }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <h6 class="small">Revenue Generated <span class="float-end fw-bold">{{ $progressRevenue }}%</span></h6>
                                <div class="progress mb-1">
                                    <div class="progress-bar {{ getProgressColor($progressRevenue) }}" role="progressbar" style="width: {{ $progressRevenue }}%" aria-valuenow="{{ $progressRevenue }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                       
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Target History</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Time Period</th>
                                <th>Target</th>
                                <th>Achieved</th>
                                <th>Progress</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($salesTarget as $target)
                            {{-- Leads Contacted --}}
                            <tr>
                                <td>Leads Contacted</td>
                                <td>{{ $target->period }}</td>
                                <td>{{ $target->contacted_lead }}</td>
                                <td>{{ $target->achieved }}</td> {{-- Or a separate contacted_achieved if you have --}}
                                @php
                                $progress = $target->contacted_lead > 0 ? round(($target->achieved / $target->contacted_lead) * 100) : 0;
                                @endphp
                                <td><span class="badge bg-warning text-dark">{{ $progress }}%</span></td>
                                <td>{{ \Carbon\Carbon::parse($target->start_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($target->end_date)->format('Y-m-d') }}</td>
                            </tr>

                            {{-- Leads Converted --}}
                            <tr>
                                <td>Leads Converted</td>
                                <td>{{ $target->period }}</td>
                                <td>{{ $target->converted_lead }}</td>
                                <td>{{ $target->achieved }}</td> {{-- Adjust if tracking separately --}}
                                @php
                                $progress = $target->converted_lead > 0 ? round(($target->achieved / $target->converted_lead) * 100) : 0;
                                @endphp
                                <td><span class="badge bg-warning text-dark">{{ $progress }}%</span></td>
                                <td>{{ \Carbon\Carbon::parse($target->start_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($target->end_date)->format('Y-m-d') }}</td>
                            </tr>

                            {{-- Revenue Generated --}}
                            <tr>
                                <td>Revenue Generated</td>
                                <td>{{ $target->period }}</td>
                                <td>{{ number_format($target->revenue) }}</td>
                                <td>{{ number_format($target->achieved) }}</td> {{-- Adjust if tracking separately --}}
                                @php
                                $progress = $target->revenue > 0 ? round(($target->achieved / $target->revenue) * 100) : 0;
                                @endphp
                                <td><span class="badge bg-warning text-dark">{{ $progress }}%</span></td>
                                <td>{{ \Carbon\Carbon::parse($target->start_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($target->end_date)->format('Y-m-d') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No sales targets found.</td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


    </div>
</main>
@endsection
