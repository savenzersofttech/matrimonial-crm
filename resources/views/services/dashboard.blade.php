@extends('layouts.sb2-layout')

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
                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-n10">

        <!-- Example Colored Cards for Dashboard Demo-->
        <div class="row">
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Total Payment Links</div>
                                <div class="text-lg fw-bold">{{ $totalPaymentLinks }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="link"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('services.payments.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Pending Payment Links</div>
                                <div class="text-lg fw-bold">{{ $totalPendingPaymentLinks }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="clock"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('services.payments.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Paid Payment Links</div>
                                <div class="text-lg fw-bold">{{ $totalPaidPaymentLinks }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="check-circle"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('services.payments.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Failed Payment Links</div>
                                <div class="text-lg fw-bold">{{ $totalFailedPaymentLinks }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="x-circle"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('services.payments.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Another row -->
        <div class="row">
           

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-secondary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Welcome Calls</div>
                                <div class="text-lg fw-bold">{{ $totalWelcomeCalls }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="phone"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('services.welcome-calls.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Follow Up Histories</div>
                                <div class="text-lg fw-bold">{{ $totalFollowUpHistories }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="repeat"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('admin.profiles.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-light text-dark h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-dark small">Total Services</div>
                                <div class="text-lg fw-bold">{{ $totalServices }}</div>
                            </div>
                            <i class="feather-xl text-muted" data-feather="tool"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('services.services.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Last row -->
        <div class="row">
           
             <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <a href="{{ route('admin.profiles.index') }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">Total Profiles</div>
                                    <div class="text-lg fw-bold">{{ $totalProfiles }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="users"></i>
                            </div>
                        </a>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('admin.profiles.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

                
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Leads</div>
                                <div class="text-lg fw-bold">{{ $totalLeads }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="user-plus"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="decorationA text-white stretched-link" href="{{ route('admin.profiles.index') }}">View Payment Links</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Example Charts for Dashboard Demo-->


    </div>
</main>
@endsection
