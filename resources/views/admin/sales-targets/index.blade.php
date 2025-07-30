@extends('layouts.sb2-layout')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="target"></i></div>
                            Sales Targets
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Sales Targets</span>
                <button type="button" class="addBtn btn btn-sm btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>User</th>
                                <th>Leads Contacted</th>
                                <th>Leads Converted</th>
                                <th>Revenue (₹)</th>
                                <th>Month</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="FormModalgx" tabindex="-1" aria-labelledby="FormModalgxLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="regForm" method="POST" action="{{ route('admin.sales-targets.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="FormModalgxLabel">Create Sales Target</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select name="user_id" id="user_id" class="virtualSelect after-parent" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="month" class="form-label">Month</label>
                            <input type="text" name="period" class="form-control after-parent" id="period" value="" required>
                        </div>

                        <div class="row">

                             <div class="col-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" placeholder="Start Date" class="form-control after-parent"
                            id="start_date" required>
                        </div>

                        <div class="col-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" placeholder="End Date" class="form-control after-parent"
                            id="end_date" required>
                        </div>
                        </div>

                        <div class="mb-3">
                            <label for="contacted_lead" class="form-label">Leads Contacted</label>
                            <input type="number" name="contacted_lead" id="contacted_lead" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="converted_lead" class="form-label">Leads Converted</label>
                            <input type="number" name="converted_lead" id="converted_lead" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="revenue" class="form-label">Revenue Target (₹)</label>
                            <input type="number" name="revenue" id="revenue" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    let configration;
    const updateUrl = @json(route('admin.sales-targets.update', ['sales_target' => '__ID__']));

    document.addEventListener("DOMContentLoaded", function () {
        validationConfig['ignore'] = [];

        configration = {
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.sales-targets.showAll.api') }}",
                type: 'POST'
            },
            columns: [
                { data: 's_no' },
                { data: 'user.name' },
                { data: 'leads_contacted' },
                { data: 'leads_converted' },
                { data: 'revenue_target' },
                { data: 'month' },
                {
                    data: 'id',
                    render: function (id, t, row) {
                        tableData[id] = row;
                        return `
                            <button type="button" onclick="openEditModal(${id}, this, event)" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" onclick="deleteConfirmation(this)" data-id="${id}" data-href="{{ route('admin.sales-targets.destroy', ':id') }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                    },
                    orderable: false,
                    searchable: false,
                }
            ]
        };

        $('#datatablesSimple').DataTable(configration);
        $(regForm).validate(validationConfig);

        @if ($errors->any())
            var FormModalgx = new bootstrap.Modal(document.getElementById('FormModalgx'));
            FormModalgx.show();
        @endif
    });

    function openAddModal() {
        $('#regForm')[0].reset();
        $('#FormModalgxLabel').text('Create Sales Target');
        $('#regForm').attr('action', "{{ route('admin.sales-targets.store') }}").find('input[name="_method"]').remove();
        new bootstrap.Modal($('#FormModalgx')[0]).show();
    }

    function openEditModal(id, element, event) {
        event.preventDefault();
        const target = tableData[id];
        if (!target) return;

        $('#FormModalgxLabel').text('Edit Sales Target');
        const form = $('#regForm');
        form[0].reset();

        form.attr('action', updateUrl.replace('__ID__', id));
        if (!form.find('input[name="_method"]').length) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        } else {
            form.find('input[name="_method"]').val('PUT');
        }

        $('#user_id').val(target.user_id).trigger('change');
        $('#month').val(target.month);
        $('#leads_contacted').val(target.leads_contacted);
        $('#leads_converted').val(target.leads_converted);
        $('#revenue_target').val(target.revenue_target);

        new bootstrap.Modal($('#FormModalgx')[0]).show();
    }

    function deleteConfirmation(btn) {
        const id = $(btn).data('id');
        const url = $(btn).data('href').replace(':id', id);
        if (confirm('Are you sure?')) {
            $.ajax({
                url,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: () => location.reload()
            });
        }
    }
</script>
@endpush
