@extends('layouts.sb2-layout')
@section('title', 'Edit Role: ' . ucfirst(str_replace('-', ' ', $role->name)))

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Edit Role: {{ ucfirst(str_replace('-', ' ', $role->name)) }}</h4>
                    <a class="btn btn-primary" href="{{ route('admin.permissions.index') }}">
                        <i class="fas fa-arrow-left"></i> Back to Roles
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.permissions.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" readonly class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" placeholder="e.g., editor" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @php
                            $salesModules = ['sales-tracking', 'leads', 'target', 'followup', 'tasks', 'sales-report'];
                            $groupedSales = [];
                            $groupedServices = [];
                            $actionLabels = ['List', 'View', 'Edit', 'Delete'];

                            foreach ($permissions as $section => $perms) {
                                $moduleName = ucwords(str_replace('-', ' ', $section));
                                foreach ($perms as $perm) {
                                    $parts = explode('.', $perm->name);
                                    if (count($parts) === 2) {
                                        $action = ucfirst($parts[0]);
                                        if (in_array($section, $salesModules)) {
                                            $groupedSales[$moduleName][$action] = $perm;
                                        } else {
                                            $groupedServices[$moduleName][$action] = $perm;
                                        }
                                    }
                                }
                            }
                        @endphp

                        {{-- Global Select All --}}
                        <div class="m-4">
                            <div>
                                <input type="checkbox" id="select_all_global" class="form-check-input me-2">
                                <label for="select_all_global">Select All Permissions</label>
                            </div>
                        </div>

                        {{-- Sales Table --}}
                        <h5 class="mt-4 text-primary">Sales Permissions</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center align-middle table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">Module</th>
                                        @foreach ($actionLabels as $label)
                                            <th>{{ $label }}</th>
                                        @endforeach
                                        <th>Select All</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedSales as $module => $actions)
                                        @php $slug = \Illuminate\Support\Str::slug($module); @endphp
                                        <tr>
                                            <td class="text-start">{{ $module }}</td>
                                            @foreach ($actionLabels as $type)
                                                <td>
                                                    @if (isset($actions[$type]))
                                                        @php
                                                            $perm = $actions[$type];
                                                            $checked = $role->permissions->contains('name', $perm->name) || in_array($perm->name, old('permissions', []));
                                                        @endphp
                                                        <input type="checkbox"
                                                               class="form-check-input permission-checkbox module-{{ $slug }}"
                                                               name="permissions[]"
                                                               value="{{ $perm->name }}"
                                                               {{ $checked ? 'checked' : '' }}>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                <input type="checkbox"
                                                       class="form-check-input select-all-module"
                                                       data-module="{{ $slug }}"
                                                       {{ $role->permissions->whereIn('name', collect($actions)->pluck('name'))->count() === count($actions) ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Services Table --}}
                        <h5 class="mt-5 text-success">Services Permissions</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center align-middle table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">Module</th>
                                        @foreach ($actionLabels as $label)
                                            <th>{{ $label }}</th>
                                        @endforeach
                                        <th>Select All</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedServices as $module => $actions)
                                        @php $slug = \Illuminate\Support\Str::slug($module); @endphp
                                        <tr>
                                            <td class="text-start">{{ $module }}</td>
                                            @foreach ($actionLabels as $type)
                                                <td>
                                                    @if (isset($actions[$type]))
                                                        @php
                                                            $perm = $actions[$type];
                                                            $checked = $role->permissions->contains('name', $perm->name) || in_array($perm->name, old('permissions', []));
                                                        @endphp
                                                        <input type="checkbox"
                                                               class="form-check-input permission-checkbox module-{{ $slug }}"
                                                               name="permissions[]"
                                                               value="{{ $perm->name }}"
                                                               {{ $checked ? 'checked' : '' }}>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                <input type="checkbox"
                                                       class="form-check-input select-all-module"
                                                       data-module="{{ $slug }}"
                                                       {{ $role->permissions->whereIn('name', collect($actions)->pluck('name'))->count() === count($actions) ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        document.getElementById('select_all_global').addEventListener('change', function() {
            document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            document.querySelectorAll('.select-all-module').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.querySelectorAll('.select-all-module').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const module = this.getAttribute('data-module');
                document.querySelectorAll(`.module-${module}`).forEach(permCheckbox => {
                    permCheckbox.checked = this.checked;
                });
            });
        });

        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const module = this.classList.value.match(/module-([^\s]+)/)[1];
                const moduleCheckboxes = document.querySelectorAll(`.module-${module}`);
                const selectAllCheckbox = document.querySelector(`.select-all-module[data-module="${module}"]`);
                selectAllCheckbox.checked = Array.from(moduleCheckboxes).every(cb => cb.checked);
            });
        });
    </script>
@endpush