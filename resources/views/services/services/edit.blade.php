@extends('layouts.sb2-layout')
@section('title', 'Edit Ongoing Service')

@section('content')
<main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="clock"></i></div>
                            Edit
                        </h1>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid px-4 mt-n10">
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('services.services.update', $service->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Client Profile (Read only) --}}
                    <div class="col-md-6 mb-3">
                        <label for="profile_id">Client Profile</label>
                        <select class="form-control" disabled>
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}" {{ $profile->id == $service->profile_id ? 'selected' : '' }}>
                                    {{ $profile->name }} (ID: {{ $profile->id }})
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="profile_id" value="{{ $service->profile_id }}">
                    </div>

                    {{-- Plan --}}
                    <div class="col-md-6 mb-3">
                        <label for="plan">Plan Type</label>
                        <select name="plan" id="plan" class="form-control" required>
                            <option value="">-- Select Plan --</option>
                            @foreach($planTypes as $option)
                                <option value="{{ $option['name'] }}" {{ (old('plan', $service->plan) == $option['name']) ? 'selected' : '' }}>
                                    {{ $option['name'] }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-6 mb-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                               value="{{ old('start_date', \Carbon\Carbon::parse($service->start_date)->format('Y-m-d')) }}" required>
                    </div>

                    {{-- End Date --}}
                    <div class="col-md-6 mb-3">
                        <label for="end_date">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                               value="{{ old('end_date', \Carbon\Carbon::parse($service->end_date)->format('Y-m-d')) }}" readonly>
                    </div>

                    {{-- Cost --}}
                    <div class="col-md-6 mb-3">
                        <label for="price">Price <small class="text-muted">(Rs)</small></label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="price" class="form-control" step="0.01"
                                   value="{{ old('price', $service->price) }}" required>
                        </div>
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">-- Select Status --</option>
                            @foreach($statuses as $key => $value)
                                <option value="{{ $key }}" {{ old('status', $service->status) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Remarks --}}
                    <div class="col-md-6 mb-3">
                        <label for="remarks">Remarks</label>
                         <textarea name="remarks" class="form-control" placeholder="any note " rows="3">{{ old('remarks', $service->remarks) }}</textarea>
                    </div>
                </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Update Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>
@endsection

@section('scripts')
<script>
    const planDurations = @json(array_column($planTypes, 'duration', 'name'));

    document.addEventListener("DOMContentLoaded", function () {
        const planSelect = document.getElementById('plan');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        function calculateEndDate(startDate, duration) {
            if (!duration || duration === 'unlimited') return '';

            const date = new Date(startDate);
            const [amount, unit] = duration.split(' ');

            const value = parseInt(amount);
            if (unit.includes('month')) {
                date.setMonth(date.getMonth() + value);
            } else if (unit.includes('day')) {
                date.setDate(date.getDate() + value);
            } else if (unit.includes('year')) {
                date.setFullYear(date.getFullYear() + value);
            }

            return date.toISOString().split('T')[0];
        }

        function updateEndDate() {
            const plan = planSelect.value;
            const start = startDateInput.value;
            const duration = planDurations[plan];

            if (!start || !duration) return;
            endDateInput.value = calculateEndDate(start, duration);
        }

        planSelect.addEventListener('change', updateEndDate);
        startDateInput.addEventListener('change', updateEndDate);

        // Trigger once on page load
        updateEndDate();
    });
</script>
@endsection
