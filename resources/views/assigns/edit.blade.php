@extends('layouts.main')

@section('title', 'Edit Profile Assignment')

@section('content')
<div class="section-body">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h4>Edit Assignment: {{ $assignment->profile->name ?? 'N/A' }}</h4>
            <a href="{{ route('admin.assigns.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.assigns.update', $assignment->id) }}" method="POST">
                @csrf
                @method('PUT')

               

                <div class="form-group mb-3">
                    <label for="profile_ids">Select Profiles <span class="text-danger">*</span></label>
                   <select name="profile_id" id="profile_id" class="form-control select2" required>
    @foreach ($profiles as $profile)
        <option value="{{ $profile->id }}"
            {{ $profile->id == $assignment->profile_id ? 'selected' : '' }}>
            {{ $profile->name }} ({{ $profile->email ?? 'No Email' }})
        </option>
    @endforeach
</select>

                </div>


                <div class="form-group mb-3">
                    <label for="employee_id">Employee <span class="text-danger">*</span></label>
                    <select name="employee_id" id="employee_id" class="form-control" required>
                        <option value="">-- Select Employee --</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $assignment->employee_id == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }} ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="note">Note (optional)</label>
                    <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $assignment->note) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Assignment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#profile_id').select2({
                placeholder: "Select a profile",
                width: '100%'
            });
        });
    </script>
@endpush
