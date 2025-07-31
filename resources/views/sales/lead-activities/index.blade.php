@extends('layouts.sb2-layout')
@section('title', 'Sales Tracking')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Sales Activity
                        </h1>

                    </div>
                    {{-- <div class="col-12 col-xl-auto mt-4">
                            <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                                    placeholder="Select date range..." />
                            </div>
                        </div> --}}
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-n10">
        <div class="row">

            <div class="col-xxl-12 col-xl-12 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Recent Activity
                    </div>
                    <div class="card-body p-3">
                        <div class="timeline timeline-xs">
                            @forelse ($logs as $log)
                            <div class="timeline-item mb-2">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-text text-muted small">{{ $log['time_ago'] }}</div>
                                    <div class="timeline-item-marker-indicator {{ $log['color'] }}"></div>
                                </div>
                                <div class="timeline-item-content">{!! $log['message'] !!}</div>
                            </div>
                            @empty
                            <div class="text-muted small">No activity found.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="card mb-4">
            <div class="card-header">Table</div>
            <div class="card-body">
                  <table id="datatablesSimple" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Lead Name</th>
                            <th>Follow Up</th>
                            <th>Type</th>
                            <th>Notes</th>
                            <th>Outcome</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="FormModalgx" tabindex="-1" aria-labelledby="FormModalgxLabel"  data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog">
                <form  id="regForm" callbackSuccessFn="closeModal"
                    method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="FormModalgxLabel">Title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="row modal-body">

                            <div class="mb-3">
                                <label for="profile_id" class="form-label">Name</label>
                                <input id="name" type="text"  
                                    class="form-control" readonly>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label required">Activity</label>
                                <select id="type" class="form-select after-parent " name="type"
                                    placeholder="Select Activity" required>
                                    <option value="" disabled selected hidden>Select Activity</option>
                                    <option value="Call">Call</option>
                                    <option value="Email">Email</option>
                                    <option value="Meeting">Meeting</option>
                                    <option value="Proposal">Proposal</option>                                  
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="outcome" class="form-label required">Outcome</label>
                                <select id="outcome" name="outcome" class="form-select after-parent" required>
                                <option value="" disabled selected hidden>Select Outcome</option>

                                    <option value="Interested">Interested</option>
                                    <option value="Follow-up Needed">Follow-up Needed</option>
                                    <option value="Not Interested">Not Interested</option>
                                </select>
                            </div>

                            
                                <div class="col-md-6 mb-3">
                                    <label for="follow_up" class="form-label">Follow-up Date/Time</label>
                                    <input type="datetime-local" class="form-control" id="follow_up" name="follow_up">
                                </div>

                           <div class="col-md-6 mb-3">
                                <label for="status" class="form-label required">Status</label>
                                <select id="status" name="status" class="form-select after-parent" required>
                                    <option value="" disabled selected hidden>Select Status</option>

                                    @foreach(leadsOption() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>

                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="notes" class="form-label">Note/Comment</label>
                                <textarea id="textarea" type="text" name="notes" id="notes"
                                    class="num  after-parent form-control"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
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
        const updateUrl = @json(route('sales.sales.update', ['sale' => '__ID__']));
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
                            data-href = "{{ route('sales.sales.destroy', ':id') }}"
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
                    url: "{{ route('sales.leadactivity.showAll.api') }}",
                    type: 'POST'
                },
                columns: [{
                        data: 's_no',
                    },
                    {
                        data: 'lead.profile.name',
                    },
                    {
                        data: 'follow_up',
                    },
                    {
                        data: 'type',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return getStatusBadge(data);
                        }
                    },
                    {
                       data: 'notes'

                    },
                     {
                       data: 'outcome'

                    },
                     {
                        data: 'status',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return getStatusBadge(data);
                        }
                    }, {
                       data: 'outcome'

                    }
                   
                ],
                columnDefs: colDefs || [],
            };


           

             $('#plan').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const price = selectedOption.data('price') || 0;
                $('#price').val(price);
            });


            $(regForm).validate(validationConfig);

           


        });

      

        function openEditModal(id, element, event) {
            event.preventDefault();
            const rowData = tableData[id]; 
            console.log(rowData);
            if (!rowData) return;

            var $form = $('#regForm');
            $form[0].reset();

            $form.attr('action', updateUrl.replace('__ID__', rowData.id));
            $form.attr('method', 'POST');
            $('#FormModalgxLabel').text('Update Lead');
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
            $('#name').val(rowData.lead.profile.name);

            $form.find('[name]:not([name=_token])').each(function() {
                const $el = $(this);
                const name = this.name;

                if (rowData[name] ?? false) {
                    let value = rowData[name];

                    // For phone numbers, remove only the leading '+'
                    if (name === 'phone_number' || name === 'alternative_phone_number') {
                        value = value.replace(/^\+/, '').trim();
                    }

                    if ($el.hasClass('virtualSelect')) {
                        // Handle multi-select values
                        if (typeof value === 'string' && value.includes(',')) {
                            value = value.split(',').map(item => item.trim());
                        }
                        $(`[name="${name}"]`)[0].setValue(value);
                    } else {
                        this.value = value;
                    }
                }
            });

            

            new bootstrap.Modal($('#FormModalgx')[0]).show();
        }
    </script>
@endpush
