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
                            Roles
                        </h1>

                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-n10">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="mb-0">All Roles</h4>
                        <a class="btn btn-success" href="{{ route('admin.permissions.create') }}">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="simpleDatatable">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Role</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Role</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                  @foreach ($roles as $index => $role)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ ucfirst(str_replace('-', ' ', $role->name)) }}</td>
                                        <td>
                                           {{ count($role->permissions)}}
                                        </td>
                                        <td>
                                        @if($role->name !='super-admin')
                                            <a href="{{ route('admin.permissions.edit', $role) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                         <a  class="btn btn-danger btn-sm">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                           
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
