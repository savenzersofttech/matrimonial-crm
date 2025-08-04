@extends('layouts.sb2-layout')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                           <div class="page-header-icon"><i data-feather="phone"></i></div>

                            Welcome Calls
                        </h1>  
                        <div class="page-header-subtitle">Example dashboard overview and content summary </div>
                       
                    </div>
                    {{-- <div class="col-12 col-xl-auto mt-4">
                        <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                            <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-n10">


        <!-- Example DataTable for Dashboard Demo-->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Calls</span>

            </div>

            <div class="card-body">
                 <table id="datatablesSimple" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                {{-- <th>Membership Type</th> --}}
                                <th>Status</th>
                                <th>Outcome</th>
                                <th>Note</th>
                                <th>Sold by</th>
                                <th>Actions</th>
                            </tr>

                        </thead>
                    </table>

               
            </div>
        </div>
    </div>
   
      <!-- Log View  Modal -->
    <div class="modal fade" id="LogModel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="LogModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl"  role="document">
           
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="LogModelLabel">Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered table-sm" id="simpleDatatableLog">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Outcome</th>
                                    <th>Call Time</th>
                                    <th>Notes</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary auto-start" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
           
        </div>
    </div>

      <!-- Add/Edit  Modal -->
    <div class="modal fade" id="FormModalgx" tabindex="-1" data-bs-backdrop="static" aria-labelledby="FormModalgxLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('services.welcome-calls.store') }}" id="regForm" callbackSuccessFn="closeModal" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="FormModalgxLabel">Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="profile_id" class="form-label">Client</label>
                            <input id="name" type="text" class="form-control" readonly disabled>
                        </div>


                        <div class="mb-3">
                            <label for="status" class="form-label required">Status</label>
                            <select id="status" class="form-select after-parent" name="status" placeholder="Select Status" required>
                                <option value="" selected disabled>Select status</option>
                                <option value="New">New</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Missed">Missed</option>
                                <option value="Rescheduled">Rescheduled</option>
                               
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="outcome" class="form-label required">Call Outcome</label>
                            <select id="outcome" class="form-select after-parent" name="outcome" placeholder="Select Outcome" required>
                                <option value="" selected disabled>Select Outcome</option>
                                <option value="Successfull">Successfull</option>
                                <option value="No Answer">No Answer</option>
                                <option value="Follow-up Needed">Follow-up Needed</option>
                                <option value="Client Unreachable">Client Unreachable</option>
                            </select>
                        </div>
                       
                         <div class="mb-3">
                            <label for="call_time" class="form-label">Next Call Time</label>
                            <input type="datetime-local" class="form-control valid" id="call_time" name="call_time" aria-invalid="false" required>
                        </div>

                         <div class="col-12">
                                    <label for="notes" class="form-label">Note</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Add any internal notes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary auto-start" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add</button>
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
    const $form = $('#regForm');

 document.addEventListener("DOMContentLoaded", function() {
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
                 
                 tableData[a.id] = a; // Fix: Use a.id as the key directly
                 return `
                   <button 
                       type="button"
                       data-id="index_${a.id}" 
                       onclick="openEditModal(${a.id}, this, event)" 
                       class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                       aria-label="Edit User"
                       title="Edit">    <i class="fas fa-plus"></i>
                   </button>
                   <button 
                       type="button"
                       data-id="index_${a.id}" 
                       onclick="openLogModal(${a.id}, this, event)" 
                       class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                       aria-label="View"
                       title="View">    <i class="fas fa-eye"></i>
                   </button>
                   `;
             },
         },
     ];

     configration = {
         processing: true,
         serverSide: true,
         ajax: {
             url: "{{ route('services.welcome-calls.showAll.api') }}",
             type: 'POST',
             data: {
                 _token: '{{ csrf_token() }}'
             },
             error: function(xhr, status, error) {
                 showDangerToast("Server Error!", " Error: " + xhr.responseJSON?.message || "Something went wrong.");
                 console.error("AJAX Error Response:", xhr);
             }
         },
         columns: [{
                 data: 's_no',
             },

             {
                 data: 'profile.name',
                 className: 'text-start'

             },
             {
                 data: null,
                 className: 'text-start',
                 render: function(data, type, row) {
                     const phone = row.profile?.phone_number || '-';
                     const email = row.profile?.email || '';
                     let html = '';

                     if (phone) {
                         html += `<div><i class="fas fa-phone me-1"></i> ${phone}</div>`;
                     }

                     if (email) {
                         html += `<div><i class="fas fa-envelope  me-1"></i> ${email}</div>`;
                     }

                     return html;
                 }
             },
             {
                 data: 'status',
                 orderable: false,
                 searchable: false,
                 render: function(data, type, row) {
                     return getStatusBadge(data);
                 }
             },
             {
                 data: null,
                 render: function(data, type, row) {
                     return row.outcome ?? ' - ';
                 }
             },
             {
                 data: null,
                 render: function(data, type, row) {
                     let short = truncateWords(row.notes, 1)
                     return `<p title="${row.notes  }" >${short}</p>`;
                 }
             }, {
                 data: 'employee.name',
             }, {
                 data: 'created_at',
                 orderable: false,
                 className: 'text-start',
                 searchable: false
             }
         ],
         columnDefs: colDefs || [],
     };
        $(regForm).validate(validationConfig);



 });

