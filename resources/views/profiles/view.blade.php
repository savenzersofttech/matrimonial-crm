@extends('layouts.sb2-layout')
@section('title', 'View Profile')
@php
    $partner = optional($profile->partnerPreference);

    function decodeAndImplode($json) {
        $decoded = is_string($json) ? json_decode($json, true) : null;
        return is_array($decoded) ? implode(', ', $decoded) : ($json ?? '-');
    }
@endphp

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"></div>
                            Profile Details
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content -->
    <div class="container-fluid px-4 mt-n10">
        <div class="row row-cols-1 g-4">
            <!-- Personal Details Card -->
            <div class="col">
                <div class="card shadow-sm">
                    <!--<div class="card-header bg-primary text-white">-->
                    <!--    <h5 class="mb-0 text-white">Personal Details</h5>-->
                    <!--</div>-->
                    <div class="card-body">
                        <!--<div class="row row-cols-1 row-cols-md-2 g-3">-->
                        <!--</div>-->

                        <!--Profile Information-->
                        <div class="">
                            <p>Profile Source: <span class="text-muted">{{
                                    $ProfileSource->firstWhere('id', $profile->profile_source_id)->name ?? '-' }}</span>
                            </p>
                        </div>
                        <div class="">
                            <p>Profile Source Info: <span class="text-muted">{{
                                    $profile->profile_source_comment ?? '-' }}</span></p>
                        </div>
                        <div class="">
                            <p>Profile ID: <span class="text-muted">{{
                                    $profile->profile_id ?? '-' }}</span></p>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="d-flex flex-wrap gap-2">

                                    @php
                                    $photos = json_decode($profile->photo, true);
                                    $firstPhoto = !empty($photos) && is_array($photos) ? $photos[0] : null;
                                    @endphp

                                    @if ($firstPhoto)
                                    <div class="border p-1 rounded" style="width: 40% ;">
                                        <img src="{{ asset('storage/' . $firstPhoto) }}" class="img-fluid" alt="Photo">
                                    </div>
                                    @else
                                    <div class="avatar">
                                        <img class="avatar-img img-fluid" src="{{ asset('assets/sb2/assets/img/illustrations/profiles/profile-1.png') }}" alt="No Photo">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--Contact Information-->
                        <h5 class="mt-4">Contact Information</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Email: <span class="text-muted">{{ $profile->email ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="col">
                                <p>Alternative Email: <span class="text-muted">{{
                                        $profile->alternative_email ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Phone Number: <span class="text-muted">{{ $profile->phone_number ?
                                        $profile->phone_code . ' ' . substr($profile->phone_number,
                                        strlen($profile->phone_code)) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Alternative Phone Number: <span class="text-muted">{{
                                        $profile->alternative_phone_number ? $profile->alternative_phone_code . ' ' .
                                        substr($profile->alternative_phone_number,
                                        strlen($profile->alternative_phone_code)) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Contact Person: <span class="text-muted">{{
                                        $profile->contact_person_name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Profile Creating For: <span class="text-muted">{{
                                        $profile->profile_for ?? '-' }}</span></p>
                            </div>
                        </div>

                        <h5 class="g-2">Client’s Basic Information</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Full Name: <span class="text-muted">{{ $profile->name ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Gender: <span class="badge bg-success text-white">{{
                                        $profile->gender ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>
                                    Date of Birth:
                                    <span class="text-muted">
                                        @if ($profile->date_of_birth)
                                            {{ \Carbon\Carbon::parse($profile->date_of_birth)->format('d M Y') }}
                                            ({{ \Carbon\Carbon::parse($profile->date_of_birth)->age }} years old)
                                        @else
                                            -
                                        @endif
                                    </span>
                                </p>
                            </div>

                            <div class="col">
                                <p>Marital Status: <span class="text-muted">{{ $profile->marital_status
                                        ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Height: <span class="text-muted">{{ $profile->height ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Mother Tongue: <span class="text-muted">{{ $profile->mother_tongue ?
                                        (is_array($mt = json_decode($profile->mother_tongue, true)) ? implode(', ', $mt)
                                        : $profile->mother_tongue) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Weight: <span class="text-muted">{{ $profile->weight ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Body Type: <span class="text-muted">{{ $profile->body_type ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Complexion: <span class="text-muted">{{ $profile->complexion ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Blood Group: <span class="text-muted">{{ $profile->blood_group ??
                                        '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Health Status: <span class="text-muted">{{ $profile->health_status
                                        ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Native Place: <span class="text-muted">{{ $profile->native_place ??
                                        '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Country: <span class="text-muted">{{ $profile->country ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>State: <span class="text-muted">{{ $profile->state ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="col">
                                <p>City: <span class="text-muted">{{ $profile->city ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="col">
                                <p>Citizenship: <span class="text-muted">{{ $profile->citizenship ?
                                        (is_array($cit = json_decode($profile->citizenship, true)) ? implode(', ', $cit)
                                        : $profile->citizenship) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Country Grew Up: <span class="text-muted">{{ $profile->grow_up_in ?
                                        (is_array($gui = json_decode($profile->grow_up_in, true)) ? implode(', ', $gui)
                                        : $profile->grow_up_in) : '-' }}</span></p>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Column 1: Government ID -->
                            <div class="col-6">
                                <p>Government ID:</p>
                                <div class="d-flex flex-wrap gap-2">
                                    @php
                                    $govtIds = $profile->government_id ? json_decode($profile->government_id, true) :
                                    [];
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
                            </div>

                            <!-- Column 2: Government ID Status -->
                            <div class="col-6">
                                <p class="mt-2">Government ID Status:
                                    <span class="badge {{ $profile->govt_id_status ? 'bg-success' : 'bg-warning' }} text-white">
                                        {{ $profile->govt_id_status ? 'Verified' : 'Non-Verified' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <p>About Yourself: <span class="text-muted">{{ $profile->bio ?? '-'
                                    }}</span></p>
                        </div>


                        <!--Religion Information-->
                        <h5 class="g-2">Religion Information</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Religion: <span class="text-muted">{{ $profile->religionData->name  ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Caste: <span class="text-muted">{{ $profile->casteData->name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Sub Caste: <span class="text-muted">{{ $profile->sub_caste ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Gotra: <span class="text-muted">{{ $profile->gotra ?? '-' }}</span></p>
                            </div>
                        </div>

                        <!--Horoscope Information-->
                        <h5>Horoscope Information</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Time of Birth: <span class="text-muted">{{ $profile->birth_time ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Place of Birth: <span class="text-muted">{{ $profile->birth_place ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Manglik Status: <span class="text-muted">{{ $profile->manglik_status ??
                                        '-' }}</span></p>
                            </div>
                        </div>

                        <!--Education and Career Information-->
                        <h5>Education and Career Information</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Highest Qualification: <span class="text-muted">{{
                                        $profile->highest_qualification ? (is_array($hq =
                                        json_decode($profile->highest_qualification, true)) ? implode(', ', $hq) :
                                        $profile->highest_qualification) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Education Field: <span class="text-muted">{{ $profile->education_field ?
                                        (is_array($ef = json_decode($profile->education_field, true)) ? implode(', ', $ef) :
                                        $profile->education_field) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Name of Institute: <span class="text-muted">{{ $profile->institute_name
                                        ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Work Location: <span class="text-muted">{{ $profile->work_location ??
                                        '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Working With: <span class="text-muted">{{ $profile->employer_name ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Profession: <span class="text-muted">{{ $profile->profession ?
                                        (is_array($prof = json_decode($profile->profession, true)) ? implode(', ', $prof) :
                                        $profile->profession) : '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Business/Company Name: <span class="text-muted">{{
                                        $profile->business_name ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Designation: <span class="text-muted">{{ $profile->designation ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Income Range: <span class="text-muted">{{ $profile->annual_income ?? '-'
                                        }}</span></p>
                            </div>
                        </div>

                        <!--Lifestyle Information-->
                        <h5>Lifestyle Information</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Diet: <span class="text-muted">{{ $profile->diet ? (is_array($diet =
                                        json_decode($profile->diet, true)) ? implode(', ', $diet) : $profile->diet) : '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Drinking: <span class="text-muted">{{ $profile->drinking_status ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Smoking: <span class="text-muted">{{ $profile->smoking_status ?? '-'
                                        }}</span></p>
                            </div>
                        </div>

                        <!--Family Information-->
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Father's Occupation: <span class="text-muted">{{
                                        $profile->father_occupation ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Mother's Occupation: <span class="text-muted">{{
                                        $profile->mother_occupation ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Number of Brothers: <span class="text-muted">{{ $profile->brother_count
                                        ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Married Brothers: <span class="text-muted">{{
                                        $profile->married_brother_count ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Number of Sisters: <span class="text-muted">{{ $profile->sister_count ??
                                        '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Married Sisters: <span class="text-muted">{{
                                        $profile->married_sister_count ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Family Type: <span class="text-muted">{{ $profile->family_type ?? '-'
                                        }}</span></p>
                            </div>
                            <div class="col">
                                <p>Family Affluence: <span class="text-muted">{{ $profile->family_affluence
                                        ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Family Values: <span class="text-muted">{{ $profile->family_values ??
                                        '-' }}</span></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <p>About Your Family: <span class="text-muted">{{ $profile->family_bio ??
                                    '-' }}</span></p>
                        </div>

                        <!-- Basic Preferences -->
                        <h3>Partner's Preferences</h3>

                        <h5>Basic Preferences</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Minimum Age: <span class="text-muted">{{ $partner->min_age ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Maximum Age: <span class="text-muted">{{ $partner->max_age ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Minimum Height: <span class="text-muted">{{ $partner->min_height ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Maximum Height: <span class="text-muted">{{ $partner->max_height ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Marital Status: <span class="text-muted">{{ decodeAndImplode($partner->marital_status) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Religion: <span class="text-muted">{{ decodeAndImplode($partner->partner_religion) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Caste: <span class="text-muted">{{ decodeAndImplode($partner->partner_caste) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Manglik Status: <span class="text-muted">{{ decodeAndImplode($partner->manglik_status) }}</span></p>
                            </div>
                        </div>

                        <h5>Location Preferences</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Country: <span class="text-muted">{{ decodeAndImplode($partner->country) }}</span></p>
                            </div>
                            <div class="col">
                                <p>State: <span class="text-muted">{{ decodeAndImplode($partner->state) }}</span></p>
                            </div>
                            <div class="col">
                                <p>City: <span class="text-muted">{{ decodeAndImplode($partner->city) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Citizenship: <span class="text-muted">{{ $partner->citizenship ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Country Grew Up: <span class="text-muted">{{ decodeAndImplode($partner->grow_up_in) }}</span></p>
                            </div>
                        </div>

                        <h5>Education & Career Preferences</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Highest Qualification: <span class="text-muted">{{ decodeAndImplode($partner->highest_qualification) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Education Field: <span class="text-muted">{{ decodeAndImplode($partner->education_field) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Working With: <span class="text-muted">{{ decodeAndImplode($partner->employer_name) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Profession: <span class="text-muted">{{ decodeAndImplode($partner->profession) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Designation: <span class="text-muted">{{ $partner->designation ?? '-' }}</span></p>
                            </div>
                            <div class="col">
                                <p>Annual Income: <span class="text-muted">{{ decodeAndImplode($partner->annual_income) }}</span></p>
                            </div>
                        </div>

                        <h5>Lifestyle Preferences</h5>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p>Diet: <span class="text-muted">{{ decodeAndImplode($partner->diet) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Drinking: <span class="text-muted">{{ decodeAndImplode($partner->drinking_status) }}</span></p>
                            </div>
                            <div class="col">
                                <p>Smoking: <span class="text-muted">{{ decodeAndImplode($partner->smoking_status) }}</span></p>
                            </div>
                        </div>

                        <div class="col-12">
                            <p>About Your Partner Preference: <span class="text-muted">{{
                                    $profile->partnerPreference->about ?? '-' }}</span></p>
                        </div>

                        <h5 class="">Gallery</h5>
                        <div class="row mt-2">
                            <div class="col-12">
                                @php
                                $photos = json_decode($profile->photo, true);
                                @endphp

                                @if (!empty($photos) && is_array($photos))
                                <div class="row g-2">
                                    @foreach ($photos as $img)
                                    <div class="col-6 col-md-2"> {{-- 5 images per row on desktop --}}
                                        <div class="border p-1 rounded text-center">
                                            <img src="{{ asset('storage/' . $img) }}" class="img-fluid" alt="Photo" style="height: 280px; width: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="avatar text-center">
                                    <img class="avatar-img img-fluid" src="{{ asset('assets/sb2/assets/img/illustrations/profiles/profile-1.png') }}" alt="No Photo">
                                </div>
                                @endif
                            </div>
                        </div>

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





<!-- Contact Information Card -->
<!--<div class="col">-->
<!--    <div class="card shadow-sm">-->
<!--        <div class="card-header bg-primary text-white">-->
<!--            <h5 class="mb-0 text-white">Contact Information</h5>-->
<!--        </div>-->
<!--        <div class="card-body">-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Client’s Basic Information Card -->
<!--<div class="col">-->
<!--    <div class="card shadow-sm">-->
<!--        <div class="card-header bg-primary text-white">-->
<!--            <h5 class="mb-0 text-white">Client’s Basic Information</h5>-->
<!--        </div>-->
<!--        <div class="card-body">-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Religious Information Card -->
<!--<div class="col">-->
<!--    <div class="card shadow-sm">-->
<!--        <div class="card-header bg-primary text-white">-->
<!--            <h5 class="mb-0 text-white">Religious Information</h5>-->
<!--        </div>-->
<!--        <div class="card-body">-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Horoscope Information Card -->
<!--<div class="col">-->
<!--    <div class="card shadow-sm">-->
<!--        <div class="card-header bg-primary text-white">-->
<!--            <h5 class="mb-0 text-white">Horoscope Information</h5>-->
<!--        </div>-->
<!--        <div class="card-body">-->
<!--            <div class="row row-cols-1 row-cols-md-3 g-3">-->

<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Educational & Career Information Card -->
<!--<div class="col">-->
<!--    <div class="card shadow-sm">-->
<!--        <div class="card-header bg-primary text-white">-->
<!--            <h5 class="mb-0 text-white">Educational & Career Information</h5>-->
<!--        </div>-->
<!--        <div class="card-body">-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Lifestyle Information Card -->
<!--<div class="col">-->
<!--    <div class="card shadow-sm">-->
<!--        <div class="card-header bg-primary text-white">-->
<!--            <h5 class="mb-0 text-white">Lifestyle Information</h5>-->
<!--        </div>-->
<!--        <div class="card-body">-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Family Information Card -->
<!--<div class="col">-->
<!--    <div class="card shadow-sm">-->
<!--        <div class="card-header bg-primary text-white">-->
<!--            <h5 class="mb-0 text-white">Family Information</h5>-->
<!--        </div>-->
<!--        <div class="card-body">-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- Partner Preference Card -->
<!--<div class="col">-->
<!--    <div class="card shadow-sm">-->
<!--        <div class="card-header bg-primary text-white">-->
<!--            <h5 class="mb-0 text-white">Partner Preference</h5>-->
<!--        </div>-->
<!--        <div class="card-body">-->

<!--        </div>-->
<!--    </div>-->
<!--</div>-->
