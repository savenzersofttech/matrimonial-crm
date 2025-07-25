@extends('layouts.sb2-layout')
@section('title', 'Dashboard')

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
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4 mt-n10">

            <div class="row">
    <div class="col-lg-6 col-xl-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Total Employees</div>
                        <div class="text-lg fw-bold">{{ $totalEmployees }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Total Leads</div>
                        <div class="text-lg fw-bold">{{ $totalLeads }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="trending-up"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-3 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Payment Links</div>
                        <div class="text-lg fw-bold">{{ $totalPaymentLinks }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="link"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-3 mb-4">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white-75 small">Total Profiles</div>
                        <div class="text-lg fw-bold">{{ $totalProfiles }}</div>
                    </div>
                    <i class="feather-xl text-white-50" data-feather="user"></i>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </main>
@endsection
