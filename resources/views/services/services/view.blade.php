@extends('layouts.sb2-layout')

@section('title', 'Service History for Profile')

@section('content')
<main class="main-content p-4">
    <div class="container-fluid">
        <h4 class="mb-4">Service History - {{ $profile->name }} (ID: {{ $profile->id }})</h4>

        {{-- Profile Basic Info --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Profile Information
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $profile->name }}</p>
                <p><strong>Email:</strong> {{ $profile->email ?? 'N/A' }}</p>
                <p><strong>Mobile:</strong> {{ $profile->mobile ?? 'N/A' }}</p>
                <p><strong>Created On:</strong> {{ $profile->created_at->format('d M Y') }}</p>
            </div>
        </div>

        {{-- Service Plan History --}}
        <div class="card">
            <div class="card-header bg-dark text-white">
                Subscription Plan History
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Plan Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Added By</th>
                                <th>Updated By</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $index => $service)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $service->plan_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($service->start_date)->format('Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($service->end_date)->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($service->status == 'Active') bg-success 
                                            @elseif($service->status == 'Expiring Soon') bg-warning 
                                            @else bg-danger @endif">
                                            {{ $service->status }}
                                        </span>
                                    </td>
                                    <td>{{ $service->addedBy->name ?? 'N/A' }}</td>
                                    <td>{{ $service->updatedBy->name ?? 'N/A' }}</td>
                                    <td>{{ $service->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No service history found for this profile.</td>
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
