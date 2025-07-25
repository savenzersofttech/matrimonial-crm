@extends('layouts.sb2-layout')
@section('title', 'Add New Profile')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-fluid px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="activity"></i></div>
                                Add new
                            </h1>

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4 mt-n10">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h4 class="mb-0">Profile add </h4>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.profiles.store') }}" enctype="multipart/form-data">
                                @csrf

                                {{-- Personal Details --}}
                                <h5>Personal Details</h5>
                                <div class="row">
                                    <div class="form-group col-md-6 mt-2">
                                        <label>Full Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter full name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Gender</label>
                                        <select name="gender" class="virtualSelect mt-2" placeholder="Select gender ">
                                                <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>-- Select Gender --</option>

                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6  mt-2">
                                        <label>Contact Number <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <input type="text" id="phone" name="phone" maxlength="15"
                                                class="form-control" placeholder="+91 1234567890"
                                                value="{{ old('phone') }}">
                                        </div>
                                        @error('country_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Email Address</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="example@email.com" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Date of Birth</label>
                                        <input type="date" name="dob" class="form-control"
                                            value="{{ old('dob') }}">
                                        @error('dob')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="religion">Religion</label>
                                        <select id="religion" name="religion" class="virtualSelect m-2">
                                            <option value="" disabled {{ old('religion') ? '' : 'selected' }}>--
                                                Select Religion --</option>
                                            <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu
                                            </option>
                                            <option value="Muslim" {{ old('religion') == 'Muslim' ? 'selected' : '' }}>
                                                Muslim</option>
                                            <option value="Christian"
                                                {{ old('religion') == 'Christian' ? 'selected' : '' }}>Christian</option>
                                            <option value="Sikh" {{ old('religion') == 'Sikh' ? 'selected' : '' }}>Sikh
                                            </option>
                                            <option value="Parsi" {{ old('religion') == 'Parsi' ? 'selected' : '' }}>Parsi
                                            </option>
                                            <option value="Jain" {{ old('religion') == 'Jain' ? 'selected' : '' }}>Jain
                                            </option>
                                            <option value="Buddhist" {{ old('religion') == 'Buddhist' ? 'selected' : '' }}>
                                                Buddhist</option>
                                            <option value="Jewish" {{ old('religion') == 'Jewish' ? 'selected' : '' }}>
                                                Jewish</option>
                                            <option value="No Religion"
                                                {{ old('religion') == 'No Religion' ? 'selected' : '' }}>No Religion
                                            </option>
                                            <option value="Spiritual - not religious"
                                                {{ old('religion') == 'Spiritual - not religious' ? 'selected' : '' }}>
                                                Spiritual - not religious</option>
                                            <option value="Other" {{ old('religion') == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('religion')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Community</label>
                                        <select id="community" name="community" class="virtualSelect m-2">
                                            <option value="" disabled {{ old('community') ? '' : 'selected' }}>--
                                                Select Community --</option>
                                            <optgroup label="Hindu">
                                                <option value="Agarwal"
                                                    {{ old('community') == 'Agarwal' ? 'selected' : '' }}>Agarwal</option>
                                                <option value="Arora" {{ old('community') == 'Arora' ? 'selected' : '' }}>
                                                    Arora</option>
                                                <option value="Brahmin"
                                                    {{ old('community') == 'Brahmin' ? 'selected' : '' }}>Brahmin</option>
                                                <option value="Chaudhary"
                                                    {{ old('community') == 'Chaudhary' ? 'selected' : '' }}>Chaudhary
                                                </option>
                                                <option value="Gupta" {{ old('community') == 'Gupta' ? 'selected' : '' }}>
                                                    Gupta</option>
                                                <option value="Jat" {{ old('community') == 'Jat' ? 'selected' : '' }}>
                                                    Jat</option>
                                                <option value="Kayastha"
                                                    {{ old('community') == 'Kayastha' ? 'selected' : '' }}>Kayastha
                                                </option>
                                                <option value="Khatri"
                                                    {{ old('community') == 'Khatri' ? 'selected' : '' }}>Khatri</option>
                                                <option value="Kshatriya"
                                                    {{ old('community') == 'Kshatriya' ? 'selected' : '' }}>Kshatriya
                                                </option>
                                                <option value="Maratha"
                                                    {{ old('community') == 'Maratha' ? 'selected' : '' }}>Maratha</option>
                                                <option value="Marwari"
                                                    {{ old('community') == 'Marwari' ? 'selected' : '' }}>Marwari</option>
                                                <option value="Nair" {{ old('community') == 'Nair' ? 'selected' : '' }}>
                                                    Nair</option>
                                                <option value="Patel" {{ old('community') == 'Patel' ? 'selected' : '' }}>
                                                    Patel</option>
                                                <option value="Rajput"
                                                    {{ old('community') == 'Rajput' ? 'selected' : '' }}>Rajput</option>
                                                <option value="Reddy"
                                                    {{ old('community') == 'Reddy' ? 'selected' : '' }}>Reddy</option>
                                                <option value="Sindhi"
                                                    {{ old('community') == 'Sindhi' ? 'selected' : '' }}>Sindhi</option>
                                                <option value="Yadav"
                                                    {{ old('community') == 'Yadav' ? 'selected' : '' }}>Yadav</option>
                                                <option value="Iyer" {{ old('community') == 'Iyer' ? 'selected' : '' }}>
                                                    Iyer</option>
                                                <option value="Iyengar"
                                                    {{ old('community') == 'Iyengar' ? 'selected' : '' }}>Iyengar</option>
                                                <option value="Chettiar"
                                                    {{ old('community') == 'Chettiar' ? 'selected' : '' }}>Chettiar
                                                </option>
                                                <option value="Gounder"
                                                    {{ old('community') == 'Gounder' ? 'selected' : '' }}>Gounder</option>
                                                <option value="Mudaliar"
                                                    {{ old('community') == 'Mudaliar' ? 'selected' : '' }}>Mudaliar
                                                </option>
                                                <option value="Nadar"
                                                    {{ old('community') == 'Nadar' ? 'selected' : '' }}>Nadar</option>
                                                <option value="Pillai"
                                                    {{ old('community') == 'Pillai' ? 'selected' : '' }}>Pillai</option>
                                                <option value="Vokkaliga"
                                                    {{ old('community') == 'Vokkaliga' ? 'selected' : '' }}>Vokkaliga
                                                </option>
                                            </optgroup>
                                            <optgroup label="Muslim">
                                                <option value="Sunni"
                                                    {{ old('community') == 'Sunni' ? 'selected' : '' }}>Sunni</option>
                                                <option value="Shia" {{ old('community') == 'Shia' ? 'selected' : '' }}>
                                                    Shia</option>
                                                <option value="Memon"
                                                    {{ old('community') == 'Memon' ? 'selected' : '' }}>Memon</option>
                                                <option value="Khoja"
                                                    {{ old('community') == 'Khoja' ? 'selected' : '' }}>Khoja</option>
                                                <option value="Syed" {{ old('community') == 'Syed' ? 'selected' : '' }}>
                                                    Syed</option>
                                                <option value="Pathan"
                                                    {{ old('community') == 'Pathan' ? 'selected' : '' }}>Pathan</option>
                                            </optgroup>
                                            <optgroup label="Christian">
                                                <option value="Catholic"
                                                    {{ old('community') == 'Catholic' ? 'selected' : '' }}>Catholic
                                                </option>
                                                <option value="Protestant"
                                                    {{ old('community') == 'Protestant' ? 'selected' : '' }}>Protestant
                                                </option>
                                                <option value="Born Again"
                                                    {{ old('community') == 'Born Again' ? 'selected' : '' }}>Born Again
                                                </option>
                                                <option value="Orthodox"
                                                    {{ old('community') == 'Orthodox' ? 'selected' : '' }}>Orthodox
                                                </option>
                                            </optgroup>
                                            <optgroup label="Sikh">
                                                <option value="Ramgarhia"
                                                    {{ old('community') == 'Ramgarhia' ? 'selected' : '' }}>Ramgarhia
                                                </option>
                                                <option value="Jat Sikh"
                                                    {{ old('community') == 'Jat Sikh' ? 'selected' : '' }}>Jat Sikh
                                                </option>
                                                <option value="Khatri Sikh"
                                                    {{ old('community') == 'Khatri Sikh' ? 'selected' : '' }}>Khatri Sikh
                                                </option>
                                            </optgroup>
                                            <optgroup label="Jain">
                                                <option value="Digambar"
                                                    {{ old('community') == 'Digambar' ? 'selected' : '' }}>Digambar
                                                </option>
                                                <option value="Shwetambar"
                                                    {{ old('community') == 'Shwetambar' ? 'selected' : '' }}>Shwetambar
                                                </option>
                                                <option value="Terapanthi"
                                                    {{ old('community') == 'Terapanthi' ? 'selected' : '' }}>Terapanthi
                                                </option>
                                            </optgroup>
                                            <optgroup label="Other Communities">
                                                <option value="Parsi"
                                                    {{ old('community') == 'Parsi' ? 'selected' : '' }}>Parsi</option>
                                                <option value="Zoroastrian"
                                                    {{ old('community') == 'Zoroastrian' ? 'selected' : '' }}>Zoroastrian
                                                </option>
                                                <option value="Other"
                                                    {{ old('community') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </optgroup>
                                        </select>
                                        @error('community')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="marital_status">Marital Status</label>
                                        <select name="marital_status" id="marital_status" class="virtualSelect m-2">
                                            <option value="" disabled {{ old('marital_status') == '' ? 'selected' : '' }}>-- Select Marital Status --</option>

                                            @foreach (getMaritalStatusOptions() as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @error('marital_status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="mother_tongue">Mother Tongue</label>
                                        <select id="mother_tongue" data-placeholder="-- Select Mother Tongue --"
                                            name="mother_tongue" class="virtualSelect m-2">
                                                                                        <option value="" disabled selected >--Select  --</option>

                                            @foreach ($tounges as $tongue)
                                                <option value="{{ $tongue->name }}"
                                                    {{ old('mother_tongue') == $tongue->name ? 'selected' : '' }}>
                                                    {{ $tongue->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('mother_tongue')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Diet</label>
                                        <select name="diet" data-placeholder="-- Select Diet --"
                                            class="virtualSelect m-2">
                                            <option value="" disabled selected >--Select  --</option>

                                            @foreach (getDietOptions() as $diet)
                                                <option value="{{ $diet }}"
                                                    {{ old('diet') == $diet ? 'selected' : '' }}>
                                                    {{ $diet }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('diet')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Citizenship</label>
                                        <select name="citizenship" class="virtualSelect m-2">
                                            <option value="" disabled {{ old('citizenship') ? '' : 'selected' }}>--
                                                Select Citizenship --</option>
                                            <option value="Indian" {{ old('citizenship') == 'Indian' ? 'selected' : '' }}>
                                                Indian</option>
                                            <option value="American"
                                                {{ old('citizenship') == 'American' ? 'selected' : '' }}>American</option>
                                            <option value="Canadian"
                                                {{ old('citizenship') == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                            <option value="British"
                                                {{ old('citizenship') == 'British' ? 'selected' : '' }}>British</option>
                                            <option value="Australian"
                                                {{ old('citizenship') == 'Australian' ? 'selected' : '' }}>Australian
                                            </option>
                                            <option value="New Zealander"
                                                {{ old('citizenship') == 'New Zealander' ? 'selected' : '' }}>New
                                                Zealander</option>
                                            <option value="Singaporean"
                                                {{ old('citizenship') == 'Singaporean' ? 'selected' : '' }}>Singaporean
                                            </option>
                                            <option value="Pakistani"
                                                {{ old('citizenship') == 'Pakistani' ? 'selected' : '' }}>Pakistani
                                            </option>
                                            <option value="Bangladeshi"
                                                {{ old('citizenship') == 'Bangladeshi' ? 'selected' : '' }}>Bangladeshi
                                            </option>
                                            <option value="Nepalese"
                                                {{ old('citizenship') == 'Nepalese' ? 'selected' : '' }}>Nepalese</option>
                                            <option value="Sri Lankan"
                                                {{ old('citizenship') == 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan
                                            </option>
                                            <option value="UAE" {{ old('citizenship') == 'UAE' ? 'selected' : '' }}>
                                                UAE</option>
                                            <option value="Saudi Arabian"
                                                {{ old('citizenship') == 'Saudi Arabian' ? 'selected' : '' }}>Saudi
                                                Arabian</option>
                                            <option value="Qatari" {{ old('citizenship') == 'Qatari' ? 'selected' : '' }}>
                                                Qatari</option>
                                            <option value="Kuwaiti"
                                                {{ old('citizenship') == 'Kuwaiti' ? 'selected' : '' }}>Kuwaiti</option>
                                            <option value="Malaysian"
                                                {{ old('citizenship') == 'Malaysian' ? 'selected' : '' }}>Malaysian
                                            </option>
                                            <option value="Other" {{ old('citizenship') == 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                        @error('citizenship')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Drinking</label>
                                        <select name="drinking" data-placeholder="-- Select Drinking --"
                                            class="virtualSelect m-2" >
                                                                                         <option value="" disabled seleted >--Select  --</option>

                                            @foreach (getDrinkingOptions() as $drinking)
                                                <option value="{{ $drinking }}"
                                                    {{ collect(old('drinking', []))->contains($drinking) ? 'selected' : '' }}>
                                                    {{ $drinking }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('drinking')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Smoking</label>
                                        <select name="smoking" data-placeholder="-- Select Smoking --"
                                            class="virtualSelect m-2" >
                                               <option value="" disabled selected >--Select  --</option>

                                            @foreach (getSmokingOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ collect(old('smoking', []))->contains($item) ? 'selected' : '' }}>
                                                    {{ $item }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('smoking')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Blood Group</label>
                                        <select name="blood_group" data-placeholder="-- Select Blood Group --"
                                            class="virtualSelect m-2">
                                            <option value="" disabled {{ old('blood_group') ? '' : 'selected' }}>--
                                                Select Blood Group --</option>
                                            <option value="Don't Know"
                                                {{ old('blood_group') == 'Don\'t Know' ? 'selected' : '' }}>Don't Know
                                            </option>
                                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+
                                            </option>
                                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-
                                            </option>
                                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+
                                            </option>
                                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-
                                            </option>
                                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>
                                                AB+</option>
                                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>
                                                AB-</option>
                                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+
                                            </option>
                                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-
                                            </option>
                                        </select>
                                        @error('blood_group')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Your Height</label>
                                        <select class="virtualSelect m-2" name="height">
                                            <option value="" disabled {{ old('height') ? '' : 'selected' }}>--
                                                Select Height --</option>
                                            <option value="4ft 0in - 122cm"
                                                {{ old('height') == '4ft 0in - 122cm' ? 'selected' : '' }}>4ft 0in - 122cm
                                            </option>
                                            <option value="4ft 1in - 124cm"
                                                {{ old('height') == '4ft 1in - 124cm' ? 'selected' : '' }}>4ft 1in - 124cm
                                            </option>
                                            <option value="4ft 2in - 127cm"
                                                {{ old('height') == '4ft 2in - 127cm' ? 'selected' : '' }}>4ft 2in - 127cm
                                            </option>
                                            <option value="4ft 3in - 130cm"
                                                {{ old('height') == '4ft 3in - 130cm' ? 'selected' : '' }}>4ft 3in - 130cm
                                            </option>
                                            <option value="4ft 4in - 132cm"
                                                {{ old('height') == '4ft 4in - 132cm' ? 'selected' : '' }}>4ft 4in - 132cm
                                            </option>
                                            <option value="4ft 5in - 134cm"
                                                {{ old('height') == '4ft 5in - 134cm' ? 'selected' : '' }}>4ft 5in - 134cm
                                            </option>
                                            <option value="4ft 6in - 137cm"
                                                {{ old('height') == '4ft 6in - 137cm' ? 'selected' : '' }}>4ft 6in - 137cm
                                            </option>
                                            <option value="4ft 7in - 140cm"
                                                {{ old('height') == '4ft 7in - 140cm' ? 'selected' : '' }}>4ft 7in - 140cm
                                            </option>
                                            <option value="4ft 8in - 142cm"
                                                {{ old('height') == '4ft 8in - 142cm' ? 'selected' : '' }}>4ft 8in - 142cm
                                            </option>
                                            <option value="4ft 9in - 145cm"
                                                {{ old('height') == '4ft 9in - 145cm' ? 'selected' : '' }}>4ft 9in - 145cm
                                            </option>
                                            <option value="4ft 10in - 147cm"
                                                {{ old('height') == '4ft 10in - 147cm' ? 'selected' : '' }}>4ft 10in -
                                                147cm</option>
                                            <option value="4ft 11in - 150cm"
                                                {{ old('height') == '4ft 11in - 150cm' ? 'selected' : '' }}>4ft 11in -
                                                150cm</option>
                                            <option value="5ft 0in - 152cm"
                                                {{ old('height') == '5ft 0in - 152cm' ? 'selected' : '' }}>5ft 0in - 152cm
                                            </option>
                                            <option value="5ft 1in - 155cm"
                                                {{ old('height') == '5ft 1in - 155cm' ? 'selected' : '' }}>5ft 1in - 155cm
                                            </option>
                                            <option value="5ft 2in - 157cm"
                                                {{ old('height') == '5ft 2in - 157cm' ? 'selected' : '' }}>5ft 2in - 157cm
                                            </option>
                                            <option value="5ft 3in - 160cm"
                                                {{ old('height') == '5ft 3in - 160cm' ? 'selected' : '' }}>5ft 3in - 160cm
                                            </option>
                                            <option value="5ft 4in - 163cm"
                                                {{ old('height') == '5ft 4in - 163cm' ? 'selected' : '' }}>5ft 4in - 163cm
                                            </option>
                                            <option value="5ft 5in - 165cm"
                                                {{ old('height') == '5ft 5in - 165cm' ? 'selected' : '' }}>5ft 5in - 165cm
                                            </option>
                                            <option value="5ft 6in - 168cm"
                                                {{ old('height') == '5ft 6in - 168cm' ? 'selected' : '' }}>5ft 6in - 168cm
                                            </option>
                                            <option value="5ft 7in - 170cm"
                                                {{ old('height') == '5ft 7in - 170cm' ? 'selected' : '' }}>5ft 7in - 170cm
                                            </option>
                                            <option value="5ft 8in - 173cm"
                                                {{ old('height') == '5ft 8in - 173cm' ? 'selected' : '' }}>5ft 8in - 173cm
                                            </option>
                                            <option value="5ft 9in - 175cm"
                                                {{ old('height') == '5ft 9in - 175cm' ? 'selected' : '' }}>5ft 9in - 175cm
                                            </option>
                                            <option value="5ft 10in - 178cm"
                                                {{ old('height') == '5ft 10in - 178cm' ? 'selected' : '' }}>5ft 10in -
                                                178cm</option>
                                            <option value="5ft 11in - 180cm"
                                                {{ old('height') == '5ft 11in - 180cm' ? 'selected' : '' }}>5ft 11in -
                                                180cm</option>
                                            <option value="6ft 0in - 183cm"
                                                {{ old('height') == '6ft 0in - 183cm' ? 'selected' : '' }}>6ft 0in - 183cm
                                            </option>
                                            <option value="6ft 1in - 185cm"
                                                {{ old('height') == '6ft 1in - 185cm' ? 'selected' : '' }}>6ft 1in - 185cm
                                            </option>
                                            <option value="6ft 2in - 188cm"
                                                {{ old('height') == '6ft 2in - 188cm' ? 'selected' : '' }}>6ft 2in - 188cm
                                            </option>
                                            <option value="6ft 3in - 190cm"
                                                {{ old('height') == '6ft 3in - 190cm' ? 'selected' : '' }}>6ft 3in - 190cm
                                            </option>
                                            <option value="6ft 4in - 193cm"
                                                {{ old('height') == '6ft 4in - 193cm' ? 'selected' : '' }}>6ft 4in - 193cm
                                            </option>
                                            <option value="6ft 5in - 196cm"
                                                {{ old('height') == '6ft 5in - 196cm' ? 'selected' : '' }}>6ft 5in - 196cm
                                            </option>
                                            <option value="6ft 6in - 198cm"
                                                {{ old('height') == '6ft 6in - 198cm' ? 'selected' : '' }}>6ft 6in - 198cm
                                            </option>
                                            <option value="6ft 7in - 201cm"
                                                {{ old('height') == '6ft 7in - 201cm' ? 'selected' : '' }}>6ft 7in - 201cm
                                            </option>
                                            <option value="6ft 8in - 203cm"
                                                {{ old('height') == '6ft 8in - 203cm' ? 'selected' : '' }}>6ft 8in - 203cm
                                            </option>
                                            <option value="6ft 9in - 206cm"
                                                {{ old('height') == '6ft 9in - 206cm' ? 'selected' : '' }}>6ft 9in - 206cm
                                            </option>
                                            <option value="6ft 10in - 208cm"
                                                {{ old('height') == '6ft 10in - 208cm' ? 'selected' : '' }}>6ft 10in -
                                                208cm</option>
                                            <option value="6ft 11in - 211cm"
                                                {{ old('height') == '6ft 11in - 211cm' ? 'selected' : '' }}>6ft 11in -
                                                211cm</option>
                                            <option value="7ft 0in - 213cm"
                                                {{ old('height') == '7ft 0in - 213cm' ? 'selected' : '' }}>7ft 0in - 213cm
                                            </option>
                                            <option value="7ft 1in - 216cm"
                                                {{ old('height') == '7ft 1in - 216cm' ? 'selected' : '' }}>7ft 1in - 216cm
                                            </option>
                                            <option value="7ft 2in - 218cm"
                                                {{ old('height') == '7ft 2in - 218cm' ? 'selected' : '' }}>7ft 2in - 218cm
                                            </option>
                                            <option value="7ft 3in - 221cm"
                                                {{ old('height') == '7ft 3in - 221cm' ? 'selected' : '' }}>7ft 3in - 221cm
                                            </option>
                                            <option value="7ft 4in - 224cm"
                                                {{ old('height') == '7ft 4in - 224cm' ? 'selected' : '' }}>7ft 4in - 224cm
                                            </option>
                                            <option value="7ft 5in - 226cm"
                                                {{ old('height') == '7ft 5in - 226cm' ? 'selected' : '' }}>7ft 5in - 226cm
                                            </option>
                                            <option value="7ft 6in - 229cm"
                                                {{ old('height') == '7ft 6in - 229cm' ? 'selected' : '' }}>7ft 6in - 229cm
                                            </option>
                                            <option value="7ft 7in - 231cm"
                                                {{ old('height') == '7ft 7in - 231cm' ? 'selected' : '' }}>7ft 7in - 231cm
                                            </option>
                                            <option value="7ft 8in - 234cm"
                                                {{ old('height') == '7ft 8in - 234cm' ? 'selected' : '' }}>7ft 8in - 234cm
                                            </option>
                                            <option value="7ft 9in - 236cm"
                                                {{ old('height') == '7ft 9in - 236cm' ? 'selected' : '' }}>7ft 9in - 236cm
                                            </option>
                                        </select>
                                        @error('height')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Weight</label>
                                        <input type="number" name="weight" class="form-control" placeholder="in kg"
                                            value="{{ old('weight') }}">
                                        @error('weight')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Complexion</label>
                                        <select name="complexion" data-placeholder="-- Select Complexion --"
                                            class="virtualSelect m-2" placeholder="Select Complexion">
                                             <option value="" disabled selected >--Select  --</option>

                                            <option value="Very Fair"
                                                {{ old('complexion') == 'Very Fair' ? 'selected' : '' }}>Very Fair
                                            </option>
                                            <option value="Fair" {{ old('complexion') == 'Fair' ? 'selected' : '' }}>
                                                Fair</option>
                                            <option value="Wheatish"
                                                {{ old('complexion') == 'Wheatish' ? 'selected' : '' }}>Wheatish</option>
                                            <option value="Wheatish Brown"
                                                {{ old('complexion') == 'Wheatish Brown' ? 'selected' : '' }}>Wheatish
                                                Brown</option>
                                            <option value="Dark" {{ old('complexion') == 'Dark' ? 'selected' : '' }}>
                                                Dark</option>
                                        </select>
                                        @error('complexion')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label>Body Type</label>
                                        <select name="body_type" data-placeholder="-- Select Body Type --"
                                            class="virtualSelect m-2">
                                            <option value="" disabled {{ old('body_type') ? '' : 'selected' }}>--
                                                Select Body Type --</option>
                                            <option value="Slim" {{ old('body_type') == 'Slim' ? 'selected' : '' }}>
                                                Slim</option>
                                            <option value="Athletic"
                                                {{ old('body_type') == 'Athletic' ? 'selected' : '' }}>Athletic</option>
                                            <option value="Average"
                                                {{ old('body_type') == 'Average' ? 'selected' : '' }}>Average</option>
                                            <option value="Heavy" {{ old('body_type') == 'Heavy' ? 'selected' : '' }}>
                                                Heavy</option>
                                        </select>
                                        @error('body_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label>Health Status</label>
                                        <select name="health_status" data-placeholder="-- Select Health Status --"
                                            class="virtualSelect m-2">
                                            <option value="" disabled {{ old('health_status') ? '' : 'selected' }}>
                                                -- Select Health Status --</option>


                                            <option value="Excellent"
                                                {{ old('health_status') == 'Excellent' ? 'selected' : '' }}>Excellent
                                            </option>
                                            <option value="Very Good"
                                                {{ old('health_status') == 'Very Good' ? 'selected' : '' }}>Very Good
                                            </option>
                                            <option value="Physically Challenged"
                                                {{ old('health_status') == 'Physically Challenged' ? 'selected' : '' }}>
                                                Physically Challenged
                                            </option>

                                            <option value="Good"
                                                {{ old('health_status') == 'Good' ? 'selected' : '' }}>Good</option>
                                            <option value="Average"
                                                {{ old('health_status') == 'Average' ? 'selected' : '' }}>Average</option>
                                            <option value="Minor Allergies"
                                                {{ old('health_status') == 'Minor Allergies' ? 'selected' : '' }}>Minor
                                                Allergies</option>
                                            <option value="Diabetes"
                                                {{ old('health_status') == 'Diabetes' ? 'selected' : '' }}>Diabetes
                                            </option>
                                            <option value="Low BP"
                                                {{ old('health_status') == 'Low BP' ? 'selected' : '' }}>Low BP</option>
                                            <option value="High BP"
                                                {{ old('health_status') == 'High BP' ? 'selected' : '' }}>High BP</option>
                                            <option value="Heart Ailments"
                                                {{ old('health_status') == 'Heart Ailments' ? 'selected' : '' }}>Heart
                                                Ailments</option>
                                            <option value="Minor Chronic Condition"
                                                {{ old('health_status') == 'Minor Chronic Condition' ? 'selected' : '' }}>
                                                Minor Chronic Condition</option>
                                            <option value="Major Chronic Condition"
                                                {{ old('health_status') == 'Major Chronic Condition' ? 'selected' : '' }}>
                                                Major Chronic Condition</option>
                                            <option value="Differently Abled (Physically Challenged)"
                                                {{ old('health_status') == 'Differently Abled (Physically Challenged)' ? 'selected' : '' }}>
                                                Differently Abled (Physically Challenged)</option>
                                            <option value="Mental Health Condition"
                                                {{ old('health_status') == 'Mental Health Condition' ? 'selected' : '' }}>
                                                Mental Health Condition</option>
                                            <option value="Recovering from Illness/Injury"
                                                {{ old('health_status') == 'Recovering from Illness/Injury' ? 'selected' : '' }}>
                                                Recovering from Illness/Injury</option>
                                            <option value="Prefer Not to Say"
                                                {{ old('health_status') == 'Prefer Not to Say' ? 'selected' : '' }}>Prefer
                                                Not to Say</option>
                                        </select>
                                        @error('health_status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Horoscope Status</label>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label>Time of Birth</label>
                                                <input type="time" name="time_of_birth" class="form-control"
                                                    placeholder="Enter time of birth"
                                                    value="{{ old('time_of_birth') }}">
                                                @error('time_of_birth')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-5">
                                                <label>Place of Birth</label>
                                                <input type="text" name="place_of_birth" class="form-control"
                                                    placeholder="Enter place of birth"
                                                    value="{{ old('place_of_birth') }}">
                                                @error('place_of_birth')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Family Details (Collapsible) --}}

                                <h5 class="mt-5">Family Details</h5>
                                <div class="row">
                                    <div class="form-group col-md-6 mt-2">
                                        <label>Father's Profession</label>
                                        <input type="text" name="father_profession" class="form-control"
                                            placeholder="Enter father's profession"
                                            value="{{ old('father_profession') }}">
                                        @error('father_profession')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Mother's Profession</label>
                                        <input type="text" name="mother_profession" class="form-control"
                                            placeholder="Enter mother's profession"
                                            value="{{ old('mother_profession') }}">
                                        @error('mother_profession')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="brothers">Number of Brothers</label>
                                        <select name="brothers" id="brothers" class="form-control">

                                            
                                            @for ($i = 0; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('brothers') == $i ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('brothers')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2 married_brothers">
                                        <label for="married_brothers">Married Brothers</label>
                                        <select name="married_brothers" id="married_brothers" class="form-control">
                                            <option value="" disabled
                                                {{ old('married_brothers') ? '' : 'selected' }}>-- Select --</option>
                                            @for ($i = 0; $i <= old('brothers', 0); $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('married_brothers') == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('married_brothers')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="sisters">Number of Sisters</label>
                                        <select name="sisters" id="sisters" class="form-control">
                                            <option value="" disabled {{ old('sisters') ? '' : 'selected' }}>--
                                                Select --</option>
                                            @for ($i = 0; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('sisters') == $i ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('sisters')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2 married_sisters">
                                        <label for="married_sisters">Married Sisters</label>
                                        <select name="married_sisters" id="married_sisters" class="form-control">
                                            <option value="" disabled
                                                {{ old('married_sisters') ? '' : 'selected' }}>-- Select --</option>
                                            @for ($i = 0; $i <= old('sisters', 0); $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('married_sisters') == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('married_sisters')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="family_type">Family Type</label>
                                        <select class="virtualSelect m-2" id="family_type" name="family_type">
                                          <option value="" disabled {{ old('family_type') == '' ? 'selected' : '' }}>-- Select --</option>

                                            @foreach (getFamilyTypeOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('family_type') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="family_affluence">Family Affluence</label>
                                        <select class="virtualSelect m-2" id="family_affluence" name="family_affluence">
                                                        <option value="" disabled {{ old('family_affluence') == '' ? 'selected' : '' }}>-- Select --</option>

                                            @foreach (getFamilyAffluenceOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('family_affluence') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_affluence')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="family_values">Family Values</label>
                                        <select class="virtualSelect m-2" id="family_values" name="family_values">
                                               <option value="" disabled {{ old('family_values') == '' ? 'selected' : '' }}>-- Select --</option>

                                            @foreach (getFamilyValuesOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('family_values') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_values')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Registering For</label>
                                        <select class="virtualSelect m-2" name="registering_for">
                                            <option value="" disabled
                                                {{ old('registering_for') ? '' : 'selected' }}>-- Registering For --
                                            </option>
                                            <option value="self"
                                                {{ old('registering_for') == 'self' ? 'selected' : '' }}>Myself</option>
                                            <option value="son"
                                                {{ old('registering_for') == 'son' ? 'selected' : '' }}>Son</option>
                                            <option value="daughter"
                                                {{ old('registering_for') == 'daughter' ? 'selected' : '' }}>Daughter
                                            </option>
                                            <option value="brother"
                                                {{ old('registering_for') == 'brother' ? 'selected' : '' }}>Brother
                                            </option>
                                            <option value="sister"
                                                {{ old('registering_for') == 'sister' ? 'selected' : '' }}>Sister</option>
                                            <option value="relative"
                                                {{ old('registering_for') == 'relative' ? 'selected' : '' }}>Relative
                                            </option>
                                            <option value="friend"
                                                {{ old('registering_for') == 'friend' ? 'selected' : '' }}>Friend</option>
                                            <option value="other"
                                                {{ old('registering_for') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('registering_for')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                {{-- Career Details (Collapsible) --}}
                                <h5 class="m-5">Career & Education Details</h5>
                                <div class="row">


                                    <div class="form-group col-md-6 mt-2">
                                        <label>Education Level</label>
                                        <select name="education_level" placeholder="Select Lelvel"
                                            class="virtualSelect m-2">
                                                   <option value="" disabled {{ old('education_level') == '' ? 'selected' : '' }}>-- Select --</option>

                                            @foreach (getEducationLevels() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('education_level') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach


                                        </select>

                                        @error('education_level')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-6 mt-2">
                                        <label>Education Field</label>
                                        <select name="education_field" class="virtualSelect m-2"
                                            placeholder="Select Field">
                                      <option value="" disabled {{ old('education_field') == '' ? 'selected' : '' }}>-- Select --</option>

                                            @foreach (getEducationFieldOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('education_field') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach

                                            <option value="Other"
                                                {{ old('education_field') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('education_field')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Highest Qualification</label>
                                        <input type="text" name="highest_qualification" class="form-control"
                                            placeholder="e.g., MBA, B.Tech" value="{{ old('highest_qualification') }}">

                                        @error('highest_qualification')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Occupation</label>
                                        <select name="occupation" class="virtualSelect m-2">
                                               <option value="" disabled {{ old('occupation') == '' ? 'selected' : '' }}>-- Select --</option>

                                            @foreach (getOccupationOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('occupation') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('occupation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Company Name</label>
                                        <input type="text" name="company_name" class="form-control"
                                            placeholder="e.g., Google, TCS" value="{{ old('company_name') }}">
                                        @error('company_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Annual Income</label>
                                        <select name="annual_income" class="virtualSelect m-2">
                                                <option value="" disabled {{ old('annual_income') == '' ? 'selected' : '' }}>-- Select --</option>

                                            @foreach (getIncomeRanges() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('annual_income') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('annual_income')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Work Location</label>
                                        <input type="text" name="work_location" class="form-control"
                                            placeholder="City, Country" value="{{ old('work_location') }}">
                                        @error('work_location')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <h5 class="mt-4">Partner Preference</h5>

                                <div class="row">
                                    <div class="form-group col-md-6 mt-2">
                                        <label>Preferred Age Range</label>
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <select class="virtualSelect m-2" name="partner_age_min">
                                                    <option value="" disabled selected>Minimum Age</option>
                                                    @for ($i = 18; $i <= 100; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ old('partner_age_min') == $i ? 'selected' : '' }}>
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span>to</span>
                                            </div>
                                            <div class="col-md-5">
                                                <select class="virtualSelect m-2" name="partner_age_max">
                                                    <option value="" disabled selected>Maximum Age</option>
                                                    @for ($i = 18; $i <= 100; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ old('partner_age_max') == $i ? 'selected' : '' }}>
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        @error('partner_age_min')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('partner_age_max')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label> Mother Tongue</label>
                                        <select id="partner_mother_tongue" data-placeholder="-- Select Mother Tongue --"
                                            name="partner_mother_tongue" class="virtualSelect m-2" multiple>
                                            @foreach ($tounges as $tongue)
                                                <option value="{{ $tongue->name }}"
                                                    {{ old('partner_mother_tongue') == $tongue->name ? 'selected' : '' }}>
                                                    {{ $tongue->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('partner_mother_tongue')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label for="partner_religion">Religion</label>
                                        <select id="partner_religion" name="partner_religion" class="virtualSelect m-2">
                                                <option value="" disabled {{ old('partner_religion') == '' ? 'selected' : '' }}>-- Select --</option>

                                            <option value="Hindu"
                                                {{ old('partner_religion') == 'Hindu' ? 'selected' : '' }}>Hindu
                                            </option>
                                            <option value="Muslim"
                                                {{ old('partner_religion') == 'Muslim' ? 'selected' : '' }}>
                                                Muslim</option>
                                            <option value="Christian"
                                                {{ old('partner_religion') == 'Christian' ? 'selected' : '' }}>Christian
                                            </option>
                                            <option value="Sikh"
                                                {{ old('partner_religion') == 'Sikh' ? 'selected' : '' }}>Sikh
                                            </option>
                                            <option value="Parsi"
                                                {{ old('partner_religion') == 'Parsi' ? 'selected' : '' }}>Parsi
                                            </option>
                                            <option value="Jain"
                                                {{ old('partner_religion') == 'Jain' ? 'selected' : '' }}>Jain
                                            </option>
                                            <option value="Buddhist"
                                                {{ old('partner_religion') == 'Buddhist' ? 'selected' : '' }}>
                                                Buddhist</option>
                                            <option value="Jewish"
                                                {{ old('partner_religion') == 'Jewish' ? 'selected' : '' }}>
                                                Jewish</option>
                                            <option value="No religion"
                                                {{ old('religion') == 'No Religion' ? 'selected' : '' }}>No Religion
                                            </option>
                                            <option value="Spiritual - not religious"
                                                {{ old('partner_religion') == 'Spiritual - not religious' ? 'selected' : '' }}>
                                                Spiritual - not religious</option>
                                            <option value="Other"
                                                {{ old('partner_religion') == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('partner_religion')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>






                                    <div class="form-group col-md-6">
                                        <label>Community</label>
                                        <select id="community" name="partner_community" class="virtualSelect m-2">
                                                <option value="" disabled {{ old('partner_community') == '' ? 'selected' : '' }}>-- Select --</option>

                                            <optgroup label="Hindu">
                                                <option value="Agarwal"
                                                    {{ old('partner_community') == 'Agarwal' ? 'selected' : '' }}>Agarwal
                                                </option>
                                                <option value="Arora"
                                                    {{ old('partner_community') == 'Arora' ? 'selected' : '' }}>
                                                    Arora</option>
                                                <option value="Brahmin"
                                                    {{ old('partner_community') == 'Brahmin' ? 'selected' : '' }}>Brahmin
                                                </option>
                                                <option value="Chaudhary"
                                                    {{ old('partner_community') == 'Chaudhary' ? 'selected' : '' }}>
                                                    Chaudhary
                                                </option>
                                                <option value="Gupta"
                                                    {{ old('partner_community') == 'Gupta' ? 'selected' : '' }}>
                                                    Gupta</option>
                                                <option value="Jat"
                                                    {{ old('partner_community') == 'Jat' ? 'selected' : '' }}>
                                                    Jat</option>
                                                <option value="Kayastha"
                                                    {{ old('partner_community') == 'Kayastha' ? 'selected' : '' }}>
                                                    Kayastha
                                                </option>
                                                <option value="Khatri"
                                                    {{ old('partner_community') == 'Khatri' ? 'selected' : '' }}>Khatri
                                                </option>
                                                <option value="Kshatriya"
                                                    {{ old('partner_community') == 'Kshatriya' ? 'selected' : '' }}>
                                                    Kshatriya
                                                </option>
                                                <option value="Maratha"
                                                    {{ old('partner_community') == 'Maratha' ? 'selected' : '' }}>Maratha
                                                </option>
                                                <option value="Marwari"
                                                    {{ old('partner_community') == 'Marwari' ? 'selected' : '' }}>Marwari
                                                </option>
                                                <option value="Nair"
                                                    {{ old('partner_community') == 'Nair' ? 'selected' : '' }}>
                                                    Nair</option>
                                                <option value="Patel"
                                                    {{ old('partner_community') == 'Patel' ? 'selected' : '' }}>Patel
                                                </option>
                                                <option value="Rajput"
                                                    {{ old('partner_community') == 'Rajput' ? 'selected' : '' }}>Rajput
                                                </option>
                                                <option value="Reddy"
                                                    {{ old('partner_community') == 'Reddy' ? 'selected' : '' }}>Reddy
                                                </option>
                                                <option value="Sindhi"
                                                    {{ old('partner_community') == 'Sindhi' ? 'selected' : '' }}>Sindhi
                                                </option>
                                                <option value="Yadav"
                                                    {{ old('partner_community') == 'Yadav' ? 'selected' : '' }}>Yadav
                                                </option>
                                                <option value="Iyer"
                                                    {{ old('partner_community') == 'Iyer' ? 'selected' : '' }}>
                                                    Iyer</option>
                                                <option value="Iyengar"
                                                    {{ old('partner_community') == 'Iyengar' ? 'selected' : '' }}>Iyengar
                                                </option>
                                                <option value="Chettiar"
                                                    {{ old('partner_community') == 'Chettiar' ? 'selected' : '' }}>
                                                    Chettiar
                                                </option>
                                                <option value="Gounder"
                                                    {{ old('partner_community') == 'Gounder' ? 'selected' : '' }}>Gounder
                                                </option>
                                                <option value="Mudaliar"
                                                    {{ old('partner_community') == 'Mudaliar' ? 'selected' : '' }}>
                                                    Mudaliar
                                                </option>
                                                <option value="Nadar"
                                                    {{ old('partner_community') == 'Nadar' ? 'selected' : '' }}>Nadar
                                                </option>
                                                <option value="Pillai"
                                                    {{ old('partner_community') == 'Pillai' ? 'selected' : '' }}>Pillai
                                                </option>
                                                <option value="Vokkaliga"
                                                    {{ old('partner_community') == 'Vokkaliga' ? 'selected' : '' }}>
                                                    Vokkaliga
                                                </option>
                                            </optgroup>
                                            <optgroup label="Muslim">
                                                <option value="Sunni"
                                                    {{ old('partner_community') == 'Sunni' ? 'selected' : '' }}>Sunni
                                                </option>
                                                <option value="Shia"
                                                    {{ old('partner_community') == 'Shia' ? 'selected' : '' }}>
                                                    Shia</option>
                                                <option value="Memon"
                                                    {{ old('partner_community') == 'Memon' ? 'selected' : '' }}>Memon
                                                </option>
                                                <option value="Khoja"
                                                    {{ old('partner_community') == 'Khoja' ? 'selected' : '' }}>Khoja
                                                </option>
                                                <option value="Syed"
                                                    {{ old('partner_community') == 'Syed' ? 'selected' : '' }}>
                                                    Syed</option>
                                                <option value="Pathan"
                                                    {{ old('partner_community') == 'Pathan' ? 'selected' : '' }}>Pathan
                                                </option>
                                            </optgroup>
                                            <optgroup label="Christian">
                                                <option value="Catholic"
                                                    {{ old('partner_community') == 'Catholic' ? 'selected' : '' }}>
                                                    Catholic
                                                </option>
                                                <option value="Protestant"
                                                    {{ old('partner_community') == 'Protestant' ? 'selected' : '' }}>
                                                    Protestant
                                                </option>
                                                <option value="Born Again"
                                                    {{ old('partner_community') == 'Born Again' ? 'selected' : '' }}>Born
                                                    Again
                                                </option>
                                                <option value="Orthodox"
                                                    {{ old('partner_community') == 'Orthodox' ? 'selected' : '' }}>
                                                    Orthodox
                                                </option>
                                            </optgroup>
                                            <optgroup label="Sikh">
                                                <option value="Ramgarhia"
                                                    {{ old('partner_community') == 'Ramgarhia' ? 'selected' : '' }}>
                                                    Ramgarhia
                                                </option>
                                                <option value="Jat Sikh"
                                                    {{ old('partner_community') == 'Jat Sikh' ? 'selected' : '' }}>Jat
                                                    Sikh
                                                </option>
                                                <option value="Khatri Sikh"
                                                    {{ old('partner_community') == 'Khatri Sikh' ? 'selected' : '' }}>
                                                    Khatri Sikh
                                                </option>
                                            </optgroup>
                                            <optgroup label="Jain">
                                                <option value="Digambar"
                                                    {{ old('partner_community') == 'Digambar' ? 'selected' : '' }}>
                                                    Digambar
                                                </option>
                                                <option value="Shwetambar"
                                                    {{ old('partner_community') == 'Shwetambar' ? 'selected' : '' }}>
                                                    Shwetambar
                                                </option>
                                                <option value="Terapanthi"
                                                    {{ old('partner_community') == 'Terapanthi' ? 'selected' : '' }}>
                                                    Terapanthi
                                                </option>
                                            </optgroup>
                                            <optgroup label="Other Communities">
                                                <option value="Parsi"
                                                    {{ old('partner_community') == 'Parsi' ? 'selected' : '' }}>Parsi
                                                </option>
                                                <option value="Zoroastrian"
                                                    {{ old('partner_community') == 'Zoroastrian' ? 'selected' : '' }}>
                                                    Zoroastrian
                                                </option>
                                                <option value="Other"
                                                    {{ old('partner_community') == 'Other' ? 'selected' : '' }}>Other
                                                </option>
                                            </optgroup>
                                        </select>
                                        @error('partner_community')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6 mt-2">
                                        <label for="partner_marital_status"> Marital Status</label>
                                        <select name="partner_marital_status" id="partner_marital_status"
                                            class="virtualSelect m-2">
                                            <option value="" disabled {{ old('partner_marital_status') == '' ? 'selected' : '' }}>-- Select --</option>
                                            @foreach (getMaritalStatusOptions() as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @error('partner_marital_status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label> Caste</label>
                                        <input type="text" name="partner_caste" class="form-control"
                                            placeholder="Enter preferred caste" value="{{ old('partner_caste') }}">
                                        @error('partner_caste')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label> Manglik</label>
                                        <select name="partner_manglik" class="virtualSelect m-2">
                                            <option value="" disabled {{ old('partner_manglik') == '' ? 'selected' : '' }}>-- Select --</option>
                                            @foreach (manglikOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('partner_manglik') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach

                                        </select>
                                        @error('partner_manglik')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label> Gotra</label>
                                        <input type="text" name="partner_gotra" class="form-control"
                                            placeholder="Enter preferred gotra" value="{{ old('partner_gotra') }}">
                                        @error('partner_gotra')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label> Education Field</label>
                                        <select name="partner_education_field" class="virtualSelect m-2">
                                            <option value="" disabled {{ old('partner_education_field') == '' ? 'selected' : '' }}>-- Select --</option>
                                            @foreach (getEducationFieldOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('partner_education_field') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('partner_education_field')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label> Occupation</label>
                                        <select name="partner_occupation" class="virtualSelect m-2">
                                            <option value="" disabled {{ old('partner_occupation') == '' ? 'selected' : '' }}>-- Select --</option>
                                            @foreach (getOccupationOptions() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('partner_occupation') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('partner_occupation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <label>Annual Income</label>
                                        <select name="partner_annual_income" class="virtualSelect m-2">
                                            <option value="" disabled {{ old('partner_annual_income') == '' ? 'selected' : '' }}>-- Select --</option>
                                            @foreach (getIncomeRanges() as $item)
                                                <option value="{{ $item }}"
                                                    {{ old('partner_annual_income') == $item ? 'selected' : '' }}>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('partner_annual_income')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>




                                </div>


                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('photo-input');
            const preview = document.getElementById('preview-images');

            let totalImages = 0;

            input.addEventListener('change', function() {
                const files = Array.from(this.files);

                if (totalImages + files.length > 15) {
                    alert(`You can only upload up to 15 images. You already added ${totalImages}.`);
                    this.value = '';
                    return;
                }

                files.forEach(file => {
                    if (!file.type.startsWith('image/')) return;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-2 mb-3';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        img.style.height = '120px';
                        img.style.width = '100%';
                        img.style.objectFit = 'cover';

                        col.appendChild(img);
                        preview.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                    totalImages++;
                });

                this.value = ''; // Clear input so reselecting same file again will work
            });


            // get country codes



        });


        async function loadCountries() {
            try {
                const countrySelect = $('#country_code');

                // Wait for response
                const response = await sendRequest("{{ route('get-countrys') }}", 'GET');

                // If your backend wraps in { status, data, message }
                const countries = response.data || response; // fallback if plain array

                // Clear old options
                countrySelect.empty();

                // Add default placeholder
                countrySelect.append('<option value="">Select Country</option>');

                // Add new options
                countries.forEach(country => {
                    countrySelect.append(
                        `<option  value="${country.code}"  ${country.dial_code === '+91' ? 'selected' : ''}>${country.name} (${country.dial_code})</option>`
                    );
                });

                // Initialize or refresh Select2


            } catch (error) {
                console.error('Error fetching country codes:', error);
            }
        }

        // Call it:
        loadCountries();
    </script>

    <script>
        $(document).ready(function() {
            // Example: Disable married brothers if brothers == 0
            $('#brothers').on('change', function() {
                let number = parseInt($(this).val());
                let $wrapper = $('.married_brothers');
                let $select = $('#married_brothers'); // Ensure this is the ID of your <select>

                if (isNaN(number) || number <= 0) {
                    $wrapper.addClass('d-none');
                    $select.empty().append('<option value="" selected disabled>-- Select --</option>');
                } else {
                    // Generate new options
                    let options = '<option value="" selected disabled>-- Select --</option>';
                    for (let i = 0; i <= number; i++) {
                        options += `<option value="${i}">${i}</option>`;
                    }

                    $select.empty().append(options);
                    $wrapper.removeClass('d-none');
                }
            });


            $('#sisters').on('change', function() {
                let number = parseInt($(this).val());
                let $wrapper = $('.married_sisters');
                let $select = $('#married_sisters'); // Ensure this is the ID of your <select>

                if (isNaN(number) || number <= 0) {
                    $wrapper.addClass('d-none');
                    $select.empty().append('<option value="" selected disabled>-- Select --</option>');
                } else {
                    // Generate new options
                    let options = '<option value="" selected disabled>-- Select --</option>';
                    for (let i = 0; i <= number; i++) {
                        options += `<option value="${i}">${i}</option>`;
                    }

                    $select.empty().append(options);
                    $wrapper.removeClass('d-none');
                }
            });



            // Trigger once on page load if values are prefilled
            $('#brothers').trigger('change');
            $('#sisters').trigger('change');
        });
    </script>
@endpush
