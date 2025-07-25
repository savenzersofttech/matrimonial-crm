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
                            Welcome Calls
                        </h1>
                        {{-- <div class="page-header-subtitle">Example dashboard overview and content summary </div>
                        --}}
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
                <table id="datatableTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Profile Info</th>
                            <th>Assigned By</th>
                            <th>Note</th>
                            <th>Last Comment</th>
                            <th>Last Follow-up Date</th>
                            <th>Last Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Profile Info</th>
                            <th>Assigned By</th>
                            <th>Note</th>
                            <th>Last Comment</th>
                            <th>Last Follow-up Date</th>
                            <th>Last Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        @forelse($calls as $index => $call)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="#"><strong>{{ $call->profile->name ?? 'N/A' }}</strong></a>

                            </td>
                            <td>
                                @if ($call->profileAssignment && $call->profileAssignment->assignedByUser)
                                {{ $call->profileAssignment->assignedByUser->name ?? '-' }}
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ $call->profileAssignment->note ?? '-' }}</td>

                            <td>{{ $call->comment ?? '-' }}</td>
                            <td>
                                @if ($call->follow_up_date)
                                {{ \Carbon\Carbon::parse($call->follow_up_date)->format('d-m-Y H:i') }}
                                @else
                                <span class="text-center">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="badge bg-{{ getStatusClass($call->status ?? 'light') }} text-white rounded-pill">
                                    {{ $call->status ?? '-' }}
                                </div>
                            </td>
                            <td>
                                {{-- @dd($call->toArray()); --}}

                                <button type="button" class="btn editBtn btn-icon btn-transparent-dark me-2" href="{{ route('services.welcome-calls.edit', $call->id) }}" data-json='@json($call)' data-action="{{ route('services.welcome-calls.update', $call->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>


                                <button type="button" data-id="{{ $call->profile['id'] }}" class="btn viewBtn btn-icon btn-transparent-dark me-2">
                                    <i class="fa-solid fa-eye"></i>
                                </button>


                                <button type="button" class="btn btn-datatable btn-icon btn-transparent-dark deleteBtn" data-action="{{ route('services.welcome-calls.destroy', $call->id) }}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No welcome calls found.</td>
                        </tr>
                        @endforelse
                    </tbody>
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
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1234567890">
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
                                        <th>Follow-up Date</th>
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
    $(document).ready(function() {
        const phoneInput = document.querySelector("#phone");
        const iti = window.intlTelInputGlobals.getInstance(phoneInput); // get the instance

        $('.editBtn').click(function(e) {
            e.preventDefault();
            const data = $(this).data('json');
            console.log(data);
            const actionUrl = this.getAttribute('data-action');
            const form = $('#editModal').find('form')[0];
            form.reset(); // ← Reset all fields
            const $form = $(form);
            $form.attr('action', actionUrl);
            $form.find('input[name="name"]').val(data ? .profile ? .name || '');
            $form.find('input[name="email"]').val(data ? .profile ? .email || '');
            $form.find('select[name="status"]').val(data ? .status || '');
            $form.find('input[name="follow_up_date"]').val(data ? .follow_up_date || '');
            $form.find('textarea[name="comment"]').val(data ? .comment || '');
            if (data ? .profile ? .phone) {
                let rawPhone = data.profile.phone.replace(/[\s-]/g, '');
                iti.setNumber(rawPhone);
            }
            $('#editModal').modal('show');
        });

        // View Button Click
        // View Button Click
        $('.viewBtn').click(async function(e) {
            e.preventDefault();
            const callId = $(this).data('id');
            try {
                const response = await makeHttpRequest(`/api/welcome-calls/${callId}`, 'GET');
                if (response.success) {
                    const data = response.data;
                    $('#view-name').text(data.profile.name || '-');
                    $('#view-email').text(data.profile.email || '-');
                    $('#view-phone').text(data.profile.phone || '-');
                    $('#view-follow-up-date').text(data.follow_up_date ? new Date(data
                        .follow_up_date).toLocaleString('en-GB', {
                        day: '2-digit'
                        , month: '2-digit'
                        , year: 'numeric'
                        , hour: '2-digit'
                        , minute: '2-digit'
                    }) : '-');
                    $('#view-status').text(data.status || '-');
                    $('#view-assigned-by').text(data.follow_up_histories[0] ? .employee ? .name || '-');
                    $('#view-comment').text(data.comment || '-');

                    // Populate follow-up history table
                    const historyTable = $('#view-follow-up-history');
                    historyTable.empty();
                    if (data.follow_up_histories && data.follow_up_histories.length > 0) {
                        data.follow_up_histories.forEach((history, index) => {
                            historyTable.append(`
                            <tr>
                                <td>${index + 1}</ted>
                                <td>${history.follow_up_date ? new Date(history.follow_up_date).toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-'}</td>
                               <td>
  <div class="badge bg-${getStatusClass(history.status)} text-white rounded-pill">
    ${history.status || '-'}
  </div>
</td>
                                <td>${history.comment || '-'}</td>
                                <td>${history.employee?.name || '-'}</td>
                            </tr>
                        `);
                        });
                    } else {
                        historyTable.append(
                            '<tr><td colspan="5" class="text-center">No follow-up history available.</td></tr>'
                        );
                    }
                    $('#viewModal').modal('show');
                } else {
                    showDangerToast('Error', response.message || 'Failed to fetch data.');
                }
            } catch (error) {
                showDangerToast('Error', error.message || 'Error fetching data. Please try again.');
            }
        });
    });

    $(document).on('click', '.deleteBtn', function(e) {
        e.preventDefault();
        const button = $(this);
        const action = button.data('action');

        Swal.fire({
            title: 'Are you sure?'
            , text: "You won’t be able to revert this!"
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#d33'
            , cancelButtonColor: '#6c757d'
            , confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = $('<form>', {
                    method: 'POST'
                    , action: action
                });

                form.append('@csrf');
                form.append('@method("DELETE")');

                $('body').append(form);
                form.submit();
            }
        });
    });


    window.addEventListener('DOMContentLoaded', event => {
        const datatableTable = document.getElementById('datatableTable');
        if (datatableTable) {
            new simpleDatatables.DataTable(datatableTable);
        }

        const datatableTableView = document.getElementById('datatableTableView');
        if (datatableTableView) {
            new datatableTableView.DataTable(datatableTableView);
        }
    });

</script>
@endpush
