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
                                <th>Period</th>
                                <th>Days</th>
                                <th>Contacted</th>
                                <th>Converted</th>
                                <th>Revenue (₹)</th>
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
            <form  action="{{ route('admin.sales-targets.store') }}"  id="regForm" callbackSuccessFn="closeModal"
                    method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="FormModalgxLabel">Create Sales Target</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label required">Select User</label>
                            <select name="user_id" id="user_id" class="virtualSelect after-parent" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        
                         <div class="mb-3">
                                <label for="period" class="form-label required">Time period</label>
                                <select id="period" name="period" class="form-select required" placeholder="Select Period" required>
                                    <option value="" selected disabled >Select Period</option>
                                    <option data-id="0"  value="0">Custom</option>
                                    <option data-id="7"  value="7 Day's">7 Day's</option>
                                    <option data-id="30" value="1 Month">1 Month</option>
                                    <option data-id="60"  value="3 Month's">3 Month's</option>
                                    <option data-id="180" value="6 Month's">6 Month's</option>
                                </select>
                            </div>
                        <div class="row">

                             <div class="col-6">
                            <label for="start_date" class="form-label required">Start Date</label>
                            <input type="date" name="start_date" placeholder="Start Date" class="form-control after-parent"
                            id="start_date" required>
                        </div>

                        <div class="col-6">
                            <label for="end_date" class="form-label required">End Date</label>
                            <input type="date" name="end_date" placeholder="End Date" class="form-control after-parent"
                            id="end_date" required>
                        </div>
                        </div>

                        <div class="mb-3">
                            <label for="contacted_lead" class="form-label required">Leads Contacted</label>
                            <input type="number" name="contacted_lead" id="contacted_lead" class="form-control num" required>
                        </div>

                        <div class="mb-3">
                            <label for="converted_lead" class="form-label required">Leads Converted</label>
                            <input type="number" name="converted_lead" id="converted_lead" class="form-control num" required>
                        </div>

                       <div class="mb-3">
                            <label for="revenue" class="form-label">Revenue Target </label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="revenue" id="revenue" class="form-control num" required>
                            </div>
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
    const Today     = "{{ \Carbon\Carbon::now()->format('Y-m-d') }}";
    const Plus7     = "{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}";
    const Plus30    = "{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}";
    const Plus60    = "{{ \Carbon\Carbon::now()->addDays(60)->format('Y-m-d') }}";
    const Plus180   = "{{ \Carbon\Carbon::now()->addDays(180)->format('Y-m-d') }}";

    document.addEventListener("DOMContentLoaded", function () {

    $('#period').on('change', function () {
    const selectedOption = $(this).find(':selected');
    const period = parseInt(selectedOption.data('id'), 10);
    $('#custom_period').remove();

    // If period == 0, add visible input for custom period
    if (period === 0) {
        const inputHtml = `<input type="text" id="custom_period" name="custom_period" class="form-control mt-2" placeholder="Enter Period value">`;
        $(this).after(inputHtml);
    }

    // Set start_date
    if (!isNaN(period)) {
        $('#start_date').val(Today);

        // Set end_date based on predefined options
        let endDate;
        switch (period) {
            case 0:
                endDate = '';
                break;
            case 7:
                endDate = Plus7;
                break;
            case 30:
                endDate = Plus30;
                break;
            case 60:
                endDate = Plus60;
                break;
            case 180:
                endDate = Plus180;
                break;
            default:
                endDate = '';
        }

        $('#end_date').val(endDate);
    }
});




        validationConfig['ignore'] = [];

        let colDefs = [{
                    targets: 0,
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    width: '50px', // <-- minimum width
                    render: function(e, t, a, s) {
                        return a.s_no;
                    }
                },
                {
                    targets: -1,
                    title: "Actions",
                    orderable: !1,
                    searchable: !1,
                    render: function(e, t, a, s) {
                        // console.log(e, t, a, s);
                          tableData[a.id] = a; // Fix: Use a.id as the key directly
                        return `
                        <button 
                            type="button"
                            data-id="index_${a.id}" 
                            onclick="openEditModal(${a.id}, this, event)" 
                            class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                            aria-label="Edit User"
                            title="Edit">    <i class="fas fa-pen"></i>

                        </button>
                        <button 
                            type="button"
                            data-href = "{{ route('admin.sales-targets.destroy', ':id') }}"
                            data-id="${a.id}" 
                            onclick="deleteConfirmation(this, event)"  
                            class="btn btn-datatable btn-icon btn-transparent-dark"
                            aria-label="Delete User"
                            title="Delete"><i class="far fa-trash-can"></i>
                        </button>
                        `;
                    },
                },
            ];




        configration = {
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.sales-targets.showAll.api') }}",
                type: 'POST'
            },
            columns: [
                { data: 's_no', },
                { data: 'user.name' },
                { data: 'period' },
                { data: null,
                    render: function(data, type, row) {
                        return `${data.time_diff} Day's`
                    }
                 },
                { data: 'contacted_lead' },
                { data: 'converted_lead' },
                { data: null,
                    render: function(data,type,row){
                        return `₹${row.revenue}`;
                    }
                 },
                { data: 'revenue' },
                
            ],
            columnDefs: colDefs || [],
        };

        $(regForm).validate(validationConfig);

       
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
    console.log(target);

    $('#FormModalgxLabel').text('Edit Sales Target');
    const form = $('#regForm');
    form[0].reset();
    form.attr('action', updateUrl.replace('__ID__', id));
    if (!form.find('input[name="_method"]').length) {
        form.append('<input type="hidden" name="_method" value="PUT">');
    } else {
        form.find('input[name="_method"]').val('PUT');
    }

    document.querySelector('#user_id').setValue(target.user.id); // if virtual select
    $('#converted_lead').val(target.converted_lead);
    $('#contacted_lead').val(target.contacted_lead);
    $('#revenue').val(target.revenue);
    $('#start_date').val(target.end_date);
    $('#end_date').val(target.end_date);

    // 🌟 Handle Period + Custom Input
    const periodVal = target.period;
    const periodSelect = $('#period');
    const matchingOption = periodSelect.find(`option[data-id="${periodVal}"]`);

    if (matchingOption.length) {
        // Standard option found
        periodSelect.val(matchingOption.val()).trigger('change');
        $('#custom_period').remove(); // hide any existing custom input
    } else {
        // Custom period (not found in options)
        periodSelect.val("0").trigger('change'); // Select "Custom"
        $('#custom_period').remove(); // remove existing input if any
        const customInput = `<input type="text" id="custom_period" name="custom_period" class="form-control mt-2" placeholder="Enter Period" value="${periodVal}">`;
        periodSelect.after(customInput);
    }

    // ✅ Show modal
    new bootstrap.Modal($('#FormModalgx')[0]).show();
}


    
</script>
@endpush
