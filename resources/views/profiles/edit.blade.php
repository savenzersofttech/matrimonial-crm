@extends('layouts.sb2-layout')
@section('title', 'Edit Profile')

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="mb-0">Edit Profile</h4>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i data-feather="arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profiles.update', $profile) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            {{-- Personal Details --}}
                            <h5>Personal Details</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Full Name <sup class="text-danger">*</sup></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter full name"
                                        value="{{ old('name', $profile->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control select2">
                                        <option value="" disabled {{ old('gender', $profile->gender) ? '' : 'selected' }}>-- Select Gender --</option>
                                        <option value="male" {{ old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $profile->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Contact Number <sup class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <select id="country_code" name="country_code" class="form-control select2" style="max-width: 150px;">
                                            <option value="" {{ old('country_code', $profile->country_code) ? '' : 'selected' }}>Code</option>
                                        </select>
                                        <input type="text" id="phone" name="phone" maxlength="15" class="form-control"
                                            placeholder="Enter number" value="{{ old('phone', $profile->phone) }}" required>
                                    </div>
                                    @error('country_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="example@email.com" value="{{ old('email', $profile->email) }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" class="form-control"
                                        value="{{ old('dob', $profile->dob ? $profile->dob->format('Y-m-d') : '') }}">
                                    @error('dob')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="religion">Religion</label>
                                    <select id="religion" name="religion" class="form-control select2">
                                        <option value="" disabled {{ old('religion', $profile->religion) ? '' : 'selected' }}>-- Select Religion --</option>
                                        <option value="Hindu" {{ old('religion', $profile->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Muslim" {{ old('religion', $profile->religion) == 'Muslim' ? 'selected' : '' }}>Muslim</option>
                                        <option value="Christian" {{ old('religion', $profile->religion) == 'Christian' ? 'selected' : '' }}>Christian</option>
                                        <option value="Sikh" {{ old('religion', $profile->religion) == 'Sikh' ? 'selected' : '' }}>Sikh</option>
                                        <option value="Parsi" {{ old('religion', $profile->religion) == 'Parsi' ? 'selected' : '' }}>Parsi</option>
                                        <option value="Jain" {{ old('religion', $profile->religion) == 'Jain' ? 'selected' : '' }}>Jain</option>
                                        <option value="Buddhist" {{ old('religion', $profile->religion) == 'Buddhist' ? 'selected' : '' }}>Buddhist</option>
                                        <option value="Jewish" {{ old('religion', $profile->religion) == 'Jewish' ? 'selected' : '' }}>Jewish</option>
                                        <option value="No Religion" {{ old('religion', $profile->religion) == 'No Religion' ? 'selected' : '' }}>No Religion</option>
                                        <option value="Spiritual - not religious" {{ old('religion', $profile->religion) == 'Spiritual - not religious' ? 'selected' : '' }}>Spiritual - not religious</option>
                                        <option value="Other" {{ old('religion', $profile->religion) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('religion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Community</label>
                                    <select id="community" name="community" class="form-control select2">
                                        <option value="" disabled {{ old('community', $profile->community) ? '' : 'selected' }}>-- Select Community --</option>
                                        <optgroup label="Hindu">
                                            <option value="Agarwal" {{ old('community', $profile->community) == 'Agarwal' ? 'selected' : '' }}>Agarwal</option>
                                            <option value="Arora" {{ old('community', $profile->community) == 'Arora' ? 'selected' : '' }}>Arora</option>
                                            <option value="Brahmin" {{ old('community', $profile->community) == 'Brahmin' ? 'selected' : '' }}>Brahmin</option>
                                            <option value="Chaudhary" {{ old('community', $profile->community) == 'Chaudhary' ? 'selected' : '' }}>Chaudhary</option>
                                            <option value="Gupta" {{ old('community', $profile->community) == 'Gupta' ? 'selected' : '' }}>Gupta</option>
                                            <option value="Jat" {{ old('community', $profile->community) == 'Jat' ? 'selected' : '' }}>Jat</option>
                                            <option value="Kayastha" {{ old('community', $profile->community) == 'Kayastha' ? 'selected' : '' }}>Kayastha</option>
                                            <option value="Khatri" {{ old('community', $profile->community) == 'Khatri' ? 'selected' : '' }}>Khatri</option>
                                            <option value="Kshatriya" {{ old('community', $profile->community) == 'Kshatriya' ? 'selected' : '' }}>Kshatriya</option>
                                            <option value="Maratha" {{ old('community', $profile->community) == 'Maratha' ? 'selected' : '' }}>Maratha</option>
                                            <option value="Marwari" {{ old('community', $profile->community) == 'Marwari' ? 'selected' : '' }}>Marwari</option>
                                            <option value="Nair" {{ old('community', $profile->community) == 'Nair' ? 'selected' : '' }}>Nair</option>
                                            <option value="Patel" {{ old('community', $profile->community) == 'Patel' ? 'selected' : '' }}>Patel</option>
                                            <option value="Rajput" {{ old('community', $profile->community) == 'Rajput' ? 'selected' : '' }}>Rajput</option>
                                            <option value="Reddy" {{ old('community', $profile->community) == 'Reddy' ? 'selected' : '' }}>Reddy</option>
                                            <option value="Sindhi" {{ old('community', $profile->community) == 'Sindhi' ? 'selected' : '' }}>Sindhi</option>
                                            <option value="Yadav" {{ old('community', $profile->community) == 'Yadav' ? 'selected' : '' }}>Yadav</option>
                                            <option value="Iyer" {{ old('community', $profile->community) == 'Iyer' ? 'selected' : '' }}>Iyer</option>
                                            <option value="Iyengar" {{ old('community', $profile->community) == 'Iyengar' ? 'selected' : '' }}>Iyengar</option>
                                            <option value="Chettiar" {{ old('community', $profile->community) == 'Chettiar' ? 'selected' : '' }}>Chettiar</option>
                                            <option value="Gounder" {{ old('community', $profile->community) == 'Gounder' ? 'selected' : '' }}>Gounder</option>
                                            <option value="Mudaliar" {{ old('community', $profile->community) == 'Mudaliar' ? 'selected' : '' }}>Mudaliar</option>
                                            <option value="Nadar" {{ old('community', $profile->community) == 'Nadar' ? 'selected' : '' }}>Nadar</option>
                                            <option value="Pillai" {{ old('community', $profile->community) == 'Pillai' ? 'selected' : '' }}>Pillai</option>
                                            <option value="Vokkaliga" {{ old('community', $profile->community) == 'Vokkaliga' ? 'selected' : '' }}>Vokkaliga</option>
                                        </optgroup>
                                        <optgroup label="Muslim">
                                            <option value="Sunni" {{ old('community', $profile->community) == 'Sunni' ? 'selected' : '' }}>Sunni</option>
                                            <option value="Shia" {{ old('community', $profile->community) == 'Shia' ? 'selected' : '' }}>Shia</option>
                                            <option value="Memon" {{ old('community', $profile->community) == 'Memon' ? 'selected' : '' }}>Memon</option>
                                            <option value="Khoja" {{ old('community', $profile->community) == 'Khoja' ? 'selected' : '' }}>Khoja</option>
                                            <option value="Syed" {{ old('community', $profile->community) == 'Syed' ? 'selected' : '' }}>Syed</option>
                                            <option value="Pathan" {{ old('community', $profile->community) == 'Pathan' ? 'selected' : '' }}>Pathan</option>
                                        </optgroup>
                                        <optgroup label="Christian">
                                            <option value="Catholic" {{ old('community', $profile->community) == 'Catholic' ? 'selected' : '' }}>Catholic</option>
                                            <option value="Protestant" {{ old('community', $profile->community) == 'Protestant' ? 'selected' : '' }}>Protestant</option>
                                            <option value="Born Again" {{ old('community', $profile->community) == 'Born Again' ? 'selected' : '' }}>Born Again</option>
                                            <option value="Orthodox" {{ old('community', $profile->community) == 'Orthodox' ? 'selected' : '' }}>Orthodox</option>
                                        </optgroup>
                                        <optgroup label="Sikh">
                                            <option value="Ramgarhia" {{ old('community', $profile->community) == 'Ramgarhia' ? 'selected' : '' }}>Ramgarhia</option>
                                            <option value="Jat Sikh" {{ old('community', $profile->community) == 'Jat Sikh' ? 'selected' : '' }}>Jat Sikh</option>
                                            <option value="Khatri Sikh" {{ old('community', $profile->community) == 'Khatri Sikh' ? 'selected' : '' }}>Khatri Sikh</option>
                                        </optgroup>
                                        <optgroup label="Jain">
                                            <option value="Digambar" {{ old('community', $profile->community) == 'Digambar' ? 'selected' : '' }}>Digambar</option>
                                            <option value="Shwetambar" {{ old('community', $profile->community) == 'Shwetambar' ? 'selected' : '' }}>Shwetambar</option>
                                            <option value="Terapanthi" {{ old('community', $profile->community) == 'Terapanthi' ? 'selected' : '' }}>Terapanthi</option>
                                        </optgroup>
                                        <optgroup label="Other Communities">
                                            <option value="Parsi" {{ old('community', $profile->community) == 'Parsi' ? 'selected' : '' }}>Parsi</option>
                                            <option value="Zoroastrian" {{ old('community', $profile->community) == 'Zoroastrian' ? 'selected' : '' }}>Zoroastrian</option>
                                            <option value="Other" {{ old('community', $profile->community) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </optgroup>
                                    </select>
                                    @error('community')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="marital_status">Marital Status</label>
                                    <select name="marital_status" id="marital_status" class="form-control select2">
                                        <option value="" disabled {{ old('marital_status', $profile->marital_status) ? '' : 'selected' }}>-- Select Status --</option>
                                        <option value="unmarried" {{ old('marital_status', $profile->marital_status) == 'unmarried' ? 'selected' : '' }}>Unmarried</option>
                                        <option value="married" {{ old('marital_status', $profile->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                        <option value="divorced" {{ old('marital_status', $profile->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="widowed" {{ old('marital_status', $profile->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="separated" {{ old('marital_status', $profile->marital_status) == 'separated' ? 'selected' : '' }}>Separated</option>
                                        <option value="awaiting_divorce" {{ old('marital_status', $profile->marital_status) == 'awaiting_divorce' ? 'selected' : '' }}>Awaiting Divorce</option>
                                        <option value="annulled" {{ old('marital_status', $profile->marital_status) == 'annulled' ? 'selected' : '' }}>Annulled</option>
                                        <option value="prefer_not_to_say" {{ old('marital_status', $profile->marital_status) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer Not to Say</option>
                                    </select>
                                    @error('marital_status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mother_tongue">Mother Tongue</label>
                                    <select id="mother_tongue" data-placeholder="-- Select Mother Tongue --"
                                        name="mother_tongue[]" class="form-control select2" multiple>
                                        <option value="Assamese" {{ in_array('Assamese', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Assamese</option>
                                        <option value="Bengali" {{ in_array('Bengali', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Bengali</option>
                                        <option value="Bhojpuri" {{ in_array('Bhojpuri', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Bhojpuri</option>
                                        <option value="Dogri" {{ in_array('Dogri', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Dogri</option>
                                        <option value="English" {{ in_array('English', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>English</option>
                                        <option value="Garhwali" {{ in_array('Garhwali', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Garhwali</option>
                                        <option value="Gujarati" {{ in_array('Gujarati', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Gujarati</option>
                                        <option value="Haryanvi" {{ in_array('Haryanvi', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Haryanvi</option>
                                        <option value="Hindi" {{ in_array('Hindi', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Hindi</option>
                                        <option value="Kashmiri" {{ in_array('Kashmiri', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Kashmiri</option>
                                        <option value="Khandeshi" {{ in_array('Khandeshi', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Khandeshi</option>
                                        <option value="Konkani" {{ in_array('Konkani', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Konkani</option>
                                        <option value="Kodava" {{ in_array('Kodava', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Kodava</option>
                                        <option value="Kannada" {{ in_array('Kannada', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Kannada</option>
                                        <option value="Maithili" {{ in_array('Maithili', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Maithili</option>
                                        <option value="Malayalam" {{ in_array('Malayalam', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Malayalam</option>
                                        <option value="Manipuri" {{ in_array('Manipuri', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Manipuri</option>
                                        <option value="Marathi" {{ in_array('Marathi', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Marathi</option>
                                        <option value="Marwari" {{ in_array('Marwari', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Marwari</option>
                                        <option value="Mizo" {{ in_array('Mizo', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Mizo</option>
                                        <option value="Nagpuri" {{ in_array('Nagpuri', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Nagpuri</option>
                                        <option value="Nepali" {{ in_array('Nepali', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Nepali</option>
                                        <option value="Odia" {{ in_array('Odia', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Odia</option>
                                        <option value="Punjabi" {{ in_array('Punjabi', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Punjabi</option>
                                        <option value="Rajasthani" {{ in_array('Rajasthani', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Rajasthani</option>
                                        <option value="Sanskrit" {{ in_array('Sanskrit', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Sanskrit</option>
                                        <option value="Santhali" {{ in_array('Santhali', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Santhali</option>
                                        <option value="Sindhi" {{ in_array('Sindhi', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Sindhi</option>
                                        <option value="Sourashtra" {{ in_array('Sourashtra', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Sourashtra</option>
                                        <option value="Tamil" {{ in_array('Tamil', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Tamil</option>
                                        <option value="Telugu" {{ in_array('Telugu', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Telugu</option>
                                        <option value="Tulu" {{ in_array('Tulu', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Tulu</option>
                                        <option value="Urdu" {{ in_array('Urdu', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Urdu</option>
                                        <option value="Others" {{ in_array('Others', old('mother_tongue', $profile->mother_tongue ?? [])) ? 'selected' : '' }}>Others</option>
                                    </select>
                                    @error('mother_tongue')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Diet</label>
                                    <select name="diet[]" data-placeholder="-- Select Diet --" class="form-control select2" multiple>
                                        <option value="Veg" {{ in_array('Veg', old('diet', $profile->diet ?? [])) ? 'selected' : '' }}>Veg</option>
                                        <option value="Non-Veg" {{ in_array('Non-Veg', old('diet', $profile->diet ?? [])) ? 'selected' : '' }}>Non-Veg</option>
                                        <option value="Occasionally Non-Veg" {{ in_array('Occasionally Non-Veg', old('diet', $profile->diet ?? [])) ? 'selected' : '' }}>Occasionally Non-Veg</option>
                                        <option value="Eggetarian" {{ in_array('Eggetarian', old('diet', $profile->diet ?? [])) ? 'selected' : '' }}>Eggetarian</option>
                                        <option value="Jain" {{ in_array('Jain', old('diet', $profile->diet ?? [])) ? 'selected' : '' }}>Jain</option>
                                        <option value="Vegan" {{ in_array('Vegan', old('diet', $profile->diet ?? [])) ? 'selected' : '' }}>Vegan</option>
                                        <option value="No Onion No Garlic" {{ in_array('No Onion No Garlic', old('diet', $profile->diet ?? [])) ? 'selected' : '' }}>No Onion No Garlic</option>
                                        <option value="Other" {{ in_array('Other', old('diet', $profile->diet ?? [])) ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('diet')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Citizenship</label>
                                    <select name="citizenship" class="form-control select2">
                                        <option value="" disabled {{ old('citizenship', $profile->citizenship) ? '' : 'selected' }}>-- Select Citizenship --</option>
                                        <option value="Indian" {{ old('citizenship', $profile->citizenship) == 'Indian' ? 'selected' : '' }}>Indian</option>
                                        <option value="American" {{ old('citizenship', $profile->citizenship) == 'American' ? 'selected' : '' }}>American</option>
                                        <option value="Canadian" {{ old('citizenship', $profile->citizenship) == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                        <option value="British" {{ old('citizenship', $profile->citizenship) == 'British' ? 'selected' : '' }}>British</option>
                                        <option value="Australian" {{ old('citizenship', $profile->citizenship) == 'Australian' ? 'selected' : '' }}>Australian</option>
                                        <option value="New Zealander" {{ old('citizenship', $profile->citizenship) == 'New Zealander' ? 'selected' : '' }}>New Zealander</option>
                                        <option value="Singaporean" {{ old('citizenship', $profile->citizenship) == 'Singaporean' ? 'selected' : '' }}>Singaporean</option>
                                        <option value="Pakistani" {{ old('citizenship', $profile->citizenship) == 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                                        <option value="Bangladeshi" {{ old('citizenship', $profile->citizenship) == 'Bangladeshi' ? 'selected' : '' }}>Bangladeshi</option>
                                        <option value="Nepalese" {{ old('citizenship', $profile->citizenship) == 'Nepalese' ? 'selected' : '' }}>Nepalese</option>
                                        <option value="Sri Lankan" {{ old('citizenship', $profile->citizenship) == 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan</option>
                                        <option value="UAE" {{ old('citizenship', $profile->citizenship) == 'UAE' ? 'selected' : '' }}>UAE</option>
                                        <option value="Saudi Arabian" {{ old('citizenship', $profile->citizenship) == 'Saudi Arabian' ? 'selected' : '' }}>Saudi Arabian</option>
                                        <option value="Qatari" {{ old('citizenship', $profile->citizenship) == 'Qatari' ? 'selected' : '' }}>Qatari</option>
                                        <option value="Kuwaiti" {{ old('citizenship', $profile->citizenship) == 'Kuwaiti' ? 'selected' : '' }}>Kuwaiti</option>
                                        <option value="Malaysian" {{ old('citizenship', $profile->citizenship) == 'Malaysian' ? 'selected' : '' }}>Malaysian</option>
                                        <option value="Other" {{ old('citizenship', $profile->citizenship) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('citizenship')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Drinking</label>
                                    <select name="drinking[]" data-placeholder="-- Select Drinking --" class="form-control select2" multiple>
                                        <option value="no" {{ in_array('no', old('drinking', $profile->drinking ?? [])) ? 'selected' : '' }}>No</option>
                                        <option value="yes" {{ in_array('yes', old('drinking', $profile->drinking ?? [])) ? 'selected' : '' }}>Yes</option>
                                        <option value="Occasionally" {{ in_array('Occasionally', old('drinking', $profile->drinking ?? [])) ? 'selected' : '' }}>Occasionally</option>
                                        <option value="prefer_not_to_say" {{ in_array('prefer_not_to_say', old('drinking', $profile->drinking ?? [])) ? 'selected' : '' }}>Prefer Not to Say</option>
                                    </select>
                                    @error('drinking')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Smoking</label>
                                    <select name="smoking[]" data-placeholder="-- Select Smoking --" class="form-control select2" multiple>
                                        <option value="No" {{ in_array('No', old('smoking', $profile->smoking ?? [])) ? 'selected' : '' }}>No</option>
                                        <option value="Yes" {{ in_array('Yes', old('smoking', $profile->smoking ?? [])) ? 'selected' : '' }}>Yes</option>
                                        <option value="Occasionally" {{ in_array('Occasionally', old('smoking', $profile->smoking ?? [])) ? 'selected' : '' }}>Occasionally</option>
                                        <option value="prefer_not_to_say" {{ in_array('prefer_not_to_say', old('smoking', $profile->smoking ?? [])) ? 'selected' : '' }}>Prefer Not to Say</option>
                                    </select>
                                    @error('smoking')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Blood Group</label>
                                    <select name="blood_group" data-placeholder="-- Select Blood Group --" class="form-control select2">
                                        <option value="" disabled {{ old('blood_group', $profile->blood_group) ? '' : 'selected' }}>-- Select Blood Group --</option>
                                        <option value="Don't Know" {{ old('blood_group', $profile->blood_group) == 'Don\'t Know' ? 'selected' : '' }}>Don't Know</option>
                                        <option value="A+" {{ old('blood_group', $profile->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_group', $profile->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_group', $profile->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_group', $profile->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_group', $profile->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_group', $profile->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_group', $profile->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_group', $profile->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                    @error('blood_group')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Your Height</label>
                                    <select class="form-control select2" name="height">
                                        <option value="" disabled {{ old('height', $profile->height) ? '' : 'selected' }}>-- Select Height --</option>
                                        <option value="4ft 0in - 122cm" {{ old('height', $profile->height) == '4ft 0in - 122cm' ? 'selected' : '' }}>4ft 0in - 122cm</option>
                                        <option value="4ft 1in - 124cm" {{ old('height', $profile->height) == '4ft 1in - 124cm' ? 'selected' : '' }}>4ft 1in - 124cm</option>
                                        <option value="4ft 2in - 127cm" {{ old('height', $profile->height) == '4ft 2in - 127cm' ? 'selected' : '' }}>4ft 2in - 127cm</option>
                                        <option value="4ft 3in - 130cm" {{ old('height', $profile->height) == '4ft 3in - 130cm' ? 'selected' : '' }}>4ft 3in - 130cm</option>
                                        <option value="4ft 4in - 132cm" {{ old('height', $profile->height) == '4ft 4in - 132cm' ? 'selected' : '' }}>4ft 4in - 132cm</option>
                                        <option value="4ft 5in - 134cm" {{ old('height', $profile->height) == '4ft 5in - 134cm' ? 'selected' : '' }}>4ft 5in - 134cm</option>
                                        <option value="4ft 6in - 137cm" {{ old('height', $profile->height) == '4ft 6in - 137cm' ? 'selected' : '' }}>4ft 6in - 137cm</option>
                                        <option value="4ft 7in - 140cm" {{ old('height', $profile->height) == '4ft 7in - 140cm' ? 'selected' : '' }}>4ft 7in - 140cm</option>
                                        <option value="4ft 8in - 142cm" {{ old('height', $profile->height) == '4ft 8in - 142cm' ? 'selected' : '' }}>4ft 8in - 142cm</option>
                                        <option value="4ft 9in - 145cm" {{ old('height', $profile->height) == '4ft 9in - 145cm' ? 'selected' : '' }}>4ft 9in - 145cm</option>
                                        <option value="4ft 10in - 147cm" {{ old('height', $profile->height) == '4ft 10in - 147cm' ? 'selected' : '' }}>4ft 10in - 147cm</option>
                                        <option value="4ft 11in - 150cm" {{ old('height', $profile->height) == '4ft 11in - 150cm' ? 'selected' : '' }}>4ft 11in - 150cm</option>
                                        <option value="5ft 0in - 152cm" {{ old('height', $profile->height) == '5ft 0in - 152cm' ? 'selected' : '' }}>5ft 0in - 152cm</option>
                                        <option value="5ft 1in - 155cm" {{ old('height', $profile->height) == '5ft 1in - 155cm' ? 'selected' : '' }}>5ft 1in - 155cm</option>
                                        <option value="5ft 2in - 157cm" {{ old('height', $profile->height) == '5ft 2in - 157cm' ? 'selected' : '' }}>5ft 2in - 157cm</option>
                                        <option value="5ft 3in - 160cm" {{ old('height', $profile->height) == '5ft 3in - 160cm' ? 'selected' : '' }}>5ft 3in - 160cm</option>
                                        <option value="5ft 4in - 163cm" {{ old('height', $profile->height) == '5ft 4in - 163cm' ? 'selected' : '' }}>4ft 4in - 163cm</option>
                                        <option value="5ft 5in - 165cm" {{ old('height', $profile->height) == '5ft 5in - 165cm' ? 'selected' : '' }}>5ft 5in - 165cm</option>
                                        <option value="5ft 6in - 168cm" {{ old('height', $profile->height) == '5ft 6in - 168cm' ? 'selected' : '' }}>5ft 6in - 168cm</option>
                                        <option value="5ft 7in - 170cm" {{ old('height', $profile->height) == '5ft 7in - 170cm' ? 'selected' : '' }}>5ft 7in - 170cm</option>
                                        <option value="5ft 8in - 173cm" {{ old('height', $profile->height) == '5ft 8in - 173cm' ? 'selected' : '' }}>5ft 8in - 173cm</option>
                                        <option value="5ft 9in - 175cm" {{ old('height', $profile->height) == '5ft 9in - 175cm' ? 'selected' : '' }}>5ft 9in - 175cm</option>
                                        <option value="5ft 10in - 178cm" {{ old('height', $profile->height) == '5ft 10in - 178cm' ? 'selected' : '' }}>5ft 10in - 178cm</option>
                                        <option value="5ft 11in - 180cm" {{ old('height', $profile->height) == '5ft 11in - 180cm' ? 'selected' : '' }}>5ft 11in - 180cm</option>
                                        <option value="6ft 0in - 183cm" {{ old('height', $profile->height) == '6ft 0in - 183cm' ? 'selected' : '' }}>6ft 0in - 183cm</option>
                                        <option value="6ft 1in - 185cm" {{ old('height', $profile->height) == '6ft 1in - 185cm' ? 'selected' : '' }}>6ft 1in - 185cm</option>
                                        <option value="6ft 2in - 188cm" {{ old('height', $profile->height) == '6ft 2in - 188cm' ? 'selected' : '' }}>6ft 2in - 188cm</option>
                                        <option value="6ft 3in - 190cm" {{ old('height', $profile->height) == '6ft 3in - 190cm' ? 'selected' : '' }}>6ft 3in - 190cm</option>
                                        <option value="6ft 4in - 193cm" {{ old('height', $profile->height) == '6ft 4in - 193cm' ? 'selected' : '' }}>6ft 4in - 193cm</option>
                                        <option value="6ft 5in - 196cm" {{ old('height', $profile->height) == '6ft 5in - 196cm' ? 'selected' : '' }}>6ft 5in - 196cm</option>
                                        <option value="6ft 6in - 198cm" {{ old('height', $profile->height) == '6ft 6in - 198cm' ? 'selected' : '' }}>6ft 6in - 198cm</option>
                                        <option value="6ft 7in - 201cm" {{ old('height', $profile->height) == '6ft 7in - 201cm' ? 'selected' : '' }}>6ft 7in - 201cm</option>
                                        <option value="6ft 8in - 203cm" {{ old('height', $profile->height) == '6ft 8in - 203cm' ? 'selected' : '' }}>6ft 8in - 203cm</option>
                                        <option value="6ft 9in - 206cm" {{ old('height', $profile->height) == '6ft 9in - 206cm' ? 'selected' : '' }}>6ft 9in - 206cm</option>
                                        <option value="6ft 10in - 208cm" {{ old('height', $profile->height) == '6ft 10in - 208cm' ? 'selected' : '' }}>6ft 10in - 208cm</option>
                                        <option value="6ft 11in - 211cm" {{ old('height', $profile->height) == '6ft 11in - 211cm' ? 'selected' : '' }}>6ft 11in - 211cm</option>
                                        <option value="7ft 0in - 213cm" {{ old('height', $profile->height) == '7ft 0in - 213cm' ? 'selected' : '' }}>7ft 0in - 213cm</option>
                                        <option value="7ft 1in - 216cm" {{ old('height', $profile->height) == '7ft 1in - 216cm' ? 'selected' : '' }}>7ft 1in - 216cm</option>
                                        <option value="7ft 2in - 218cm" {{ old('height', $profile->height) == '7ft 2in - 218cm' ? 'selected' : '' }}>7ft 2in - 218cm</option>
                                        <option value="7ft 3in - 221cm" {{ old('height', $profile->height) == '7ft 3in - 221cm' ? 'selected' : '' }}>7ft 3in - 221cm</option>
                                        <option value="7ft 4in - 224cm" {{ old('height', $profile->height) == '7ft 4in - 224cm' ? 'selected' : '' }}>7ft 4in - 224cm</option>
                                        <option value="7ft 5in - 226cm" {{ old('height', $profile->height) == '7ft 5in - 226cm' ? 'selected' : '' }}>7ft 5in - 226cm</option>
                                        <option value="7ft 6in - 229cm" {{ old('height', $profile->height) == '7ft 6in - 229cm' ? 'selected' : '' }}>6ft 6in - 229cm</option>
                                        <option value="7ft 7in - 231cm" {{ old('height', $profile->height) == '7ft 7in - 231cm' ? 'selected' : '' }}>7ft 7in - 231cm</option>
                                        <option value="7ft 8in - 234cm" {{ old('height', $profile->height) == '7ft 8in - 234cm' ? 'selected' : '' }}>7ft 8in - 234cm</option>
                                        <option value="7ft 9in - 236cm" {{ old('height', $profile->height) == '7ft 9in - 236cm' ? 'selected' : '' }}>7ft 9in - 236cm</option>
                                    </select>
                                    @error('height')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Health Status</label>
                                    <select name="health_status" data-placeholder="-- Select Health Status --" class="form-control select2">
                                        <option value="" disabled {{ old('health_status', $profile->health_status) ? '' : 'selected' }}>-- Select Health Status --</option>
                                        <option value="Excellent" {{ old('health_status', $profile->health_status) == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="Very Good" {{ old('health_status', $profile->health_status) == 'Very Good' ? 'selected' : '' }}>Very Good</option>
                                        <option value="Good" {{ old('health_status', $profile->health_status) == 'Good' ? 'selected' : '' }}>Good</option>
                                        <option value="Average" {{ old('health_status', $profile->health_status) == 'Average' ? 'selected' : '' }}>Average</option>
                                        <option value="Minor Allergies" {{ old('health_status', $profile->health_status) == 'Minor Allergies' ? 'selected' : '' }}>Minor Allergies</option>
                                        <option value="Diabetes" {{ old('health_status', $profile->health_status) == 'Diabetes' ? 'selected' : '' }}>Diabetes</option>
                                        <option value="Low BP" {{ old('health_status', $profile->health_status) == 'Low BP' ? 'selected' : '' }}>Low BP</option>
                                        <option value="High BP" {{ old('health_status', $profile->health_status) == 'High BP' ? 'selected' : '' }}>High BP</option>
                                        <option value="Heart Ailments" {{ old('health_status', $profile->health_status) == 'Heart Ailments' ? 'selected' : '' }}>Heart Ailments</option>
                                        <option value="Minor Chronic Condition" {{ old('health_status', $profile->health_status) == 'Minor Chronic Condition' ? 'selected' : '' }}>Minor Chronic Condition</option>
                                        <option value="Major Chronic Condition" {{ old('health_status', $profile->health_status) == 'Major Chronic Condition' ? 'selected' : '' }}>Major Chronic Condition</option>
                                        <option value="Differently Abled (Physically Challenged)" {{ old('health_status', $profile->health_status) == 'Differently Abled (Physically Challenged)' ? 'selected' : '' }}>Differently Abled (Physically Challenged)</option>
                                        <option value="Mental Health Condition" {{ old('health_status', $profile->health_status) == 'Mental Health Condition' ? 'selected' : '' }}>Mental Health Condition</option>
                                        <option value="Recovering from Illness/Injury" {{ old('health_status', $profile->health_status) == 'Recovering from Illness/Injury' ? 'selected' : '' }}>Recovering from Illness/Injury</option>
                                        <option value="Prefer Not to Say" {{ old('health_status', $profile->health_status) == 'Prefer Not to Say' ? 'selected' : '' }}>Prefer Not to Say</option>
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
                                                placeholder="Enter time of birth" value="{{ old('time_of_birth', $profile->time_of_birth ? $profile->time_of_birth->format('H:i') : '') }}">
                                            @error('time_of_birth