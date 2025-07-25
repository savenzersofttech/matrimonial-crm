@extends('layouts.main')
@section('title', 'View Welcome Call')

@section('content')
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Welcome Call Details</h4>
            <a href="{{ route('services.welcome-calls.index') }}" class="btn btn-secondary float-right">Back to List</a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Details -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Profile Information</h5>
                    <p><strong>Name:</strong> {{ $welcomeCall->profile->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $welcomeCall->profile->email ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $welcomeCall->profile->phone ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Call History -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Call History</h5>
                    @forelse($welcomeCall->followUpHistories->sortByDesc('follow_up_date')->sortByDesc('created_at') as $history)
                        <div class="card mb-2">
                            <div class="card-body">
                                <p><strong>Date & Time:</strong> {{ date('d-m-Y H:i', strtotime($history->follow_up_date)) }}</p>
                                <p><strong>Employee:</strong> {{ $history->employee->name ?? 'N/A' }}</p>
                                <p><strong>Status:</strong> <span class="badge bg-{{ getStatusClass($history->status) }}">{{ $history->status }}</span></p>
                                <p><strong>Comment:</strong> {{ $history->comment ?? 'N/A' }}</p>
                                <p><strong>Days Ago:</strong> {{ now()->diffInDays($history->follow_up_date) }} days</p>
                            </div>
                        </div>
                    @empty
                        <p>No call history available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Actions -->
            <a href="{{ route('services.welcome-calls.edit', $welcomeCall->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('services.welcome-calls.destroy', $welcomeCall->id) }}" method="POST" style="display:inline-block; margin-left: 10px;" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@php
function getStatusClass($status) {
    return match($status) {
        'Interested' => 'success',
        'Follow-up Needed' => 'warning',
        'No Response' => 'danger',
        'Not Interested' => 'secondary',
        default => 'light',
    };
}
@endphp