@extends('layouts.sb2-layout')
@section('title', 'Assign Leads')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <h1 class="text-white">Assign Leads</h1>
                </div>
            </div>
        </header>

        <div class="container-fluid px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Assign Leads to Employee</h4>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a class="btn btn-success" href="{{ route('admin.lead_assignments.index') }}">
                            <i class="fa fa-arrow"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-header">

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.lead_assignments.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="profile_ids" class="form-label">Select Profiles</label>
                            <select name="profile_ids[]" id="profile_ids" class="form-control select2" multiple required>
                                @foreach ($profiles as $profile)
                                    <option value="{{ $profile->id }}"
                                        {{ in_array($profile->id, old('profile_ids', [])) ? 'selected' : '' }}>
                                        {{ $profile->name }}
                                    </option>
                                @endforeach

                            </select>
                            @error('profile_ids')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assign To (Employee)</label>
                            <select name="assigned_to" id="assigned_to" class="form-control" required>
                                <option value="">-- Select Employee --</option>
                                @foreach ($employees as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Assignment Note</label>
                            <textarea name="note" id="note" rows="3" class="form-control">{{ old('note') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Assign Leads</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <!-- Include select2 JS if not already included -->
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select Profiles',
                width: '100%'
            });
        });
    </script>
@endpush
