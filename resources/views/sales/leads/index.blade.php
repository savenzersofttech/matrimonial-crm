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
                    <button type="button" class="addBtn btn btn-sm btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Add New
                    </button>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">S. No.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Contact</th>
                                <th class="text-center">Source</th>
                                <th class="text-center">Status </th>
                                <th class="text-center">Follow-up </th>
                                <th class="text-center">Notes</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>

                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="FormModalgx" data-bs-backdrop='static' tabindex="-1" aria-labelledby="FormModalgxLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('sales.leads.store') }}" id="regForm" callbackSuccessFn="closeModal"
                    method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="FormModalgxLabel">Create Lead</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label required">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label required">Phone</label>
                                    <input type="tel" id="phone_number" name="phone_number" class="form-control"
                                        required placeholder="Enter phone number">
                                    {{-- <div class="invalid-feedback">Please enter a valid phone number</div> --}}
                                    <input type="hidden" name="phone_code" id="phone_code">
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="profile_source_id" class="form-label required">Source</label>
                                    <select id="profile_source_id" name="profile_source_id" class="form-select" required>
                                        <option value="" selected disabled>Select Source</option>
                                        @foreach ($source as $option)
                                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label required">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="" selected disabled>Select Status</option>
                                        @foreach (leadsOption() as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="follow_up" class="form-label">Follow-up Date/Time</label>
                                    <input type="datetime-local" class="form-control" id="follow_up" name="follow_up">
                                </div>

                                <div class="col-12">
                                    <label for="source_comment" class="form-label source_comment">Source Comment</label>
                                    <textarea class="form-control" id="source_comment" name="source_comment" rows="2"
                                        placeholder="Any comments regarding source?"></textarea>
                                    <span class="text-danger d-none" id="source_comment_error">This field is required when
                                        source is Other.</span>

                                </div>

                                <div class="col-12">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control" id="note" name="note" rows="2" placeholder="Add any internal notes"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button class="btn btn-secondary mt-4" type="button" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary mt-4">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection


@push('scripts')
    <script>
        let   phoneIti;
      $(document).ready(function() {
        $('#profile_source_id').on('change', function() {
            console.log($(this).val());
            if ($(this).val() == '5') {
                $('#source_comment').attr('required', true);
                $('#source_comment_error').removeClass('d-none');
                $('.source_comment').addClass('required');

            } else {
                $('#source_comment').removeAttr('required');
                $('#source_comment_error').addClass('d-none');
                $('.source_comment').removeClass('required');
            }
        });

        // Initialize International Telephone Input for phone_number with India as default
        const phoneInput = document.querySelector("#phone_number");
         phoneIti = window.intlTelInput(phoneInput, {
            initialCountry: "in",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.5.0/build/js/utils.js",
            separateDialCode: true
        });

      

        // Update hidden fields with country codes on input change
        phoneInput.addEventListener('countrychange', function() {
            document.querySelector('#phone_code').value = '+' + phoneIti.getSelectedCountryData()
                .dialCode;
        });

        // Set initial country codes
        document.querySelector('#phone_code').value = '+' + phoneIti.getSelectedCountryData().dialCode;


        // Validate phone number on form submission
        const formValidation = document.querySelector('.needs-validation');
        formValidation.addEventListener('submit', function(event) {
            if (!phoneIti.isValidNumber() && phoneInput.value.trim()) {
                phoneInput.classList.add('is-invalid');
                event.preventDefault();
                event.stopPropagation();
            } else {
                phoneInput.classList.remove('is-invalid');
            }
            formValidation.classList.add('was-validated');
        });

      });
    </script>

    <script>
        let configration;
        const updateUrl = @json(route('sales.leads.update', ['lead' => '__ID__']));
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
                            data-href = "{{ route('sales.leads.destroy', ':id') }}"
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
                    url: "{{ route('leads.showAll.api') }}",
                    type: 'POST'
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
                        render: function (data, type, row) {
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
                        data: 'profile.profile_source.name'
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
                        data: 'follow_up',
                          className: 'text-start',
                    },
                    {
                        data: 'note',
                        orderable: false,
                          className: 'text-start',
                        searchable: false
                    },
                    {
                        data: 'follow_up',
                        orderable: false,
                          className: 'text-start',
                        searchable: false
                    }, {
                        data: 'created_at',
                        orderable: false,
                          className: 'text-start',
                        searchable: false
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

            @if ($errors->any())
                @if (old('plan'))
                    plan.value = "{{ old('plan') }}";
                @endif

                @if (old('discount'))
                    discount.value = "{{ old('discount') }}";
                @endif

                var FormModalgx = new bootstrap.Modal(document.getElementById('FormModalgx'));
                FormModalgx.show();
            @endif


        });



        function openAddModal() {
            var FormModalgx = new bootstrap.Modal($('#FormModalgx')[0]);
            var $form = $('#regForm');
            $('#FormModalgxLabel').text('Create New Lead');
            $form.find('button[type="submit"]').text('Save');
            $form.find('input[name="_method"]').remove();
            // Set default status and hide it
            $form[0].reset();
            $form.attr('action', "{{ route('sales.leads.store') }}");
            FormModalgx.show();
        }


        function openEditModal(id, element, event) {
            event.preventDefault();
            const rowData = tableData[id]; // Fix: Use id directly as the key
            console.log(rowData, 'rowData Data:', `index_${id}`);
            console.log(rowData);
            if (!rowData) return;

            var $form = $('#regForm');
            $form[0].reset();

            $form.attr('action', updateUrl.replace('__ID__', rowData.id));
            $form.attr('method', 'POST');
            $('#FormModalgxLabel').text('Edit Lead');
            $form.find('button[type="submit"]').text('Update');

            let $methodInput = $form.find('input[name="_method"]');
            if (!$methodInput.length) {
                $methodInput = $('<input>', {
                    type: 'hidden',
                    name: '_method'
                });
                $form.append($methodInput);
            }


            $('#name').val(rowData.profile.name);
            $('#email').val(rowData.profile.email);
const fullNumber = rowData.profile.phone_number;
const dialCode = '+' + phoneIti.getSelectedCountryData().dialCode;

// Remove the dial code prefix from the full number
const localNumber = fullNumber.startsWith(dialCode) ? fullNumber.slice(dialCode.length) : fullNumber;

document.querySelector('#phone_code').value = dialCode;
document.querySelector('#phone_number').value = localNumber;
            $('#status').val(rowData.status);
            $('#follow_up').val(rowData.follow_up_row);
            $('#source_comment').val(rowData.profile.profile_source_comment);
            $('#note').val(rowData.note);
            $('#profile_source_id').val(rowData.profile.profile_source.id);

            $methodInput.val('PUT');
            new bootstrap.Modal($('#FormModalgx')[0]).show();
        }
    </script>
    </script>
@endpush
