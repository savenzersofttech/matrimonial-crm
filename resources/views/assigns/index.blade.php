@extends('layouts.sb2-layout')
@section('title', 'Assigned Profiles')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Profiles
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->


    <div class="container-fluid px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Profile</span>
                <button type="button" class="addBtn btn btn-sm btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>



            <div class="card-body">

                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>Profile</th>
                                <th>Employee</th>
                                <th>Assigned</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                      
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="FormModalgx" tabindex="-1" aria-labelledby="FormModalgxLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" id="regForm" callbackSuccessFn="closeModal" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="FormModalgxLabel">Model</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="employee_id">Select Employee</label>
                                <select id="employee_id" name="employee_id" class="virtualSelect" required>

                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="profile_ids">Select Profiles</label>
                                <select id="profile_ids" name="profile_ids[]" class="virtualSelect" multiple required>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="note">Note (Optional)</label>
                                <textarea id="note" name="note" class="form-control" rows="3"></textarea>
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success ">Save</button>
                        </div>

                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection


@push('scripts')
<script>
      let configration;
        const updateUrl = @json(route('admin.assigns.update', ['assign' => '__ID__']));
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
                        console.log(e, t, a, s);
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
                            data-href = "{{ route('admin.assigns.destroy', ':id') }}"
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
                    url: "{{ route('assigns.showAll.api') }}",
                    type: 'POST'
                },
                columns: [{
                        data: 's_no',
                    },

                    {
                        data: 'profile.name',
                        render: function  (data, type,row,) {
                                    return `<a href="/profiles/${row.profile_id}" target="_blank">${data}</a>`; 
                        }
                    },
                    {
                        data: 'employee.name',
                    },
                    {
                        data: 'assigned_at',
render: function(data, type, row) {
    const date = row.assigned_at;

    return `
        <div class="d-flex flex-column">
            <span class="text-primary fw-semibold">
                <i class="bi bi-person-check-fill me-1"></i>${row.assigned_by.name}
            </span>
            <span class="text-muted small">
                <i class="bi bi-calendar-event me-1"></i>${date}
            </span>
        </div>
    `;
}

                    },
                   {
                        data: 'note',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) return '';

                            // Limit to first 4 words
                            const words = data.split(' ');
                            const shortText = words.slice(0, 4).join(' ') + (words.length > 4 ? '...' : '');

                            return `<span title="${data.replace(/"/g, '&quot;')}">${shortText}</span>`;
                        }
                    },
                    {
                        data: 'note',
                        orderable: false,
                        searchable: false
                    },
                    
                ],
                columnDefs: colDefs || [],
            };


           

           


            $(regForm).validate(validationConfig);

        });

    async function getFormOptions(mode){
        const employees = await makeHttpRequest(`{{ route('assigns.userAndemployees.api') }}?mode=${mode}`, "GET");
;
        console.log(employees);
        employees.profiles.length && document.querySelector('#profile_ids').setOptions(employees.profiles);
        employees.users.length && document.querySelector('#employee_id').setOptions(employees.users);
    }

    async function openAddModal() {
        var FormModalgx = new bootstrap.Modal($('#FormModalgx')[0]);
        var $form = $('#regForm');
        $('#FormModalgxLabel').text('Assign Profiles');
        $form.find('button[type="submit"]').text('Save');
        $form.find('input[name="_method"]').remove();
        // Set default status and hide it
        $form[0].reset();
        await getFormOptions('add');
        $form.attr('action', "{{ route('admin.assigns.store') }}");
        FormModalgx.show();
    }

    async function openEditModal(id, element, event) {
            event.preventDefault();
            await getFormOptions('edit');
            const rowData = tableData[id]; // Fix: Use id directly as the key
            console.log(rowData,'rowData Data:', `index_${id}`);
            console.log(rowData);
            if (!rowData) return;

            var $form = $('#regForm');
            $form[0].reset();

            $form.attr('action', updateUrl.replace('__ID__', rowData.id));
            $form.attr('method', 'POST');
            $('#FormModalgxLabel').text('Edit');
            $form.find('button[type="submit"]').text('Update');

            let $methodInput = $form.find('input[name="_method"]');
            if (!$methodInput.length) {
                $methodInput = $('<input>', {
                    type: 'hidden',
                    name: '_method'
                });
                $form.append($methodInput);
            }
            $methodInput.val('PUT');

            // Fill form values
            document.querySelector('#profile_ids').setValue(rowData.profile_id); 
            document.querySelector('#employee_id').setValue(rowData.employee_id); 
            $('#note').val(rowData.note);     

          

            

            new bootstrap.Modal($('#FormModalgx')[0]).show();
        }
   

</script>



@endpush
