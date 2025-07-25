@extends('layouts.sb2-layout')
@section('title', 'Edit Lead Assignment')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <h1 class="text-white">Edit Lead Assignment</h1>
            </div>
        </div>
    </header>

    <div class="container-fluid px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="mb-0">Update Lead Assignment</h4>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a class="btn btn-success" href="{{ route('admin.lead_assignments.index') }}">
                        <i class="fa fa-arrow"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.lead_assignments.update', $leadAssignment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="profile_ids" class="form-label">Select Profile</label>
                        <select name="profile_ids[]" id="profile_ids" class="form-control select2" multiple required>
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}"
                                    @if(in_array($profile->id, [$leadAssignment->lead->profile_id]))
                                        selected
                                    @endif
                                >{{ $profile->name }}</option>
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
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $leadAssignment->assigned_to == $user->id ? 'selected' : '' }}>
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
                        <textarea name="note" id="note" rows="3" class="form-control">{{ old('note', $leadAssignment->note) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Assignment</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'Select Profiles',
            width: '100%'
        });
    });
</script>
@endpush
