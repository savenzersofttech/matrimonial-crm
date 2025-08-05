@extends('layouts.sb2-layout')
@section('title', 'All Lead')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"></div>
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
                <table id="datatablesSimple" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">ID</th>
                            <th>Photo </th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Created On</th>
                            {{-- <th class="text-center">Status</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="FormModalgx" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FormModalgxLabel">Add New</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="regForm" method="POST" action="{{ route($role . '.profiles.store') }}"
                        callbackSuccessFn="closeModal" enctype="multipart/form-data" class="needs-validation"
                        novalidate>
                        @csrf
                        <!-- Personal Details -->
                        <div class="row g-3">
                            <div class="col-12 col-md-12">
                                <label class="form-label">Profile Source<sup class="text-danger">*</sup></label>
                                <select name="profile_source_id" class="virtualSelect" id="profile_source_id"
                                    placeholder="Profile Source" required>
                                    <option value="" disabled hidden selected>Profile Source</option>
                                    @foreach ($ProfileSource as $option)
                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <div class="invalid-feedback">Please select a profile source.</div> --}}
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label">Profile Source Info</label>
                                <input type="text" name="profile_source_comment" class="form-control"
                                    placeholder="E.g. Matrimony Profile Link, Website Enquiry ID, Reference by John, Instagram Ad, Walk-in at Delhi Office">
                                <small class="form-text text-muted">
                                    Add specific details like profile link, enquiry ID, or name of the referrer (if
                                    applicable).
                                </small>
                            </div>
                        </div>
                        <h5 class="mt-4">Contact Information</h5>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="example@email.com">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Alternative Email</label>
                                <input type="email" name="alternative_email" class="form-control"
                                    placeholder="example@email.com">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Phone Number <sup class="text-danger">*</sup></label>
                                <input type="tel" id="phone_number" name="phone_number" class="form-control" required
                                    placeholder="Enter phone number">
                                {{-- <div class="invalid-feedback">Please enter a valid phone number</div> --}}
                                <input type="hidden" name="phone_code" id="phone_code">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Alternative Phone Number</label>
                                <input type="tel" id="alternative_phone_number" name="alternative_phone_number"
                                    class="form-control" placeholder="Enter alternative phone number">
                                <input type="hidden" name="alternative_phone_code" id="alternative_phone_code">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Contact Person</label>
                                <input id="contact_person" type="text" name="contact_person_name" class="form-control"
                                    placeholder="Enter contact person name">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Profile Creating For</label>
                                <select id="profile_for" name="profile_for" class="virtualSelect">
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach (profileCreateOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h5 class="mt-4">Client’s Basic Information</h5>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Full Name <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter full name"
                                    required>
                                {{-- <div class="invalid-feedback">Please enter a name</div> --}}
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Gender <sup class="text-danger">*</sup></label>
                                <select name="gender" id="gender" class="virtualSelect" placeholder="Select Gender"
                                    required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                {{-- <div class="invalid-feedback">Please select gender</div> --}}
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Marital Status</label>
                                <select name="marital_status" id="marital_status" placeholder="Select Status"
                                    class="virtualSelect">
                                    <option value="" disabled selected hidden>Select</option>
                                    @foreach (getMaritalStatusOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Height</label>
                                <select class="virtualSelect" name="height" id="height" placeholder="Select Height">
                                    <option value="" disabled selected hidden>Select</option>
                                    @php
                                    $usedHeights = [];
                                    @endphp
                                    @for ($cm = 122; $cm <= 213; $cm++) @php $inches=round($cm / 2.54);
                                        $feet=floor($inches / 12); $remainingInches=$inches % 12;
                                        $display="{$feet}ft {$remainingInches}in - {$cm}cm" ;
                                        $key="{$feet}ft {$remainingInches}in" ; @endphp @if (!in_array($key,
                                        $usedHeights)) <option value="{{ $display }}">{{ $display }}</option>
                                        @php
                                        $usedHeights[] = $key;
                                        @endphp
                                        @endif
                                        @endfor
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Mother Tongue</label>
                                <select id="mother_tongue" name="mother_tongue" class="virtualSelect">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach ($tounges as $tongue)
                                    <option value="{{ $tongue->name }}">{{ $tongue->name }}</option>
                                    @endforeach
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Weight</label>
                                <input type="number" id="weight" placeholder="Enter weight" name="weight"
                                    class="form-control">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Body Type</label>
                                <select id="body_type" name="body_type" class="virtualSelect"
                                    placeholder="Select Body Type">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (bodyTypeOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Complexion</label>
                                <select id="complexion" name="complexion" class="virtualSelect">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (complexionOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Blood Group</label>
                                <select id="blood_group" name="blood_group" class="virtualSelect"
                                    placeholder="Select Blood Group">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (bloodGroupOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Health/ Status</label>
                                <select id="health_status" name="health_status" class="virtualSelect"
                                    placeholder="Select Health Status">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (getHealthStatusOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Native Place</label>
                                <input type="text" id="native_place" name="native_place" class="form-control"
                                    placeholder="Enter native place">
                            </div>
                            <div class="col-md-4">
                                <label for="country">Country</label>
                                <select id="country" name="country" class="virtualSelect" placeholder="Select Country">
                                    <option selected disabled>Select Country</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="state">State</label>
                                <select id="state" name="state" class="virtualSelect" placeholder="Select State">
                                    <option selected disabled>Select State</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="city">City</label>
                                <select id="city" name="city" class="virtualSelect" placeholder="Select City">
                                    <option selected disabled>Select City</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Citizenship</label>
                                <select id="citizenship" name="citizenship" class="virtualSelect"
                                    placeholder="Select Citizenship">
                                    <option value="" disabled hidden selected>Select</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Country Grew up</label>
                                <select id="grow_up" name="grow_up_in" class="virtualSelect"
                                    placeholder="Select Grow Up Location">
                                    <option value="" disabled hidden selected>Select</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold"><strong>Upload Govt ID</strong></label>

                                <div class="input-group">
                                    <input id="govt_id" type="file" name="government_id[]" class="form-control"
                                        accept=".jpg, .jpeg, .png, .pdf" multiple>

                                    <!-- Verification Status -->
                                    <select name="govt_id_status" class="form-select" style="max-width: 150px;">
                                        <option value="1">Verified</option>
                                        <option value="0" selected>Non-Verified</option>
                                    </select>
                                </div>

                                <div id="preview-govt" class="mt-2 d-flex flex-wrap gap-2"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold"><strong>Upload Photo </strong>
                                    <span class="text-danger">(maximum 5 photos)</span>
                                </label>
                                <input id="photo" type="file" name="photo[]" class="form-control"
                                    accept=".jpg, .jpeg, .png" multiple>
                                <div id="preview-photo" class="mt-2 d-flex flex-wrap gap-2"></div>
                            </div>
                            <style>
                                .preview-container {
                                    width: 100px;
                                    height: 100px;
                                    position: relative;
                                    background: #f9f9f9;
                                    border: 1px solid #ccc;
                                    border-radius: 4px;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                }

                                .preview-container img {
                                    max-width: 100%;
                                    max-height: 100%;
                                    object-fit: contain;
                                }
                                .delete-icon {
                                    position: absolute;
                                    top: -6px;
                                    right: -6px;
                                    background: red;
                                    color: white;
                                    border-radius: 50%;
                                    font-size: 14px;
                                    padding: 0 5px;
                                    cursor: pointer;
                                    z-index: 1;
                                }
                            </style>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Password</label>
                                <input id="password" type="text" name="password" class="form-control"
                                    placeholder="Enter password">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input id="password_confirmation" type="text" name="password_confirmation"
                                    class="form-control" placeholder="Confirm password">
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label fw-bold">Write down about yourself <span class="text-muted">(at
                                        least 200 words)</span></label>
                                <textarea id="bio" name="bio" class="form-control" rows="3"
                                    placeholder="write down about your self atleast 200 words"></textarea>
                            </div>
                        </div>
                        <h4 class="mt-4">Religious Information</h4>
                        <div class="row g-3">
                            <!--  Religion -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Religion</label>
                                <select id="religion" name="religion" class="virtualSelect"
                                    placeholder="Select Religion">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach ($religion as $option)
                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                    @endforeach
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <!--  Caste (Grouped statically) -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Caste</label>
                                <select id="caste" name="caste" class="virtualSelect" placeholder=" Select Caste">
                                    <option value="" disabled selected>Select </option>
                                </select>
                            </div>
                            <!-- Your Religion -->
                            <!--<div class="col-12 col-md-6">-->
                            <!--    <label class="form-label">Religion</label>-->
                            <!--    <select id="religion" name="religion[]" class="virtualSelect" multiple>-->
                            <!--        <option value="" disabled selected>Select</option>-->
                            <!--        @foreach ($religion as $option) -->
                            <!--            <option value="{{ $option->name }}">{{ $option->name }}</option>-->
                            <!--
                                @endforeach-->
                            <!--    </select>-->
                            <!--</div>-->
                            <!-- Your Caste -->
                            <!--<div class="col-12 col-md-6">-->
                            <!--    <label class="form-label">Caste</label>-->
                            <!--    <select id="caste" name="caste[]" class="virtualSelect" multiple>-->
                            <!--        <option value="" disabled selected>Select caste</option>-->
                            <!--    </select>-->
                            <!--</div>-->

                            <div class="col-12 col-md-6">
                                <label class="form-label">Sub Caste</label>
                                <input id="sub_caste" type="text" name="sub_caste" class="form-control"
                                    placeholder="Enter sub caste">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Gotra</label>
                                <input id="gotra" type="text" name="gotra" class="form-control"
                                    placeholder="Enter gotra">
                                <!--<select id="gotra" name="gotra" class="virtualSelect"-->
                                <!--    placeholder="Select Gotra">-->
                                <!--    <option value="" disabled hidden selected>Select</option>-->
                                <!--    @foreach ($gotras as $option) -->
                                <!--        <option value="{{ $option->name }}">{{ $option->name }}</option>-->
                                <!--    @endforeach-->
                                <!--</select>-->
                            </div>
                        </div>
                        <h4 class="mt-4">Horoscope Information</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label">Time of Birth</label>
                                <input id="birth_time" type="time" name="birth_time" class="form-control"
                                    placeholder="Enter birth time">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Place of Birth</label>
                                <input id="birth_place" type="text" name="birth_place" class="form-control"
                                    placeholder="Enter birth place">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Manglik Status</label>
                                <select id="manglik" name="manglik_status" class="virtualSelect"
                                    placeholder="Select Manglik Status">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (manglikOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h4 class="mt-4">Educational & Career Information</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Highest Qualification</label>
                                <select id="highest_qualification" name="highest_qualification[]" class="virtualSelect"
                                    placeholder="Select Qualification" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (getEducationLevels() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Education Field</label>
                                <select id="education_field" name="education_field[]" class="virtualSelect"
                                    placeholder="Select Education Field" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (getEducationFieldOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Name of Institute</label>
                                <input id="college_university" type="text" name="institute_name" class="form-control"
                                    placeholder="Enter college or university name">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Work Location</label>
                                <input id="work_location" type="text" name="work_location" class="form-control"
                                    placeholder="Enter work location">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Working With</label>
                                <select id="employer_name" name="employer_name" class="virtualSelect">
                                    <option value="" disabled selected>Select work type</option>
                                    <option value="Private Company">Private Company</option>
                                    <option value="Government / Public Sector">Government / Public Sector</option>
                                    <option value="Defense / Civil Services">Defense / Civil Services</option>
                                    <option value="Business / Self Employed">Business / Self Employed</option>
                                    <option value="Not Working">Not Working</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Profession</label>
                                <select id="profession" name="profession[]" class="virtualSelect"
                                    placeholder="Select Profession" multiple="">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (getOccupationOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Business/Company Name</label>
                                <input id="business_company_name" type="text" name="business_name" class="form-control"
                                    placeholder="Enter business or company name">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Designation</label>
                                <input id="designation" type="text" name="designation" class="form-control"
                                    placeholder="Enter designation">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Income Range</label>
                                <select id="annual_income" name="annual_income" class="virtualSelect"
                                    placeholder="Select Annual Income">
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Prefer not to disclose">Prefer not to disclose</option>

                                    @foreach (getIncomeRanges() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h4 class="mt-4">Lifestyle Information</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Diet</label>
                                <select id="diet" name="diet" class="virtualSelect" placeholder="Select Diet"="">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (getDietOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Drinking</label>
                                <select id="drinking" name="drinking_status" class="virtualSelect"
                                    placeholder="Select Drinking Status">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (getDrinkingOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Smoking</label>
                                <select id="smoking" name="smoking_status" class="virtualSelect"
                                    placeholder="Select Smoking Status">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (getSmokingOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h4 class="mt-4">Family Information</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Father's Occupation</label>
                                <select id="father_occupation" name="father_occupation" class="virtualSelect"
                                    placeholder="Select Father's Occupation">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (fatherOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Mother's Occupation</label>
                                <select id="mother_occupation" name="mother_occupation" class="virtualSelect"
                                    placeholder="Select Mother's Occupation">
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (motherOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <label for="brothers">Number of Brothers</label>
                                <select name="brother_count" id="brothers" class="form-control">
                                    @for ($i = 0; $i <= 5; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6 mt-2 married_brothers">
                                <label for="married_brothers">Married Brothers</label>
                                <select name="married_brother_count" id="married_brothers" class="form-control">
                                    <option value="" disabled>-- Select --</option>
                                    @for ($i = 0; $i <= 5; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <label for="sisters">Number of Sisters</label>
                                <select name="sister_count" id="sisters" class="form-control">
                                    <option value="" disabled>--Select --</option>
                                    @for ($i = 0; $i <= 5; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6 mt-2 married_sisters">
                                <label for="married_sisters">Married Sisters</label>
                                <select name="married_sister_count" id="married_sisters" class="form-control">
                                    <option value="" disabled>-- Select --</option>
                                    @for ($i = 0; $i <= 5; $i++) <option value="{{ $i }}">
                                        {{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <label for="family_type">Family Type</label>
                                <select class="virtualSelect m-2" id="family_type" name="family_type"
                                    placeholder="Select Family Type">
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach (getFamilyTypeOptions() as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <label for="family_affluence">Family Affluence</label>
                                <select class="virtualSelect m-2" id="family_affluence" name="family_affluence"
                                    placeholder="Select Family Affluence">
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach (getFamilyAffluenceOptions() as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <label for="family_values">Family Values</label>
                                <select class="virtualSelect m-2" id="family_values" name="family_values"
                                    placeholder="Select Family Values">
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach (getFamilyValuesOptions() as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12 mt-2">
                                <label class="form-label fw-bold">Write Down about your family <span
                                        class="text-muted">(at least 200 words)</span></label>
                                <textarea class="form-control" id="family_bio" name="family_bio" rows="3"
                                    placeholder="Enter family bio/intro"></textarea>
                            </div>
                        </div>
                        <h2 class="mt-4">Partner Preference</h2>
                        <h4 class="mt-1">Basic Preferences</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Min Age</label>
                                <select class="virtualSelect m-2" name="partner[min_age]"
                                    placeholder="Select Minimum Age">
                                    <option value="" disabled selected>Minimum Age</option>
                                    @for ($i = 18; $i <= 100; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Max Age</label>
                                <select class="virtualSelect m-2" name="partner[max_age]"
                                    placeholder="Select Maximum Age">
                                    <option value="" disabled selected>Select</option>
                                    @for ($i = 18; $i <= 100; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Min Height</label>
                                <select class="virtualSelect" name="partner[min_height]" id="partner_min_height"
                                    placeholder="Select Height">
                                    <option value="" disabled selected hidden>Select</option>
                                    @php
                                    $usedHeights = [];
                                    @endphp
                                    @for ($cm = 122; $cm <= 213; $cm++) @php $inches=round($cm / 2.54);
                                        $feet=floor($inches / 12); $remainingInches=$inches % 12;
                                        $display="{$feet}ft {$remainingInches}in - {$cm}cm" ;
                                        $key="{$feet}ft {$remainingInches}in" ; @endphp @if (!in_array($key,
                                        $usedHeights)) <option value="{{ $display }}">{{ $display }}</option>
                                        @php
                                        $usedHeights[] = $key;
                                        @endphp
                                        @endif
                                        @endfor
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Max Height</label>
                                <select class="virtualSelect" name="partner[max_height]" id="partner_max_height"
                                    placeholder="Select Height">
                                    <option value="" disabled selected hidden>Select</option>
                                    @php
                                    $usedHeights = [];
                                    @endphp
                                    @for ($cm = 122; $cm <= 213; $cm++) @php $inches=round($cm / 2.54);
                                        $feet=floor($inches / 12); $remainingInches=$inches % 12;
                                        $display="{$feet}ft {$remainingInches}in - {$cm}cm" ;
                                        $key="{$feet}ft {$remainingInches}in" ; @endphp @if (!in_array($key,
                                        $usedHeights)) <option value="{{ $display }}">{{ $display }}</option>
                                        @php
                                        $usedHeights[] = $key;
                                        @endphp
                                        @endif
                                        @endfor
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Marital Status</label>
                                <select name="partner[marital_status][]" id="partner_marital_status" multiple
                                    placeholder="Select Status" class="virtualSelect">
                                    <option value="" disabled selected hidden>Select</option>
                                    <option value="Open to All">Open to All</option>
                                    @foreach (getMaritalStatusOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <!-- Partner's Religion -->
                            <!--<div class="col-12 col-md-6">-->
                            <!--    <label class="form-label">Partner Religion</label>-->
                            <!--    <select id="partner_religion" name="partner_religion[]" class="virtualSelect" multiple>-->
                            <!--        @foreach ($religion as $option) -->
                            <!--            <option value="{{ $option->name }}">{{ $option->name }}</option>-->
                            <!--        @endforeach-->
                            <!--    </select>-->
                            <!--</div>-->
                            <!-- Partner's Caste -->
                            <!--<div class="col-12 col-md-6">-->
                            <!--    <label class="form-label">Partner Caste</label>-->
                            <!--    <select id="partner_caste" name="partner_caste[]" class="virtualSelect" multiple>-->
                            <!--        <option value="" disabled selected>Select caste</option>-->
                            <!--    </select>-->
                            <!--</div>-->

                            <!-- Partner Religion -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Partner Religion</label>
                                <select id="partner_religion" name="partner[partner_religion]" class="virtualSelect"
                                    multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to all">Open to all</option>

                                    @foreach (religionOption() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Partner Caste (Grouped statically) -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Partner Caste</label>
                                <select id="partner_caste" name="partner[partner_caste]" class="virtualSelect" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to all">Open to all</option>

                                    @foreach (casteOption() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Manglik Status</label>
                                <select id="partner_manglik" name="partner[manglik_status]" class="virtualSelect"
                                    multiple placeholder="Select Manglik Status">
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to all">Open to all</option>
                                    @foreach (manglikOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h4 class="mt-4">Partner Location Preferences</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Country</label>
                                <select id="partner_country" name="partner[country]" class="virtualSelect"
                                    placeholder="Select Country" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">State</label>
                                <select id="partner_state" name="partner[state]" class="virtualSelect"
                                    placeholder="Select State" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">City</label>
                                <select id="partner_city" name="partner[city]" class="virtualSelect"
                                    placeholder="Select City" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Citizenship</label>
                                <select id="partner_citizenship" name="partner[citizenship]" class="virtualSelect"
                                    placeholder="Select Citizenship">
                                    <option value="" disabled hidden selected>Select</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Country Grew up</label>
                                <select id="partner_grow_up" name="partner[grow_up_in][]" class="virtualSelect" multiple
                                    placeholder="Select Grow Up Location">
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to All">Open to All</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="mt-4">Partner Education & Career Preferences</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Highest Qualification</label>
                                <select id="partner_highest_qualification" name="partner[highest_qualification]"
                                    class="virtualSelect" placeholder="Select Highest Qualification" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to All">Open to All</option>
                                    @foreach (getEducationLevels() as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Education Field</label>
                                <select id="partner_education_field" name="partner[education_field]"
                                    class="virtualSelect" placeholder="Select Education Field" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to All">Open to All</option>
                                    @foreach (getEducationFieldOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Partner Working With</label>
                                <select id="partner_working_with" name="partner[employer_name]" class="virtualSelect"
                                    multiple>
                                    <option value="" disabled selected>Select work type</option>
                                    <option value="Open to All">Open to All</option>
                                    <option value="Private Company">Private Company</option>
                                    <option value="Government / Public Sector">Government / Public Sector</option>
                                    <option value="Defense / Civil Services">Defense / Civil Services</option>
                                    <option value="Business / Self Employed">Business / Self Employed</option>
                                    <option value="Not Working">Not Working</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Profession</label>
                                <select id="partner_profession" name="partner[profession]" class="virtualSelect"
                                    placeholder="Select Profession" multiple="">
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to All">Open to All</option>
                                    @foreach (getOccupationOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Designation</label>
                                <input id="partner_designation" type="text" name="partner[designation]" class="form-control" placeholder="Enter designation">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Annual Income</label>
                                <select id="partner_annual_income" name="partner[annual_income]" class="virtualSelect"
                                    placeholder="Select Annual Income" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to All">Open to All</option>
                                    @foreach (getIncomeRanges() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h4 class="mt-4">Partner Lifestyle Preferences</h4>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Diet</label>
                                <select id="partner_diet" name="partner[diet]" class="virtualSelect"
                                    placeholder="Select Diet" multiple>
                                    <option value="Open to all">Open to all</option>
                                    <option value="" disabled hidden selected>Select</option>
                                    @foreach (getDietOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Drinking</label>
                                <select id="partner_drinking" name="partner[drinking_status]" class="virtualSelect"
                                    placeholder="Select Drinking Status" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to all">Open to all</option>
                                    @foreach (getDrinkingOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Smoking</label>
                                <select id="partner_smoking" name="partner[smoking_status]" class="virtualSelect"
                                    placeholder="Select Smoking Status" multiple>
                                    <option value="" disabled hidden selected>Select</option>
                                    <option value="Open to all">Open to all</option>
                                    @foreach (getSmokingOptions() as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label">Write About your Partner preference</label>
                                <textarea id="partner_about" name="partner[about]" class="form-control"
                                    placeholder="Write about your partner preference" rows="3"></textarea>
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
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('/assets/sb2/js/profilehandel.js') }}"></script>
@endpush

@push('scripts')
<script>
    let configration;
    const $form = $('#regForm');
    const routeIndex = "{{ route($role . '.profiles.index') }}";
    const updateUrl = @json(route($role . '.profiles.update', ['profile' => '__ID__']));
    let phoneIti, altPhoneIti; // Declare variables in a higher scope

    document.addEventListener("DOMContentLoaded", function() {
        // Initialize VirtualSelect for all select elements
        VirtualSelect.init({
            ele: '.virtualSelect',
            search: true,
            multiple: true, // Default to multiple for fields that support it
            placeholder: 'Select'
        });

        // Custom validation rule for married siblings
        $.validator.addMethod("marriedLessThanTotal", function(value, element, params) {
            const total = $(params).val();
            return parseInt(value) <= parseInt(total);
        }, "Value cannot be greater than total.");

        // Initialize International Telephone Input
        const phoneInput = document.querySelector("#phone_number");
        phoneIti = window.intlTelInput(phoneInput, {
            initialCountry: "in",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.5.0/build/js/utils.js",
            separateDialCode: true
        });

        const altPhoneInput = document.querySelector("#alternative_phone_number");
        altPhoneIti = window.intlTelInput(altPhoneInput, {
            initialCountry: "in",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.5.0/build/js/utils.js",
            separateDialCode: true
        });

        // Form submission validation for phone numbers
        $form.on('submit', function(event) {
            if (phoneInput.value.trim()) {
                phoneInput.value = phoneIti.getNumber();
            }
            if (altPhoneInput.value.trim()) {
                altPhoneInput.value = altPhoneIti.getNumber();
            }
            if (phoneInput.value.trim() && !phoneIti.isValidNumber()) {
                phoneInput.classList.add('is-invalid');
                event.preventDefault();
                event.stopPropagation();
            } else {
                phoneInput.classList.remove('is-invalid');
            }
            if (altPhoneInput.value.trim() && !altPhoneIti.isValidNumber()) {
                altPhoneInput.classList.add('is-invalid');
                event.preventDefault();
                event.stopPropagation();
            } else {
                altPhoneInput.classList.remove('is-invalid');
            }
            $form.addClass('was-validated');
        });

        // DataTable configuration
        let colDefs = [{
            targets: 0,
            className: 'text-center',
            orderable: false,
            searchable: false,
            width: '50px',
            render: function(e, t, a, s) {
                return a.s_no;
            }
        }, {
            targets: -1,
            title: "Actions",
            orderable: false,
            searchable: false,
            render: function(e, t, a, s) {
                tableData[a.id] = a;
                return `
                    <a target="_blank" href="${routeIndex}/${a.id}"
                        class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                        aria-label="View User"
                        title="View"><i class="fas fa-eye"></i></a>
                    <button type="button" data-id="index_${a.id}" onclick="openEditModal(${a.id}, this, event)"
                        class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                        aria-label="Edit User"
                        title="Edit"><i class="fas fa-pen"></i></button>
                    <button type="button" data-id="${a.id}"
                        data-href="{{ route($role . '.profiles.destroy', ':id') }}"
                        onclick="deleteConfirmation(this, event)"
                        class="btn btn-datatable btn-icon btn-transparent-dark"
                        aria-label="Delete User"
                        title="Delete"><i class="far fa-trash-can"></i></button>
                `;
            }
        }];

        configration = {
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "{{ route('admin.profiles.showAll') }}",
                type: 'POST',
            },
            columns: [
                { data: 's_no' },
                { data: 'profile_id', width: '100px' },
                {
                    data: null,
                    render: function(data, type, row) {
                        let photoArray = [];
                        try {
                            photoArray = JSON.parse(row.photo || '[]');
                        } catch (e) {
                            photoArray = [];
                        }
                        let photoPath = photoArray.length > 0 ? photoArray[0] : null;
                        let imageUrl = photoPath
                            ? `/storage/${photoPath.replace(/\\/g, '')}`
                            : `/assets/sb2/assets/img/illustrations/profiles/profile-1.png`;
                        return `
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="${imageUrl}" alt="Photo" width="60" height="60"
                                    onerror="this.onerror=null;this.src='/assets/sb2/assets/img/illustrations/profiles/profile-1.png';"
                                    style="object-fit: cover; border-radius: 50%;">
                            </div>
                        `;
                    },
                    orderable: false,
                    searchable: true
                },
                { data: 'name' },
                { data: 'phone_number' },
                { data: 'email' },
                { data: 'created_at', orderable: false, searchable: false },
                { data: 'created_at', orderable: false, searchable: false }
            ],
            columnDefs: colDefs || [],
            lengthMenu: [[10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]]
        };

        $(regForm).validate(validationConfig);

        // Load countries
        $.get("https://countriesnow.space/api/v0.1/countries/positions", function(data) {
            const countries = data.data.map(c => ({
                label: c.name,
                value: c.name
            }));
            document.querySelector('#country').setOptions(countries);
            document.querySelector('#citizenship').setOptions(countries);
            document.querySelector('#grow_up').setOptions(countries);
            countries.push({ label: 'Open to All', value: 'Open to All' });
            document.querySelector('#partner_grow_up').setOptions(countries);
            document.querySelector('#partner_country').setOptions(countries);
            document.querySelector('#partner_citizenship').setOptions(countries);
        });

        // On country change -> Load states
        document.querySelector('#country').addEventListener('change', function() {
            const country = this.value;
            document.querySelector('#state').reset();
            document.querySelector('#city').reset();
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/states",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ country }),
                success: function(res) {
                    const states = res.data.states.map(s => ({
                        label: s.name,
                        value: s.name
                    }));
                    document.querySelector('#state').setOptions(states);
                }
            });
        });

        // On state change -> Load cities
        document.querySelector('#state').addEventListener('change', function() {
            const country = document.querySelector('#country').value;
            const state = this.value;
            document.querySelector('#city').reset();
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/state/cities",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ country, state }),
                success: function(res) {
                    const cities = res.data.map(c => ({
                        label: c,
                        value: c
                    }));
                    document.querySelector('#city').setOptions(cities);
                }
            });
        });

        // On religion change -> Load castes
        document.querySelector('#religion').addEventListener('change', async function() {
            const religionId = this.value;
            document.querySelector('#caste').reset();
            const formData = new FormData();
            formData.append('religionId', religionId);
            let op = [{ label: "Other", value: "0" }];
            try {
                const response = await makeHttpRequest(
                    "{{ route($role . '.profiles.showCasts') }}", "POST", formData, true);
                if (response.success && Array.isArray(response.casts)) {
                    const casteOptions = response.casts.map(item => ({
                        label: item.name,
                        value: item.id
                    }));
                    casteOptions.push({ label: "Other", value: "0" });
                    document.querySelector('#caste').setOptions(casteOptions);
                } else {
                    document.querySelector('#caste').setOptions(op);
                }
            } catch (error) {
                console.error('Error loading caste options:', error.message);
                document.querySelector('#caste').setOptions(op);
            }
        });
    });

    function openAddModal() {
        var FormModalgx = new bootstrap.Modal($('#FormModalgx')[0]);
        $('#FormModalgxLabel').text('Create Profile');
        $form.find('button[type="submit"]').text('Save');
        $form.find('input[name="_method"]').remove();
        $('#status').val('pending').closest('.mb-3').hide();
        $form[0].reset();
        $('.preview-container').remove();
        $form.find('.virtualSelect').each(function() {
            this.reset();
        });
        $form.attr('action', "{{ route($role . '.profiles.store') }}");
        FormModalgx.show();
    }

    function openEditModal(id, element, event) {
        event.preventDefault();
        const rowData = tableData[id];
        if (!rowData) return;
        console.log('Row Data:', rowData);

        $form[0].reset();
        $form.find('.virtualSelect').each(function() {
            this.reset();
        });
        $form.attr('action', updateUrl.replace('__ID__', rowData.id));
        $form.attr('method', 'POST');
        $('#FormModalgxLabel').text('Edit Profile');
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

        // Helper function to parse JSON strings safely
        function parseJson(value) {
            try {
                return JSON.parse(value || '[]');
            } catch (e) {
                return Array.isArray(value) ? value : [value];
            }
        }

        // Populate form fields
        $form.find('[name]:not([name=_token])').each(function() {
            const $el = $(this);
            const name = this.name;
            let value = rowData[name];

            // Skip password fields
            if (name === 'password' || name === 'password_confirmation') {
                $el.val('');
                return;
            }

            // Handle nested partner fields
            if (name.startsWith('partner[')) {
                const partnerKey = name.match(/partner\[([^\]]*)\]/)[1];
                value = rowData.partner ? rowData.partner[partnerKey] : null;
            }

            // Parse JSON for fields that are stored as arrays
            if (['highest_qualification', 'education_field', 'profession', 'grow_up_in', 'government_id', 'photo'].includes(name)) {
                value = parseJson(value);
            }

            // Handle phone numbers
            if (name === 'phone_number' && value && phoneIti) {
                phoneIti.setNumber(value);
                return;
            }
            if (name === 'alternative_phone_number' && value && altPhoneIti) {
                altPhoneIti.setNumber(value);
                return;
            }

            // Set value for VirtualSelect or regular inputs
            if ($el.hasClass('virtualSelect')) {
                if (value) {
                    // Handle single or multi-select
                    if (Array.isArray(value)) {
                        $el[0].setValue(value);
                    } else {
                        $el[0].setValue([value]);
                    }
                }
            } else {
                $el.val(value || '');
            }
        });

        // Populate government ID and photo previews
        const govtIds = parseJson(rowData.government_id);
        const photos = parseJson(rowData.photo);
        $('#preview-govt').empty();
        $('#preview-photo').empty();
        govtIds.forEach(id => {
            if (id) {
                $('#preview-govt').append(`
                    <div class="preview-container">
                        <img src="/storage/${id.replace(/\\/g, '')}" alt="Government ID">
                        <span class="delete-icon">×</span>
                    </div>
                `);
            }
        });
        photos.forEach(photo => {
            if (photo) {
                $('#preview-photo').append(`
                    <div class="preview-container">
                        <img src="/storage/${photo.replace(/\\/g, '')}" alt="Photo">
                        <span class="delete-icon">×</span>
                    </div>
                `);
            }
        });

        // Handle country, state, city cascading
        if (rowData.country) {
            $('#country')[0].setValue(rowData.country);
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/states",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ country: rowData.country }),
                success: function(res) {
                    const states = res.data.states.map(s => ({
                        label: s.name,
                        value: s.name
                    }));
                    $('#state')[0].setOptions(states);
                    if (rowData.state) {
                        $('#state')[0].setValue(rowData.state);
                        $.ajax({
                            url: "https://countriesnow.space/api/v0.1/countries/state/cities",
                            method: "POST",
                            contentType: "application/json",
                            data: JSON.stringify({ country: rowData.country, state: rowData.state }),
                            success: function(res) {
                                const cities = res.data.map(c => ({
                                    label: c,
                                    value: c
                                }));
                                $('#city')[0].setOptions(cities);
                                if (rowData.city) {
                                    $('#city')[0].setValue(rowData.city);
                                }
                            }
                        });
                    }
                }
            });
        }

        // Handle religion and caste
        if (rowData.religion) {
            $('#religion')[0].setValue(rowData.religion);
            const formData = new FormData();
            formData.append('religionId', rowData.religion);
            makeHttpRequest("{{ route($role . '.profiles.showCasts') }}", "POST", formData, true)
                .then(response => {
                    if (response.success && Array.isArray(response.casts)) {
                        const casteOptions = response.casts.map(item => ({
                            label: item.name,
                            value: item.id
                        }));
                        casteOptions.push({ label: "Other", value: "0" });
                        $('#caste')[0].setOptions(casteOptions);
                        if (rowData.caste) {
                            $('#caste')[0].setValue(rowData.caste);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading caste options:', error.message);
                });
        }

        // Show the modal
        new bootstrap.Modal($('#FormModalgx')[0]).show();
    }
</script>
@endpush