@extends('layouts.sb2-layout')
@section('title', 'Assign Profiles to Employee')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Profiles
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->


    <div class="container-fluid px-4 mt-n10">
            <div class="card">
    <div class="card-header">
        <h4>Assign Profiles to Employee</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.assigns.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="employee_id">Select Employee</label>
                <select name="employee_id" class="virtualSelect" required>
                    <option value="">-- Select Employee --</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="profile_ids">Select Profiles</label>
                <select name="profile_ids[]" class="virtualSelect" multiple required>
                    @foreach ($profiles as $profile)
                        <option value="{{ $profile->id }}">{{ $profile->name }} - {{ $profile->email }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="note">Note (Optional)</label>
                <textarea name="note" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Assign</button>
        </form>
    </div>
</div>
</di>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2({
        placeholder: "Select profiles",
        allowClear: true
    });
</script>
@endpush
