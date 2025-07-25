@extends('layouts.main')
@section('title', 'Edit Welcome Call')

@section('content')
<div class="section-body">
    <div class="container-fluid px-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Welcome Call</h4>
            </div>
            <div class="card-body">
                <!-- Profile Details -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Profile Information</h5>
                        <div class="row">
                            <div class="col-md-4"><strong>Name:</strong> {{ $welcomeCall->profile->name ?? 'N/A' }}</div>
                            <div class="col-md-4"><strong>Email:</strong> {{ $welcomeCall->profile->email ?? 'N/A' }}</div>
                            <div class="col-md-4"><strong>Phone:</strong> {{ $welcomeCall->profile->phone ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

            <!-- New Follow-up Form -->
                <form action="{{ route('services.welcome-calls.update', $welcomeCall->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="follow_up_date" class="form-label">Follow-up Date & Time</label>
                            <input type="text" class="form-control datetimepicker" id="follow_up_date" name="follow_up_date"
                                value="{{ old('follow_up_date', now()->format('Y-m-d\TH:i')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Select Status --</option>
                                @foreach(['Interested', 'Follow-up Needed', 'No Response', 'Not Interested'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $welcomeCall->status) === $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required>{{ old('comment') }}</textarea>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Log New Follow-up</button>
                            <a href="{{ route('services.welcome-calls.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>

               <!-- Follow-up History (Compact) -->
                <div class="card mt-5">
                    <div class="card-body p-3">
                        <h5 class="mb-3 text-primary fw-bold">Follow-up History</h5>

                        @forelse($welcomeCall->followUpHistories->sortByDesc('follow_up_date') as $history)
                            @php
                                $followUp = \Carbon\Carbon::parse($history->follow_up_date)->format('d-m-Y H:i');
                                $created = \Carbon\Carbon::parse($history->created_at)->format('d-m-Y H:i');
                                $classes = getStatusClass($history->status);
                            @endphp

                            <div class="border rounded px-3 py-2 mb-2 small bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span><strong>Status:</strong></span>
                                    <span class="badge {{ $classes['bg'] }} {{ $classes['text'] }}">{{ $history->status }}</span>
                                </div>
                                <div><strong>Comment:</strong> {{ $history->comment ?? 'N/A' }}</div>
                                <div><strong>Follow-up:</strong> {{ $followUp }}</div>
                                <div><strong>Created:</strong> {{ $created }}</div>
                            </div>
                        @empty
                            <p class="text-muted">No follow-up history available.</p>
                        @endforelse
                    </div>
                </div>


                

            </div>
        </div>
    </div>
</div>
@endsection

@php
function getStatusClass($status) {
    return match($status) {
        'Interested' => ['bg' => 'bg-success', 'text' => 'text-white'],
        'Follow-up Needed' => ['bg' => 'bg-warning', 'text' => 'text-dark'],
        'No Response' => ['bg' => 'bg-danger', 'text' => 'text-white'],
        'Not Interested' => ['bg' => 'bg-secondary', 'text' => 'text-white'],
        default => ['bg' => 'bg-light', 'text' => 'text-dark'],
    };
}
@endphp
