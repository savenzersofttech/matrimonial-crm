@extends('layouts.main')

@section('title', 'Assign/Update Profile to Employee')

@section('content')
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>{{ $existingAssignment ? 'Update Assignment' : 'Assign Profile' }}: {{ $profile->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profiles.assign.store', $profile->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="employee_id">Select Employee <span class="text-danger">*</span></label>
                    <select name="employee_id" id="employee_id" class="form-control" required>
                        <option value="">-- Select --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ old('employee_id', $existingAssignment?->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }} ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="note">Note (optional)</label>
                    <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $existingAssignment?->note) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ $existingAssignment ? 'Update Assignment' : 'Assign Now' }}
                </button>
                <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
