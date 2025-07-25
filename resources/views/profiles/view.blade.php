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
    <!-- Main page content-->

    <div class="container-fluid px-4 mt-4">
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
           
        </nav>
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0 shadow-sm">
                    <div class="card-header bg-primary text-white">Profile Picture</div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        

                        <img class="img-account-profile rounded-circle mb-2" src="" alt="Profile Picture">
                        <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <!-- Profile picture upload button-->
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Accordion -->
                <div class="accordion" id="profileAccordion">
                    <!-- Basic Details -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="basicDetailsHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#basicDetailsCollapse" aria-expanded="true" aria-controls="basicDetailsCollapse">
                                Basic Details
                            </button>
                        </h2>
                        <div id="basicDetailsCollapse" class="accordion-collapse collapse show" aria-labelledby="basicDetailsHeading">

                            <div class="accordion-body">
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    <div class="col">
                                        <p class="mb-2"><strong>Full Name:</strong> <span class="text-muted">{{ $profile->name ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Gender:</strong> <span class="badge bg-success text-white">{{ $profile->gender ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Marital Status:</strong> <span class="text-muted">{{ $profile->marital_status ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Mother Tongue:</strong> <span class="text-muted">{{ is_array($profile->mother_tongue) ? implode(', ', $profile->mother_tongue) : $profile->mother_tongue ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Diet:</strong> <span class="text-muted">{{ is_array($profile->diet) ? implode(', ', $profile->diet) : $profile->diet ?? '-' }}</span></p>
                                    </div>
                                    <div class="col">
                                        <p class="mb-2"><strong>Religion:</strong> <span class="text-muted">{{ $profile->religion ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Caste:</strong> <span class="text-muted">{{ $profile->caste ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Height:</strong> <span class="text-muted">{{ $profile->height ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Health Status:</strong> <span class="text-muted">{{ $profile->health_status ?? '-' }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Partner Preference Details -->
                    <div class="accordion-item">
                        <h2 class="accordion-headerx" id="partnerPreferenceHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#partnerPreferenceCollapse" aria-expanded="false" aria-controls="partnerPreferenceCollapse">
                                Partner Preference Details
                            </button>
                        </h2>
                        <div id="partnerPreferenceCollapse" class="accordion-collapse collapse" aria-labelledby="partnerPreferenceHeading">

                            <div class="accordion-body">
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    <div class="col">
                                        <p class="mb-2"><strong>Minimum Age:</strong> <span class="text-muted">{{ $profile->partnerPreference->min_age ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Maximum Age:</strong> <span class="text-muted">{{ $profile->partnerPreference->max_age ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Marital Status:</strong> <span class="text-muted">{{ is_array($profile->partnerPreference->marital_status) ? implode(', ', $profile->partnerPreference->marital_status) : $profile->partnerPreference->marital_status ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Mother Tongue:</strong> <span class="text-muted">{{ is_array($profile->partnerPreference->mother_tongue) ? implode(', ', $profile->partnerPreference->mother_tongue) : $profile->partnerPreference->mother_tongue ?? '-' }}</span></p>
                                    </div>
                                    <div class="col">
                                        <p class="mb-2"><strong>Religion:</strong> <span class="text-muted">{{ is_array($profile->partnerPreference->religion) ? implode(', ', $profile->partnerPreference->religion) : $profile->partnerPreference->religion ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Caste:</strong> <span class="text-muted">{{ is_array($profile->partnerPreference->caste) ? implode(', ', $profile->partnerPreference->caste) : $profile->partnerPreference->caste ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Country:</strong> <span class="text-muted">{{ $profile->partnerPreference->country ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Minimum Height:</strong> <span class="text-muted">{{ $profile->partnerPreference->min_height ?? '-' }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="contactHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contactCollapse" aria-expanded="false" aria-controls="contactCollapse">
                                Contact
                            </button>
                        </h2>
                        <div id="contactCollapse" class="accordion-collapse collapse" aria-labelledby="contactHeading" data-bs-parentx="#profileAccordion">
                            <div class="accordion-body">
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    <div class="col">
                                        <p class="mb-2"><strong>Email Address:</strong> <span class="text-muted">{{ $profile->email ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Phone Number:</strong> <span class="text-muted">{{ $profile->phone_code . ' ' . $profile->phone_number ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Alternative Email:</strong> <span class="text-muted">{{ $profile->alternative_email ?? '-' }}</span></p>
                                    </div>
                                    <div class="col">
                                        <p class="mb-2"><strong>Alternative Phone:</strong> <span class="text-muted">{{ $profile->alternative_phone_code . ' ' . $profile->alternative_phone_number ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Native Place:</strong> <span class="text-muted">{{ $profile->native_place ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Citizenship:</strong> <span class="text-muted">{{ $profile->citizenship ?? '-' }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Education & Career -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="educationCareerHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#educationCareerCollapse" aria-expanded="false" aria-controls="educationCareerCollapse">
                                Education & Career
                            </button>
                        </h2>
                        <div id="educationCareerCollapse" class="accordion-collapse collapse" aria-labelledby="educationCareerHeading" data-bs-parentx="#profileAccordion">
                            <div class="accordion-body">
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    <div class="col">
                                        <p class="mb-2"><strong>Highest Qualification:</strong> <span class="text-muted">{{ is_array($profile->highest_qualification) ? implode(', ', $profile->highest_qualification) : $profile->highest_qualification ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Education Field:</strong> <span class="text-muted">{{ is_array($profile->education_field) ? implode(', ', $profile->education_field) : $profile->education_field ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Institute Name:</strong> <span class="text-muted">{{ $profile->institute_name ?? '-' }}</span></p>
                                    </div>
                                    <div class="col">
                                        <p class="mb-2"><strong>Profession:</strong> <span class="text-muted">{{ is_array($profile->profession) ? implode(', ', $profile->profession) : $profile->profession ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Employer Name:</strong> <span class="text-muted">{{ $profile->employer_name ?? '-' }}</span></p>
                                        <p class="mb-2"><strong>Annual Income:</strong> <span class="text-muted">{{ $profile->annual_income ?? '-' }}</span></p>
                                    </div>
                                </div>
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
    .img-account-profile {
        height: 10rem;
        width: 10rem;
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
    .accordion-button {
        font-weight: 500;
    }
    .accordion-button:not(.collapsed) {
        color: #007bff;
        background-color: #f8f9fa;
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