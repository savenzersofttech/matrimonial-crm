@extends('layouts.sb2-layout')
@section('title', 'Search Profiles')
@section('content')
    <main>
        <!-- Page Header -->
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-fluid px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="search"></i></div>
                                Search Profiles
                            </h1>
                            <div class="page-header-subtitle">Find profiles based on your criteria</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Page Content -->
        <div class="container-fluid px-4 mt-n10">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-header-actions h-100">
                        <div class="card-header">
                            Profile Search
                            <div class="dropdown no-caret">
                                <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="text-gray-500" data-feather="more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end animated--fade-in-up"
                                    aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" id="clearFilters">Clear Filters</a>
                                    <a class="dropdown-item" href="#">Save Search</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="searchForm">
                                @csrf
                                <div class="row">
                                    <!-- Personal Details -->
                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="name">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Enter name (e.g., Rah for Rahul)" value="{{ old('name') }}">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="gender">Gender</label>
                                        <select name="gender" id="gender" class="virtualSelect"
                                            placeholder="-- Select gender --">
                                            <option value="any">Any</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="marital_status">Marital Status</label>
                                        <select name="marital_status" id="marital_status" class="virtualSelect"
                                            placeholder="-- Select status --" multiple>
                                            <option value="Any">Any</option>
                                            <option value="Unmarried">Naver Married</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Separated">Separated</option>
                                            <option value="Awaiting Divorce">Awaiting Divorce</option>
                                            <option value="Annulled">Annulled</option>
                                        </select>
                                    </div>


                                    <div class="col-md-6 mb-4">
                                        <label class="small mb-1">Age Range</label>
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <select name="age_min" class="virtualSelect" placeholder="-- Select --">
                                                    <option value="0">Any</option>
                                                    @for ($i = 18; $i <= 60; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-2 text-center">to</div>
                                            <div class="col-md-5">
                                                <select name="age_max" class="virtualSelect" placeholder="-- Select --">
                                                     <option value="0">Any</option>
                                                    @for ($i = 18; $i <= 60; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="small mb-1">Height Range</label>
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <select name="height_min" class="virtualSelect" placeholder="-- Select --">
                                                     <option value="0">Any</option>
                                                    @for ($i = 122; $i <= 236; $i += 2)
                                                        <option value="{{ $i }}cm">
                                                            {{ floor($i / 30.48) }}ft
                                                            {{ round(($i / 30.48 - floor($i / 30.48)) * 12) }}in -
                                                            {{ $i }}cm
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-2 text-center">to</div>
                                            <div class="col-md-5">
                                                <select name="height_max" class="virtualSelect" placeholder="-- Select --">
                                                     <option value="0">Any</option>
                                                    @for ($i = 122; $i <= 236; $i += 2)
                                                        <option value="{{ $i }}cm">
                                                            {{ floor($i / 30.48) }}ft
                                                            {{ round(($i / 30.48 - floor($i / 30.48)) * 12) }}in -
                                                            {{ $i }}cm
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="religion">Religion</label>
                                        <select name="religion" id="religion" class="virtualSelect">
                                            <option value="">-- Select Religion --</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Muslim">Muslim</option>
                                            <option value="Christian">Christian</option>
                                            <option value="Sikh">Sikh</option>
                                            <option value="Parsi">Parsi</option>
                                            <option value="Jain">Jain</option>
                                            <option value="Buddhist">Buddhist</option>
                                            <option value="Jewish">Jewish</option>
                                            <option value="No Religion">No Religion</option>
                                            <option value="Spiritual - not religious">Spiritual - not religious</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="community">Community</label>
                                        <select name="community" id="community" class="virtualSelect">
                                            <option value="">-- Select Community --</option>
                                            <optgroup label="Hindu">
                                                <option value="Agarwal">Agarwal</option>
                                                <option value="Arora">Arora</option>
                                                <option value="Brahmin">Brahmin</option>
                                                <option value="Chaudhary">Chaudhary</option>
                                                <option value="Gupta">Gupta</option>
                                                <option value="Jat">Jat</option>
                                                <option value="Kayastha">Kayastha</option>
                                                <option value="Khatri">Khatri</option>
                                                <option value="Kshatriya">Kshatriya</option>
                                                <option value="Maratha">Maratha</option>
                                                <option value="Marwari">Marwari</option>
                                                <option value="Nair">Nair</option>
                                                <option value="Patel">Patel</option>
                                                <option value="Rajput">Rajput</option>
                                                <option value="Reddy">Reddy</option>
                                                <option value="Sindhi">Sindhi</option>
                                                <option value="Yadav">Yadav</option>
                                                <option value="Iyer">Iyer</option>
                                                <option value="Iyengar">Iyengar</option>
                                                <option value="Chettiar">Chettiar</option>
                                                <option value="Gounder">Gounder</option>
                                                <option value="Mudaliar">Mudaliar</option>
                                                <option value="Nadar">Nadar</option>
                                                <option value="Pillai">Pillai</option>
                                                <option value="Vokkaliga">Vokkaliga</option>
                                            </optgroup>
                                            <optgroup label="Muslim">
                                                <option value="Sunni">Sunni</option>
                                                <option value="Shia">Shia</option>
                                                <option value="Memon">Memon</option>
                                                <option value="Khoja">Khoja</option>
                                                <option value="Syed">Syed</option>
                                                <option value="Pathan">Pathan</option>
                                            </optgroup>
                                            <optgroup label="Christian">
                                                <option value="Catholic">Catholic</option>
                                                <option value="Protestant">Protestant</option>
                                                <option value="Born Again">Born Again</option>
                                                <option value="Orthodox">Orthodox</option>
                                            </optgroup>
                                            <optgroup label="Sikh">
                                                <option value="Ramgarhia">Ramgarhia</option>
                                                <option value="Jat Sikh">Jat Sikh</option>
                                                <option value="Khatri Sikh">Khatri Sikh</option>
                                            </optgroup>
                                            <optgroup label="Jain">
                                                <option value="Digambar">Digambar</option>
                                                <option value="Shwetambar">Shwetambar</option>
                                                <option value="Terapanthi">Terapanthi</option>
                                            </optgroup>
                                            <optgroup label="Other Communities">
                                                <option value="Parsi">Parsi</option>
                                                <option value="Zoroastrian">Zoroastrian</option>
                                                <option value="Other">Other</option>
                                            </optgroup>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="mother_tongue">Mother Tongue</label>
                                        <select name="mother_tongue" id="mother_tongue" class="virtualSelect" multiple>
                                            <option value="0">Any</option>
                                            @foreach ($tounges as $tongue)
                                                <option value="{{ $tongue->name }}">{{ $tongue->name }}</option>)
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="mother_tongue">Manglik Status</label>
                                        <select name="manglik[]" id="manglik" class="virtualSelect" multiple>
                                            <option value="0">Any</option>
                                            @foreach (manglikOptions() as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="education_level">Education Level</label>
                                        <select name="education_level[]" id="education_level" class="virtualSelect"
                                            multiple>
                                            <option value="0">Any</option>
                                            @foreach (getEducationLevels() as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="education_field">Education Field</label>
                                        <select name="education_field[]" id="education_field" class="virtualSelect"
                                            multiple>
                                            <option value="0">Any</option>
                                            @foreach (getEducationFieldOptions() as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="occupation">Job Sector</label>
                                        <select name="occupation[]" id="occupation" class="virtualSelect" multiple>
                                            <option value="0">Any</option>
                                            @foreach (getOccupationOptions() as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="annual_income">Annual Income</label>
                                        <select name="annual_income[]" id="income" class="virtualSelect" multiple>
                                            <option value="0">Any</option>
                                            @foreach (getIncomeRanges() as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>




                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="citizenship">Country</label>
                                        <select name="citizenship" id="citizenship" class="virtualSelect">
                                            <option value="">-- Select Country --</option>
                                            <option value="India">India</option>
                                            <option value="American">American</option>
                                            <option value="Canadian">Canadian</option>
                                            <option value="British">British</option>
                                            <option value="Australian">Australian</option>
                                            <option value="New Zealander">New Zealander</option>
                                            <option value="Singaporean">Singaporean</option>
                                            <option value="Pakistani">Pakistani</option>
                                            <option value="Bangladeshi">Bangladeshi</option>
                                            <option value="Nepalese">Nepalese</option>
                                            <option value="Sri Lankan">Sri Lankan</option>
                                            <option value="UAE">UAE</option>
                                            <option value="Saudi Arabian">Saudi Arabian</option>
                                            <option value="Qatari">Qatari</option>
                                            <option value="Kuwaiti">Kuwaiti</option>
                                            <option value="Malaysian">Malaysian</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="state">State</label>
                                        <input type="text" name="state" id="state" class="form-control"
                                            placeholder="Enter state">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="small mb-1" for="city">City</label>
                                        <input type="text" name="city" id="city" class="form-control"
                                            placeholder="Enter city">
                                    </div>

                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <button type="button" class="btn btn-transparent-dark" id="resetForm">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 mt-4">
                    <div class="card mb-4">
                        <div class="card-header">Search Results</div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="searchResults">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Religion</th>
                                        <th>Location</th>
                                        {{-- <th>Profile Source</th> --}}
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serializeArray();
                let searchParams = {};

                formData.forEach(({
                    name,
                    value
                }) => {
                    if (value && value !== "0" && value !== "any" && value !== "Any") {
                        if (searchParams[name]) {
                            if (Array.isArray(searchParams[name])) {
                                searchParams[name].push(value);
                            } else {
                                searchParams[name] = [searchParams[name], value];
                            }
                        } else {
                            searchParams[name] = value;
                        }
                    }
                });

                $.ajax({
                    url: '{{ route('services.reports.search') }}',
                    type: 'GET',
                    data: searchParams,
                    success: function(response) {
                        let tbody = $('#searchResults tbody');
                        tbody.empty();
                        if (response.data && response.data.length > 0) {
                            response.data.forEach(function(profile) {
                                let age = profile.dob ? Math.floor((new Date() -
                                    new Date(profile.dob)) / (365.25 * 24 * 60 *
                                    60 * 1000)) : 'N/A';
                                let location =
                                    `${profile.city ?? 'N/A'}, ${profile.state ?? 'N/A'}, ${profile.country ?? 'N/A'}`;
                                let row = `
                        <tr>
                            <td>${profile.name || 'N/A'}</td>
                            <td>${age}</td>
                            <td>${profile.gender || 'N/A'}</td>
                            <td>${profile.religion || 'N/A'}</td>
                            <td>${location}</td>
                            <td>
                                <a target="_blank" href="${profile.id ? '{{ route('admin.profiles.show', ':id') }}'.replace(':id', profile.id) : '#'}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>`;
                                tbody.append(row);
                            });
                        } else {
                            tbody.append(
                                '<tr><td colspan="7" class="text-center">No profiles found</td></tr>'
                                );
                        }
                    },
                    error: function(xhr) {
                        alert('Error searching profiles: ' + (xhr.responseJSON?.message ||
                            'Unknown error'));
                    }
                });
            });

            $('#resetForm, #clearFilters').on('click', function() {
                $('#searchForm')[0].reset();
                $('.virtualSelect').val(null).trigger('change');
                $('#searchResults tbody').empty();
            });
        });
    </script>
@endpush
