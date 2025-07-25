@extends('layouts.sb2-layout')
@section('title', 'All Leads')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-fluid px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                Leads
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Leads</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                        <i class="fas fa-plus"></i> Add New
                    </button>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($leads as $lead)
                                <tr>
                                    <td>{{ $lead['profile']['name'] ?? '-' }}</td>
                                    <td>{{ $lead['profile']['email'] ?? '-' }}</td>
                                    <td>{{ $lead['profile']['phone'] ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lead['created_at'])->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($lead['status']);
                                            $badgeClass = match($status) {
                                                'new' => 'bg-primary',
                                                'follow-up' => 'bg-warning text-dark',
                                                'converted' => 'bg-success',
                                                'lost' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $lead['status'] ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i
                                                class="fa-solid fa-ellipsis-vertical"></i></button>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark"><i
                                                class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No leads found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
