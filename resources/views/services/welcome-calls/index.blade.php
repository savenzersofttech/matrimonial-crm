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
                    <div class="col-12 col-xl-auto mt-4">
                        <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                            <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />
                        </div>
                    </div>
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
                                <th>Profile Info</th>
                                <th>Contact info</th>
                                <th>Note</th>
                                <th>Last Comment</th>
                                <th>Last Follow-up Date</th>
                                <th>Last Status</th>
                                <th>Actions</th>
                            </tr>

                        </thead>
                    </table>

               
            </div>
        </div>
    </div>
    {{-- edit x-modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" data-ajax>
                        @csrf
                        @method('PUT')
                        <div class="row">


                            <div class="col-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe">
                            </div>
                            <div class="col-6  mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="phone" class="form-label">Contact Number</label>
                                <input type="hidden" id="phone_code" name="phone_code">
                                <input type="tel" class="form-control" id="phone" name="phone_number" placeholder="+1234567890">
                            </div>


                            <div class="col-6 mb-3">
                                <label for="follow_up_date" class="form-label">Follow-up Date</label>
                                <input type="datetime-local" class="form-control" id="follow_up_date" name="follow_up_date">

                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="" disabled selected>Select status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="No Response">No Response</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Enter your comments"></textarea>

                            </div>


                        </div>
                        <div class="mb-3 d-flex justify-content-end gap-1">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button class="btn btn-dark" type="button" data-bs-dismiss="modal">Close</button>
                        </div>


                    </form>

                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">View Welcome Call</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Name</label>
                            <p id="view-name" class="form-control-static"></p>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Email</label>
                            <p id="view-email" class="form-control-static"></p>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Phone</label>
                            <p id="view-phone" class="form-control-static"></p>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Follow-up Date</label>
                            <p id="view-follow-up-date" class="form-control-static"></p>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Status</label>
                            <p id="view-status" class="form-control-static"></p>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Assigned By</label>
                            <p id="view-assigned-by" class="form-control-static"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comment</label>
                            <p id="view-comment" class="form-control-static"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Follow-up History</label>
                            <table id="datatableTableView" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>    -up Date</th>
                                        <th>Status</th>
                                        <th>Comment</th>
                                        <th>Employee</th>
                                    </tr>
                                </thead>
                                <tbody id="view-follow-up-history" class="text-center"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this welcome call?</p>
                </div>
                <div class="modal-footer">
                    <form action="" method="POST" data-ajax>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button class="btn btn-dark" type="button" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
@php
function getStatusClass($status)
{
return match ($status) {
'Interested' => 'success',
'Follow-up Needed' => 'warning',
'No Response' => 'danger',
'Not Interested' => 'secondary',
default => 'dark',
};
}
@endphp



@push('scripts')
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
               url: "{{ route('services.welcome-calls.showAll.api') }}",
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
                   data: 'comment'
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
@endpush
    


