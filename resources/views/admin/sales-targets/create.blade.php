@extends('layouts.app')

@section('content')
<h2>Assign Sales Target</h2>
<form method="POST" action="{{ route('admin.sales-targets.store') }}">
    @csrf
    <div class="mb-3">
        <label>User</label>
        <select name="user_id" class="form-control" required>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="Contacted">Contacted</option>
            <option value="Converted">Converted</option>
            <option value="Revenue">Revenue</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Target</label>
        <input type="number" name="target" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Time Period</label>
        <input type="text" name="time_period" class="form-control" placeholder="Monthly/Quarterly" required>
    </div>

    <div class="mb-3">
        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>End Date</label>
        <input type="date" name="end_date" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Assign Target</button>
</form>
@endsection