let datatableInstance = null;

function openLogModal(welcomeCallId) {
    const $tableWrapper = document.querySelector('#simpleDatatableLog').parentElement;

    // Destroy old DataTable if exists
    if (datatableInstance) {
        datatableInstance.destroy();
        datatableInstance = null;
    }

    // Replace the entire table to reset everything
    $tableWrapper.innerHTML = `
        <table id="simpleDatatableLog" class="table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Status</th>
                    <th>Outcome</th>
                    <th>Call Time</th>
                    <th>Notes</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="6" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    `;

    const $table = document.querySelector('#simpleDatatableLog tbody');

    fetch("{{ route('services.welcome-calls.logs') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            welcome_call_id: welcomeCallId
        })
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            if (Array.isArray(response.data) && response.data.length > 0) {
                const rows = response.data.map((item, index) => {
                    return `<tr>
                        <td>${index + 1}</td>
                       <td>${getStatusBadge(item.status)}</td>
                       <td>${getStatusBadge(item.outcome)}</td>
                        <td>${item.call_time ?? '-'}</td>
                        <td>${item.notes ?? '-'}</td>
                        <td>${item.created_at}</td>
                    </tr>`;
                }).join('');
                $table.innerHTML = rows;
                datatableInstance = new simpleDatatables.DataTable("#simpleDatatableLog");
            } else {
                $table.innerHTML = `<tr><td colspan="6" class="text-center">No logs found.</td></tr>`;
            }
        } else {
            $table.innerHTML = `<tr><td colspan="6" class="text-danger text-center">${response.error || 'Failed to load logs.'}</td></tr>`;
        }
    })
    .catch(() => {
        $table.innerHTML = `<tr><td colspan="6" class="text-danger text-center">Error loading data.</td></tr>`;
    });

    // Show the modal
    const logModal = new bootstrap.Modal(document.getElementById('LogModel'));
    logModal.show();
}






 function openEditModal(id, element, event) {
        event.preventDefault();
        const rowData = tableData[id];
        console.log(rowData);
        if (!rowData) return;
        $form[0].reset();

        // Add welcome_call_id
        $form.append(
            $('<input>').attr({
                type: 'hidden',
                name: 'welcome_call_id',
                value: rowData.id 
            })
        );

        // Add profile_id
        $form.append(
            $('<input>').attr({
                type: 'hidden',
                name: 'profile_id',
                value: rowData.profile_id 
            })
        );
        $('#FormModalgxLabel').text('Add Call Log  Activity');
        $('#name').val(rowData.profile.name);
        $('#status').val(rowData.status);
        $('#outcome').val(rowData.outcome);
        new bootstrap.Modal($('#FormModalgx')[0]).show();
 }  
</script>
@endpush
    


