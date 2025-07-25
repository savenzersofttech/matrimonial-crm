@extends('layouts.sb2-layout')

@section('title', 'Add Ongoing Service')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="clock"></i></div>
                            Ongoing Services
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('services.services.store') }}">
                    @csrf
                    <div class="row">
                        {{-- Profile --}}
                        <div class="col-md-6 mb-3">
                            <label for="profile_id">Client Profile</label>
                            <select name="profile_id" class="form-control" required>
                                <option value="">Select Profile</option>
                                @foreach($profiles as $profile)
                                    <option value="{{ $profile->id }}"
                                        {{ old('profile_id') == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->name }} (ID: {{ $profile->id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                            {{-- Plan Type --}}
                            <div class="col-md-6 mb-3">
                                <label for="plan">Plan Type</label>
                                <select id="plan" name="plan" class="form-control" required>
                                    <option value="">Select Plan Type</option>
                                    @foreach($planTypes as $type)
                                        <option value="{{ $type['name'] }}"
                                            {{ old('plan') == $type['name'] ? 'selected' : '' }}>
                                            {{ $type['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" placeholder="Enter price">
                            </div>
                            @error('price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- Start Date --}}
                        <div class="col-md-4 mb-3">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date"
                                   value="{{ old('start_date') }}" class="form-control" required>
                        </div>

                        {{-- End Date --}}
                        <div class="col-md-4 mb-3">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date"
                                   value="{{ old('end_date') }}" class="form-control" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="end_date">Remarks </label>
                           <textarea name="remarks" class="form-control" placeholder="any note " rows="3">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection


@push('scripts')
<script>
    const planDurations = @json(array_column($planTypes, 'duration', 'name'));
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const planSelect = document.querySelector('[name="plan"]');
    const startDateInput = document.querySelector('[name="start_date"]');
    const endDateInput = document.querySelector('[name="end_date"]');

    // Set default start date to today (YYYY-MM-DD)
    const today = new Date().toISOString().split('T')[0];
    startDateInput.value = today;

    function calculateEndDate(startDate, duration) {
        const date = new Date(startDate);

        if (!duration || duration === 'unlimited' || duration === 'custom') {
            return '';
        }

        const durationParts = duration.split(' ');
        const amount = parseInt(durationParts[0]);
        const unit = durationParts[1];

        if (unit.includes('month')) {
            date.setMonth(date.getMonth() + amount);
        } else if (unit.includes('day')) {
            date.setDate(date.getDate() + amount);
        } else if (unit.includes('year')) {
            date.setFullYear(date.getFullYear() + amount);
        }

        return date.toISOString().split('T')[0];
    }

    function updateEndDate() {
        const selectedPlan = planSelect.value;
        const start = startDateInput.value;
        const duration = planDurations[selectedPlan] || '';

        if (!start || !duration) {
            endDateInput.value = '';
            return;
        }

        const calculated = calculateEndDate(start, duration);
        endDateInput.value = calculated;
    }

    planSelect.addEventListener('change', updateEndDate);
    startDateInput.addEventListener('change', updateEndDate);

    if (planSelect.value) {
        updateEndDate();
    }
});
</script>
@endpush
