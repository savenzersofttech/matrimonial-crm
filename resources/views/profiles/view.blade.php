@extends('layouts.sb2-layout')
@section('title', 'View Profile')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title text-white">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            My Profile
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content -->
    <div class="container-fluid px-4 mt-4">
        <div class="row row-cols-1 g-4">
            <!-- Personal Details Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Personal Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <p><strong>Profile Source:</strong> <span class="text-muted">{{ $ProfileSource->firstWhere('id', $profile->profile_source_id)->name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Profile Source Info:</strong> <span class="text-muted">{{ $profile->profile_source_comment ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <p><strong>Email:</strong> <span class="text-muted">{{ $profile->email ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Alternative Email:</strong> <span class="text-muted">{{ $profile->alternative_email ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Phone Number:</strong> <span class="text-muted">{{ $profile->phone_number ? $profile->phone_code . ' ' . substr($profile->phone_number, strlen($profile->phone_code)) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Alternative Phone Number:</strong> <span class="text-muted">{{ $profile->alternative_phone_number ? $profile->alternative_phone_code . ' ' . substr($profile->alternative_phone_number, strlen($profile->alternative_phone_code)) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Contact Person:</strong> <span class="text-muted">{{ $profile->contact_person_name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Profile Creating For:</strong> <span class="text-muted">{{ $profile->profile_for ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client’s Basic Information Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Client’s Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <p><strong>Full Name:</strong> <span class="text-muted">{{ $profile->name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Gender:</strong> <span class="badge bg-success text-white">{{ $profile->gender ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Date of Birth:</strong> <span class="text-muted">{{ $profile->date_of_birth ? \Carbon\Carbon::parse($profile->date_of_birth)->format('d M Y') : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Marital Status:</strong> <span class="text-muted">{{ $profile->marital_status ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Height:</strong> <span class="text-muted">{{ $profile->height ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Mother Tongue:</strong> <span class="text-muted">{{ $profile->mother_tongue ? (is_array($mt = json_decode($profile->mother_tongue, true)) ? implode(', ', $mt) : $profile->mother_tongue) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Weight:</strong> <span class="text-muted">{{ $profile->weight ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Body Type:</strong> <span class="text-muted">{{ $profile->body_type ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Complexion:</strong> <span class="text-muted">{{ $profile->complexion ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Blood Group:</strong> <span class="text-muted">{{ $profile->blood_group ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Health Status:</strong> <span class="text-muted">{{ $profile->health_status ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Native Place:</strong> <span class="text-muted">{{ $profile->native_place ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Country:</strong> <span class="text-muted">{{ $profile->country ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>State:</strong> <span class="text-muted">{{ $profile->state ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>City:</strong> <span class="text-muted">{{ $profile->city ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Citizenship:</strong> <span class="text-muted">{{ $profile->citizenship ? (is_array($cit = json_decode($profile->citizenship, true)) ? implode(', ', $cit) : $profile->citizenship) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Country Grew Up:</strong> <span class="text-muted">{{ $profile->grow_up_in ? (is_array($gui = json_decode($profile->grow_up_in, true)) ? implode(', ', $gui) : $profile->grow_up_in) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Government ID:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    @php
                                        $govtIds = $profile->government_id ? json_decode($profile->government_id, true) : [];
                                    @endphp
                                    @if (!empty($govtIds))
                                        @foreach ($govtIds as $id)
                                            @if (preg_match('/\.(jpg|jpeg|png)$/i', $id))
                                                <div class="avatar">
                                                    <img class="avatar-img img-fluid" src="/storage/{{ $id }}" alt="Government ID">
                                                </div>
                                            @else
                                                <div class="preview-container">
                                                    <div style="text-align: center; font-size: 12px;">{{ basename($id) }}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                <p class="mt-2"><strong>Government ID Status:</strong> <span class="badge {{ $profile->govt_id_status ? 'bg-success' : 'bg-warning' }} text-white">{{ $profile->govt_id_status ? 'Verified' : 'Non-Verified' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Photo:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    @php
                                        $photos = $profile->photo ? json_decode($profile->photo, true) : [];
                                    @endphp
                                    @if (!empty($photos))
                                        @foreach ($photos as $photo)
                                            <div class="avatar">
                                                <img class="avatar-img img-fluid" src="/storage/{{ $photo }}" alt="Profile Photo">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="avatar">
                                            <img class="avatar-img img-fluid" src="{{ asset('assets/sb2/assets/img/illustrations/profiles/profile-1.png') }}" alt="No Photo">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <p><strong>About Yourself:</strong> <span class="text-muted">{{ $profile->bio ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Religious Information Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Religious Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <p><strong>Religion:</strong> <span class="text-muted">{{ $profile->religion ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Caste:</strong> <span class="text-muted">{{ $profile->caste ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Sub Caste:</strong> <span class="text-muted">{{ $profile->sub_caste ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Gotra:</strong> <span class="text-muted">{{ $profile->gotra ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horoscope Information Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Horoscope Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            <div class="col">
                                <p><strong>Time of Birth:</strong> <span class="text-muted">{{ $profile->birth_time ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Place of Birth:</strong> <span class="text-muted">{{ $profile->birth_place ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Manglik Status:</strong> <span class="text-muted">{{ $profile->manglik_status ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Educational & Career Information Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Educational & Career Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <p><strong>Highest Qualification:</strong> <span class="text-muted">{{ $profile->highest_qualification ? (is_array($hq = json_decode($profile->highest_qualification, true)) ? implode(', ', $hq) : $profile->highest_qualification) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Education Field:</strong> <span class="text-muted">{{ $profile->education_field ? (is_array($ef = json_decode($profile->education_field, true)) ? implode(', ', $ef) : $profile->education_field) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Name of Institute:</strong> <span class="text-muted">{{ $profile->institute_name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Work Location:</strong> <span class="text-muted">{{ $profile->work_location ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Working With:</strong> <span class="text-muted">{{ $profile->employer_name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Profession:</strong> <span class="text-muted">{{ $profile->profession ? (is_array($prof = json_decode($profile->profession, true)) ? implode(', ', $prof) : $profile->profession) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Business/Company Name:</strong> <span class="text-muted">{{ $profile->business_name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Designation:</strong> <span class="text-muted">{{ $profile->designation ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Income Range:</strong> <span class="text-muted">{{ $profile->annual_income ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lifestyle Information Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Lifestyle Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <p><strong>Diet:</strong> <span class="text-muted">{{ $profile->diet ? (is_array($diet = json_decode($profile->diet, true)) ? implode(', ', $diet) : $profile->diet) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Drinking:</strong> <span class="text-muted">{{ $profile->drinking_status ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Smoking:</strong> <span class="text-muted">{{ $profile->smoking_status ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Family Information Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Family Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <p><strong>Father's Occupation:</strong> <span class="text-muted">{{ $profile->father_occupation ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Mother's Occupation:</strong> <span class="text-muted">{{ $profile->mother_occupation ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Number of Brothers:</strong> <span class="text-muted">{{ $profile->brother_count ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Married Brothers:</strong> <span class="text-muted">{{ $profile->married_brother_count ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Number of Sisters:</strong> <span class="text-muted">{{ $profile->sister_count ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Married Sisters:</strong> <span class="text-muted">{{ $profile->married_sister_count ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Family Type:</strong> <span class="text-muted">{{ $profile->family_type ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Family Affluence:</strong> <span class="text-muted">{{ $profile->family_affluence ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p><strong>Family Values:</strong> <span class="text-muted">{{ $profile->family_values ?? '-' }}</span></p>
                            </div>
                            <div class="col-12">
                                <p><strong>About Your Family:</strong> <span class="text-muted">{{ $profile->family_bio ?? '-' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partner Preference Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Partner Preference</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->partnerPreference)
                            <!-- Basic Preferences -->
                            <h6 class="mt-3 mb-2">Basic Preferences</h6>
                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                <div class="col">
                                    <p><strong>Minimum Age:</strong> <span class="text-muted">{{ $profile->partnerPreference->min_age ?? '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Maximum Age:</strong> <span class="text-muted">{{ $profile->partnerPreference->max_age ?? '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Minimum Height:</strong> <span class="text-muted">{{ $profile->partnerPreference->min_height ?? '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Maximum Height:</strong> <span class="text-muted">{{ $profile->partnerPreference->max_height ?? '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Marital Status:</strong> <span class="text-muted">{{ $profile->partnerPreference->marital_status ? (is_array($ms = json_decode($profile->partnerPreference->marital_status, true)) ? implode(', ', $ms) : $profile->partnerPreference->marital_status) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Religion:</strong> <span class="text-muted">{{ $profile->partnerPreference->partner_religion ? (is_array($pr = json_decode($profile->partnerPreference->partner_religion, true)) ? implode(', ', $pr) : $profile->partnerPreference->partner_religion) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Caste:</strong> <span class="text-muted">{{ $profile->partnerPreference->partner_caste ? (is_array($pc = json_decode($profile->partnerPreference->partner_caste, true)) ? implode(', ', $pc) : $profile->partnerPreference->partner_caste) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Manglik Status:</strong> <span class="text-muted">{{ $profile->partnerPreference->manglik_status ? (is_array($ms = json_decode($profile->partnerPreference->manglik_status, true)) ? implode(', ', $ms) : $profile->partnerPreference->manglik_status) : '-' }}</span></p>
                                </div>
                            </div>

                            <!-- Location Preferences -->
                            <h6 class="mt-4 mb-2">Location Preferences</h6>
                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                <div class="col">
                                    <p><strong>Country:</strong> <span class="text-muted">{{ $profile->partnerPreference->country ? (is_array($pc = json_decode($profile->partnerPreference->country, true)) ? implode(', ', $pc) : $profile->partnerPreference->country) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>State:</strong> <span class="text-muted">{{ $profile->partnerPreference->state ? (is_array($ps = json_decode($profile->partnerPreference->state, true)) ? implode(', ', $ps) : $profile->partnerPreference->state) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>City:</strong> <span class="text-muted">{{ $profile->partnerPreference->city ? (is_array($pcity = json_decode($profile->partnerPreference->city, true)) ? implode(', ', $pcity) : $profile->partnerPreference->city) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Citizenship:</strong> <span class="text-muted">{{ $profile->partnerPreference->citizenship ?? '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Country Grew Up:</strong> <span class="text-muted">{{ $profile->partnerPreference->grow_up_in ? (is_array($pgui = json_decode($profile->partnerPreference->grow_up_in, true)) ? implode(', ', $pgui) : $profile->partnerPreference->grow_up_in) : '-' }}</span></p>
                                </div>
                            </div>

                            <!-- Education & Career Preferences -->
                            <h6 class="mt-4 mb-2">Education & Career Preferences</h6>
                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                <div class="col">
                                    <p><strong>Highest Qualification:</strong> <span class="text-muted">{{ $profile->partnerPreference->highest_qualification ? (is_array($phq = json_decode($profile->partnerPreference->highest_qualification, true)) ? implode(', ', $phq) : $profile->partnerPreference->highest_qualification) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Education Field:</strong> <span class="text-muted">{{ $profile->partnerPreference->education_field ? (is_array($pef = json_decode($profile->partnerPreference->education_field, true)) ? implode(', ', $pef) : $profile->partnerPreference->education_field) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Working With:</strong> <span class="text-muted">{{ $profile->partnerPreference->employer_name ? (is_array($pen = json_decode($profile->partnerPreference->employer_name, true)) ? implode(', ', $pen) : $profile->partnerPreference->employer_name) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Profession:</strong> <span class="text-muted">{{ $profile->partnerPreference->profession ? (is_array($pprof = json_decode($profile->partnerPreference->profession, true)) ? implode(', ', $pprof) : $profile->partnerPreference->profession) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Designation:</strong> <span class="text-muted">{{ $profile->partnerPreference->designation ?? '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Annual Income:</strong> <span class="text-muted">{{ $profile->partnerPreference->annual_income ? (is_array($pai = json_decode($profile->partnerPreference->annual_income, true)) ? implode(', ', $pai) : $profile->partnerPreference->annual_income) : '-' }}</span></p>
                                </div>
                            </div>

                            <!-- Lifestyle Preferences -->
                            <h6 class="mt-4 mb-2">Lifestyle Preferences</h6>
                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                <div class="col">
                                    <p><strong>Diet:</strong> <span class="text-muted">{{ $profile->partnerPreference->diet ? (is_array($pdiet = json_decode($profile->partnerPreference->diet, true)) ? implode(', ', $pdiet) : $profile->partnerPreference->diet) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Drinking:</strong> <span class="text-muted">{{ $profile->partnerPreference->drinking_status ? (is_array($pdrink = json_decode($profile->partnerPreference->drinking_status, true)) ? implode(', ', $pdrink) : $profile->partnerPreference->drinking_status) : '-' }}</span></p>
                                </div>
                                <div class="col">
                                    <p><strong>Smoking:</strong> <span class="text-muted">{{ $profile->partnerPreference->smoking_status ? (is_array($psmoke = json_decode($profile->partnerPreference->smoking_status, true)) ? implode(', ', $psmoke) : $profile->partnerPreference->smoking_status) : '-' }}</span></p>
                                </div>
                                <div class="col-12">
                                    <p><strong>About Your Partner Preference:</strong> <span class="text-muted">{{ $profile->partnerPreference->about ?? '-' }}</span></p>
                                </div>
                            </div>
                        @else
                            <div class="row row-cols-1 g-3">
                                <div class="col">
                                    <p class="text-muted">No partner preferences available</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>
    .avatar {
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
    .avatar-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
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
    .preview-container div {
        text-align: center;
        font-size: 12px;
        word-break: break-all;
        padding: 5px;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .nav-borders .nav-link {
        color: #6c757d;
    }
    .nav-borders .nav-link.active {
        color: #007bff;
        border-bottom: 2px solid #007bff;
    }
    .badge {
        padding: 6px 12px;
    }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    feather.replace();
</script>
@endpush