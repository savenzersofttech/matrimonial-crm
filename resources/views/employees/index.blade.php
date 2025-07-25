@extends('layouts.sb2-layout')
@section('title', 'Employees')
@section('meta_description', 'Manage employees and view basic details.')

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


                @foreach ($usersByRole as $role => $count)
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">
                                            <h6 class="text-capitalize"> {{ str_replace('-', ' ', $role) }} </h6>
                                        </div>
                                        <div class="text-lg fw-bold">{{ $count }}</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="trending-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Employees</span>
                        <a href="{{ route('admin.employees.create') }}" class="addBtn btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="datatablesSimple" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>


                </div>


    </main>
@endsection


@push('css')
    <style>
        span.select2-dropdown.select2-dropdown--below {
            z-index: 999999;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let  configration;
        const updateUrl = @json(route('admin.employees.update', ['employee' => '__ID__']));
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
                // {
                //     targets: -1,
                //     title: "Actions",
                //     orderable: !1,
                //     searchable: !1,
                //     render: function(e, t, a, s) {
                //         console.log(e, t, a, s);
                //         tableData[`index_${s.row +1}`] = a;
                //         return `
                //         <button 
                //             type="button"
                //             data-id="index_${a.id}" 
                //             onclick="openEditModal(${a.id}, this, event)" 
                //             class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                //             aria-label="Edit User"
                //             title="Edit">    <i class="fas fa-pen"></i>

                //         </button>
                //         <button 
                //             type="button"
                //             data-id="${a.id}" 
                //             data-href="{{ route('admin.employees.destroy', ':id') }}"
                //             onclick="deleteConfirmation(this, event)"  
                //             class="btn btn-datatable btn-icon btn-transparent-dark"
                //             aria-label="Delete User"
                //             title="Delete"><i class="far fa-trash-can"></i>
                //         </button>
                //         `;
                //     },
                // },
            ];

            configration = {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.employees.showAll') }}",
                    type: 'POST'
                },
                columns: [{
                        data: 's_no',
                    },

                    {
                        data: 'user.name',
                    },
                    {
                        data: 'user.email',
                    },
                    {
                        data: 'user.role'
                    },

                ],
                columnDefs: colDefs || [],
            };



            $(regForm).validate(validationConfig);

            @if ($errors->any())
                @if (old('plan'))
                    plan.value = "{{ old('plan') }}";
                @endif

                @if (old('discount'))
                    discount.value = "{{ old('discount') }}";
                @endif

                var globalModal = new bootstrap.Modal(document.getElementById('globalModal'));
                globalModal.show();
            @endif


        });

        function closeModal() {
            var globalModal = bootstrap.Modal.getInstance(document.getElementById('globalModal'));
            if (globalModal) {
                globalModal.hide();
            }
        }

        function openAddModal() {
            var globalModal = new bootstrap.Modal($('#globalModal')[0]);
            var $form = $('#regForm');
            $('#ModalLabel').text('Create Payment Link');
            $form.find('button[type="submit"]').text('Save');
            $form.find('input[name="_method"]').remove();
            // Set default status and hide it
            $('#status').val('pending').closest('.mb-3').hide();
            $form[0].reset();
            $form.attr('action', "{{ route('admin.employees.store') }}");
            globalModal.show();
        }


        function openEditModal(id, element, event) {
            event.preventDefault();
            const payment = tableData[`index_${id}`];
            if (!payment) return;

            var $form = $('#regForm');
            $form[0].reset();

            $form.attr('action', updateUrl.replace('__ID__', payment.id));
            $form.attr('method', 'POST');
            $('#ModalLabel').text('Edit Payment Link');
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
            document.querySelector('#profile_id').setValue(payment.profile_id); // if virtual select
            $('#plan').val(payment.package.name);
            $('#price').val(payment.price);
            $('#discount').val(payment.discount);

            // Show and set status
            $('#status').val(payment.status).closest('.mb-3').show();

            new bootstrap.Modal($('#globalModal')[0]).show();
        }
    </script>
@endpush
