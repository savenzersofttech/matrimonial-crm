@extends('layouts.sb2-layout')
@section('title', 'Add Employee')
@section('meta_description', 'Add a new employee to the system.')
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
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.employees.store') }}" method="POST" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Add Employee</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name <small class="text-danger">*</small></label>
                                            <input type="text" name="first_name"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                value="{{ old('first_name') }}" placeholder="First name" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name <small class="text-danger">*</small></label>
                                            <input type="text" name="last_name"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                value="{{ old('last_name') }}" required placeholder="Last name">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email <small class="text-danger">*</small></label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" required placeholder="Email">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone <small class="text-danger">*</small></label>
                                            <input type="text" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}" required placeholder="Phone">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Password <small class="text-danger">*</small></label>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror" required
                                                placeholder="Password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Confirm Password <small class="text-danger">*</small></label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                required placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" name="dob"
                                                class="form-control @error('dob') is-invalid @enderror"
                                                value="{{ old('dob') }}">
                                            @error('dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>PAN number </label>
                                            <input type="text" name="pan_number"
                                                class="form-control @error('pan_number') is-invalid @enderror"
                                                value="{{ old('pan_number') }}" placeholder="PAN number" maxlength="10">
                                            @error('pan_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Aadhar Number</label>
                                            <input type="text" name="aadhar_number"
                                                class="form-control purchase-code @error('aadhar_number') is-invalid @enderror"
                                                value="{{ old('aadhar_number') }}" placeholder="xxxx-xxxx-xxxx"
                                                maxlength="12">
                                            @error('aadhar_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country </label>
                                            <input type="text" value="India" name="country"
                                                class="form-control @error('country') is-invalid @enderror"
                                                value="{{ old('country') }}" placeholder="Country">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>State </label>
                                            <input type="text" name="state"
                                                class="form-control @error('state') is-invalid @enderror"
                                                value="{{ old('state') }}" placeholder="State">
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>City </label>
                                            <input type="text" name="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                value="{{ old('city') }}" placeholder="City">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address Line </label>
                                            <input type="text" name="address_line"
                                                class="form-control @error('address_line') is-invalid @enderror"
                                                value="{{ old('address_line') }}" placeholder="Address Line">
                                            @error('address_line')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pincode </label>
                                            <input type="text" name="pincode"
                                                class="form-control @error('pincode') is-invalid @enderror"
                                                value="{{ old('pincode') }}" placeholder="Pincode">
                                            @error('pincode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role <small class="text-danger">*</small></label>
                                            <select name="role" class="form-control">
                                                <option value="0" selected disabled>--Select Role--</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ Str::ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <h5>Education Details</h5>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Highest Education </label>
                                            <input type="text" name="highest_education"
                                                class="form-control @error('highest_education') is-invalid @enderror"
                                                value="{{ old('highest_education') }}" placeholder="Highest Education">
                                            @error('highest_education')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Board/Institution </label>
                                            <input type="text" name="board"
                                                class="form-control @error('board') is-invalid @enderror"
                                                value="{{ old('board') }}" placeholder="Board/Institution">
                                            @error('board')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Course </label>
                                            <input type="text" name="course"
                                                class="form-control @error('course') is-invalid @enderror"
                                                value="{{ old('course') }}" placeholder="Course">
                                            @error('course')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Grade </label>
                                            <input type="text" name="grade"
                                                class="form-control @error('grade') is-invalid @enderror"
                                                value="{{ old('grade') }}" placeholder="Grade">
                                            @error('grade')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" name="edu_start_date"
                                                class="form-control @error('edu_start_date') is-invalid @enderror"
                                                value="{{ old('edu_start_date') }}">
                                            @error('edu_start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" name="edu_end_date"
                                                class="form-control @error('edu_end_date') is-invalid @enderror"
                                                value="{{ old('edu_end_date') }}">
                                            @error('edu_end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <h5>Past Employment Details</h5>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Organization Name</label>
                                            <input type="text" name="organization_name"
                                                class="form-control @error('organization_name') is-invalid @enderror"
                                                value="{{ old('organization_name') }}" placeholder="Organization Name">
                                            @error('organization_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Functional Unit</label>
                                            <input type="text" name="employment_functional_unit"
                                                class="form-control @error('employment_functional_unit') is-invalid @enderror"
                                                value="{{ old('employment_functional_unit') }}"
                                                placeholder="Functional Unit">
                                            @error('employment_functional_unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" name="employment_designation"
                                                class="form-control @error('employment_designation') is-invalid @enderror"
                                                value="{{ old('employment_designation') }}" placeholder="Designation">
                                            @error('employment_designation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Joining Salary</label>
                                            <input type="number" name="joining_salary"
                                                class="form-control @error('joining_salary') is-invalid @enderror"
                                                value="{{ old('joining_salary') }}" placeholder="Joining Salary">
                                            @error('joining_salary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Drawn Salary</label>
                                            <input type="number" name="last_salary"
                                                class="form-control @error('last_salary') is-invalid @enderror"
                                                value="{{ old('last_salary') }}">
                                            @error('last_salary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Joining Date</label>
                                            <input type="date" name="joining_date"
                                                class="form-control @error('joining_date') is-invalid @enderror"
                                                value="{{ old('joining_date') }}">
                                            @error('joining_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Relieving Date</label>
                                            <input type="date" name="relieving_date"
                                                class="form-control @error('relieving_date') is-invalid @enderror"
                                                value="{{ old('relieving_date') }}">
                                            @error('relieving_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <h5>Bank Details</h5>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank Name </label>
                                            <input type="text" name="bank_name"
                                                class="form-control @error('bank_name') is-invalid @enderror"
                                                value="{{ old('bank_name') }}" placeholder="Bank Name">
                                            @error('bank_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Account Type </label>
                                            <input type="text" name="account_type"
                                                class="form-control @error('account_type') is-invalid @enderror"
                                                value="{{ old('account_type') }}" placeholder="Account Type">
                                            @error('account_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Account Name </label>
                                            <input type="text" name="account_name"
                                                class="form-control @error('account_name') is-invalid @enderror"
                                                value="{{ old('account_name') }}" placeholder="Account Name">
                                            @error('account_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Account Number </label>
                                            <input type="text" name="account_number"
                                                class="form-control @error('account_number') is-invalid @enderror"
                                                value="{{ old('account_number') }}" placeholder="Account Number">
                                            @error('account_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>IFSC Code </label>
                                            <input type="text" name="ifsc"
                                                class="form-control @error('ifsc') is-invalid @enderror"
                                                value="{{ old('ifsc') }}" placeholder="IFSC Code">
                                            @error('ifsc')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Branch Name </label>
                                            <input type="text" name="branch_name"
                                                class="form-control @error('branch_name') is-invalid @enderror"
                                                value="{{ old('branch_name') }}" placeholder="Branch Name">
                                            @error('branch_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Upload Document </label>
                                            <input type="file" name="bank_file"
                                                class="form-control @error('bank_file') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png" placeholder="Upload Bank Document">
                                            <small class="form-text text-muted">Note: upload only pdf, jpg or png files.
                                                Max size 5MB.</small>
                                            @error('bank_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <h5>Internal Payroll Details</h5>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Supervisor ID </label>
                                            <input type="text" name="supervisor_id"
                                                class="form-control @error('supervisor_id') is-invalid @enderror"
                                                value="{{ old('supervisor_id') }}" placeholder="Supervisor ID">
                                            @error('supervisor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Designation </label>
                                            <input type="text" name="payroll_designation"
                                                class="form-control @error('payroll_designation') is-invalid @enderror"
                                                value="{{ old('payroll_designation') }}" placeholder="Designation">
                                            @error('payroll_designation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Functional Unit </label>
                                            <input type="text" name="payroll_functional_unit"
                                                class="form-control @error('payroll_functional_unit') is-invalid @enderror"
                                                value="{{ old('payroll_functional_unit') }}"
                                                placeholder="Functional Unit">
                                            @error('payroll_functional_unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Band </label>
                                            <input type="text" name="band"
                                                class="form-control @error('band') is-invalid @enderror"
                                                value="{{ old('band') }}" placeholder="Band">
                                            @error('band')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Joining Date </label>
                                            <input type="date" name="payroll_joining_date"
                                                class="form-control @error('payroll_joining_date') is-invalid @enderror"
                                                value="{{ old('payroll_joining_date') }}">
                                            @error('payroll_joining_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Offered Salary </label>
                                            <input type="number" name="offered_salary"
                                                class="form-control @error('offered_salary') is-invalid @enderror"
                                                value="{{ old('offered_salary') }}" placeholder="Offered Salary">
                                            @error('offered_salary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Salary Revision </label>
                                            <input type="date" name="last_salary_revision"
                                                class="form-control @error('last_salary_revision') is-invalid @enderror"
                                                value="{{ old('last_salary_revision') }}">
                                            @error('last_salary_revision')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Latest Salary </label>
                                            <input type="number" name="latest_salary"
                                                class="form-control @error('latest_salary') is-invalid @enderror"
                                                value="{{ old('latest_salary') }}" placeholder="Latest Salary">
                                            @error('latest_salary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Salary Revision Count </label>
                                            <input type="number" name="salary_revision_count"
                                                class="form-control @error('salary_revision_count') is-invalid @enderror"
                                                value="{{ old('salary_revision_count') }}"
                                                placeholder="Salary Revision Count">
                                            @error('salary_revision_count')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Level Increase Count </label>
                                            <input type="number" name="level_increase_count"
                                                class="form-control @error('level_increase_count') is-invalid @enderror"
                                                value="{{ old('level_increase_count') }}"
                                                placeholder="Level Increase Count">
                                            @error('level_increase_count')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Resign Date</label>
                                            <input type="date" name="resign_date"
                                                class="form-control @error('resign_date') is-invalid @enderror"
                                                value="{{ old('resign_date') }}">
                                            @error('resign_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Working Date</label>
                                            <input type="date" name="last_working_date"
                                                class="form-control @error('last_working_date') is-invalid @enderror"
                                                value="{{ old('last_working_date') }}">
                                            @error('last_working_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Relieving Date</label>
                                            <input type="date" name="payroll_relieving_date"
                                                class="form-control @error('payroll_relieving_date') is-invalid @enderror"
                                                value="{{ old('payroll_relieving_date') }}">
                                            @error('payroll_relieving_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>













                                </div>


                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      <main>
    @endsection

    @push('script')
        <script>
            document.querySelector('input[name="pan_number"]').addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        </script>
    @endpush
