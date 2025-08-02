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
                            <th>Discount</th>
                            <th>Payable</th>
                            <th>Period</th>
                            <th>Expire In</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th>Updated By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $index => $service)
                          @php
                            
                            $start = \Carbon\Carbon::parse($service->start_date);
                            $end = \Carbon\Carbon::parse($service->end_date);
                            $today = now();
                            $isActive = "Expired";
                                if ($today->lt($start)) {
                                    $isActive = 'Upcoming'; 
                                } elseif ($today->between($start, $end)) {
                                    $isActive = 'Active'; 
                                } else {
                                    $isActive = 'Expired'; 
                                }

                            $diff = $end->diffInDays($today, false); // false = signed (future = negative)
                            $days = round(abs($diff));

                            if ($diff < 0) {
                                $expiryText = "$days days";
                                $textClass = 'success';
                            } elseif ($diff === 0) {
                                $expiryText = 'Expires today';
                                $textClass = 'warning';
                            } else {
                                $expiryText = "$days days ago";
                                $textClass = 'danger';
                            }
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><a target="_blank" href="{{ route('admin.profiles.show', $service->profile->id) }}" class="fw-bold text-blue">{{ $service->profile->name}}</a></td>
                            <td>{{ $service->package->name }}</td>
                            <td>{{ getCurrencySymbol($service->currency) }}{{ $service->price }}</td>
                            <td>{{ $service->discount ?? 0 }}%</td>
                            <td><p class="fw-bold text-dark">{{ getCurrencySymbol($service->currency) }}{{ $service->final_amount }}</p></td>


                         

                            <td>
                                <div>{{ $start->format('d-m-Y') }}</br> {{ $end->format('d-m-Y') }}</div>
                             
                            </td>
                            <td>
                                <span class="badge bg-{{ $textClass }}">{{ $expiryText }}</span>
                            </td>

                            <td>
                                <span class="badge bg-{{ getStatusClass($isActive) }}">{{ $isActive }}</span>
                            </td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-{{ getStatusClass($isActive) }} ">
                                    @if($isActive == 'Expired')
                                        <i class="fa fa-refresh me-1"></i> Renew
                                    @else
                                    <i class="fa fa-lock me-1"></i> Lock
                                    @endif
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No ongoing services found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                   
                </div>
            </div>
        </div>
    </div>
</main>
@endsection



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
