@extends('layouts.sb2-layout')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Payments
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
                <span>Payments</span>
                <button type="button" class="addBtn btn btn-sm btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">S. No.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Plan</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Link Send at</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Add/Edit  Modal -->
    <div class="modal fade" id="FormModalgx" tabindex="-1" data-bs-backdrop="static" aria-labelledby="FormModalgxLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('services.payments.store') }}" id="regForm" callbackSuccessFn="closeModal" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="FormModalgxLabel">Create Payment Link</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="profile_id" class="form-label">Client</label>
                            <select class="virtualSelect after-parent" id="profile_id" name="profile_id" placeholder="Select Client" required>
                                {{-- <option value="">Select Prospect</option> --}}
                                @foreach ($profiles as $profile)
                                <option value="{{ $profile->id }}" @if (old('profile_id')==$profile->id) selected @endif>
                                    {{ $profile->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="plan_id" class="form-label required">Plan Name</label>
                            <select id="plan_id" class="form-select after-parent" name="plan_id" placeholder="Select Plan" required>
                                <option value="" selected disabled>Select Plan</option>
                                @foreach ($packages as $pkg)
                                <option data-type="{{ $pkg->currency }}" data-price="{{ $pkg->price }}" value="{{ $pkg->id }}">
                                    {{ $pkg->name }} / 
                                    {{ $pkg->currency === 'INR' ? '₹' : '$' }}{{ number_format($pkg->price) }}

                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label required">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="Pending">Pending</option>
                                <option value="Failed">Failed</option>
                                <option value="Paid">Paid</option>

                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="price" class="form-label required">Amount</label>
                            <div class="input-group">
                                <select class="form-select" id="currency" name="currency" style="max-width: 120px;">
                                    <option value="INR">INR</option>
                                    <option value="USD">USD</option>
                                </select>
                                <input placeholder="amount" id="price" type="number" value="{{ old('price') }}" name="price" class="form-control" required>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="start_date" class="form-label required">Start Date</label>
                                <input type="date" class="form-control after-parent" id="start_date" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="end_date" class="form-label required">Expiry Date</label>
                                <input type="date" class="form-control after-parent" id="end_date" name="end_date" value="{{ old('end_date', now()->addDays(30)->format('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount</label>
                            <select id="discount" class="form-control after-parent" name="discount" placeholder="Select Discount">
                                <option value="0">No Discount</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                                <option value="20">20%</option>
                                <option value="30">30%</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary auto-start" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
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
   let configration;
         const updateUrl = @json(route('services.payments.update', ['payment' => '__ID__']));
         document.addEventListener("DOMContentLoaded", function () {
            validationConfig['ignore'] = [];

            let colDefs = [{
               targets: 0,
               className: 'text-center',
               orderable: false,
               searchable: false,
               width: '50px', // <-- minimum width
               render: function (e, t, a, s) {
                  return a.s_no;
               }
            }, {
               targets: -1,
               title: "Actions",
               orderable: !1,
               searchable: !1,
               render: function (e, t, a, s) {
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
                            data-href = "{{ route('services.payments.destroy', ':id') }}"
                            data-id="${a.id}" 
                            onclick="deleteConfirmation(this, event)"  
                            class="btn btn-datatable btn-icon btn-transparent-dark"
                            aria-label="Delete User"
                            title="Delete"><i class="far fa-trash-can"></i>
                        </button>
                        `;
               },
            },
        {
        targets: '_all',  
        className: 'text-start'
    }
 ];

            configration = {
               processing: true,
               serverSide: true,
               ajax: {
                  url: "{{ route('services.payments.showAll') }}",
                  type: 'POST'
               },
               columns: [{
                     data: 's_no',
                  },

                  {
                     data: 'profile.name',
                  }, {
                     data: 'package.name',
                  }, {
                     data: null,
                     render: function (data, type, row) {
                        return formatCurrency(row.price, row.currency);
                     }
                  },
                  {
                     data: null,
                     width: '10px',
                     render: function (data, type, row) {
                        return row.discount ? row.discount + '%' : '0%';
                     },
                     title: 'Discount'
                  },
                  {
                    data: 'final_amount',
                    title: 'Final',
                      width: '10px',
                    render: function (data, type, row) {
                                return `<span class="fw-bold text-dark">${formatCurrency(data, row.currency)}</span>`;

                    }
                   }, {
                     data: 'status',
                     orderable: false,
                     searchable: false,
                     render: function (data, type, row) {
                        return getStatusBadge(data);
                     }
                  }, {
                     data: 'sent_at',
                     orderable: false,
                     searchable: false
                  }, {
                     data: 'sent_at',
                     orderable: false,
                     searchable: false
                  }
               ],
               columnDefs: colDefs || [],
            };


            $('#plan_id').on('change', function () {

               const selectedOption = $(this).find('option:selected');
               const price = selectedOption.data('price') || 0;
               const currencyType = selectedOption.data('type') || 'INR';
               console.log(price, currencyType);
               $('#price').val(price);
               $('#currency').val(currencyType);
            });


            $(regForm).validate(validationConfig);


         });


         function openAddModal() {
            var FormModalgx = new bootstrap.Modal($('#FormModalgx')[0]);
            var $form = $('#regForm');
            $('#FormModalgxLabel').text('Create Payment Link');
            $form.find('button[type="submit"]').text('Save');
            $form.find('input[name="_method"]').remove();
            // Set default status and hide it
            $('#status').val('pending').closest('.mb-3').hide();
            $form[0].reset();
            $form.attr('action', "{{ route('services.payments.store') }}");
            FormModalgx.show();
         }


         function openEditModal(id, element, event) {
            event.preventDefault();
            const payment = tableData[id]; // Fix: Use id directly as the key
            console.log(payment, 'Payment Data:', `index_${id}`);
            console.log(payment);
            if (!payment) return;

            var $form = $('#regForm');
            $form[0].reset();

            $form.attr('action', updateUrl.replace('__ID__', payment.id));
            $form.attr('method', 'POST');
            $('#FormModalgxLabel').text('Edit Payment Link');
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
            $('#plan_id').val(payment.package.id);
            $('#price').val(payment.price);
            $('#discount').val(payment.discount);
            $('#start_date').val(payment.start_date);
            $('#end_date').val(payment.end_date);
            $('#currency').val(payment.currency);



            // Show and set status
            $('#status').val(payment.status).closest('.mb-3').show();


            new bootstrap.Modal($('#FormModalgx')[0]).show();
         }


</script>
@endpush
