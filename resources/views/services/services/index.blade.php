@extends('layouts.sb2-layout')

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
                    {{-- <div class="col-12 col-xl-auto mt-4">
                        <form action="{{ route('services.services.index') }}" method="GET" class="d-flex gap-2">
                            <input name="client" class="form-control" type="text" placeholder="Client Name" value="{{ request('client') }}">
                            <select name="plan" class="form-select">
                                <option value="">All Plans</option>
                                <option value="Basic" {{ request('plan') == 'Basic' ? 'selected' : '' }}>Basic</option>
                                <option value="Premium" {{ request('plan') == 'Premium' ? 'selected' : '' }}>Premium</option>
                            </select>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Expiring Soon" {{ request('status') == 'Expiring Soon' ? 'selected' : '' }}>Expiring Soon</option>
                                <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                            <button type="submit" class="btn btn-light">Filter</button>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>All Ongoing Services</span>
                
            </div>

            <div class="card-body">
                <table id="datatableTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Profile</th>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th>Updated By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $index => $service)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $service->profile->name ?? 'N/A' }}</td>
                            <td>{{ $service->plan }}</td>
                            <td>₹{{ $service->price }}</td>
                            <td>{{ \Carbon\Carbon::parse($service->start_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($service->end_date)->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge bg-{{ getStatusClass($service->status) }}">{{ $service->status }}</span>
                            </td>
                            <td>{{ $service->addedBy->name ?? '-' }}</td>
                            <td>{{ $service->updatedBy->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('services.services.history', $service->id) }}" class="btn btn-sm ">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('services.services.edit', $service->id) }}" class="btn btn-sm ">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('services.services.destroy', $service->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm ">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No ongoing services found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@php
function getStatusClass($status)
{
    return match ($status) {
        'Active' => 'success',
        'Expiring Soon' => 'warning',
        'Expired' => 'danger',
        default => 'secondary',
    };
}
@endphp

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const datatableTable = document.getElementById('datatableTable');
        if (datatableTable) {
            new simpleDatatables.DataTable(datatableTable);
        }
    });
</script>
@endpush
