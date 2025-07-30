@extends('layouts.sb2-layout')
@section('title', 'All Lead')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-fluid px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                Dashboard
                            </h1>
                          
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                                    placeholder="Select date range..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4 mt-n10">
            
            @php
    function getColorClass($status) {
        return match(strtolower($status)) {
            'new' => 'primary',
            'contacted' => 'info',
            'follow up' => 'warning',
            'qualified' => 'success',
            'not interested' => 'secondary',
            'lost' => 'dark',
            'converted' => 'success',
            default => 'light',
        };
    }
@endphp
             <div class="row mb-4">
    @foreach ($leadsByStatus as $status => $data)
        <div class="col-md-3">
            <div class="card text-white bg-{{ getColorClass($status) }} mb-3">
                <div class="card-body">
                    <h5 class="card-title text-capitalize">{{ str_replace('_', ' ', $status) }}</h5>
                    <p class="card-text fs-4">{{ $data->total }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
         

        </div>
    </main>
@endsection
