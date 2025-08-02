<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Gothra;
use App\Models\MotherTongue;
use App\Models\PartnerPreference;
use App\Models\Profile;
use App\Models\ProfileSource;
use App\Models\Religion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\URL;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class CustomerProfileController extends Controller
{

    public function index()
    {
        $profiles = Profile::all();
        // dd($profiles->toArray());
        $tounges       = MotherTongue::all();
        $ProfileSource = ProfileSource::all();
        $religion      = Religion::all();
        $gotras        = Gothra::all();
        $casts         = Community::all();
        $role           = Auth::user()->role;
        // dd($profileId);
        return view('profiles.index', data: compact(
            'profiles',
            'tounges',
            'ProfileSource',
            'religion',
            'gotras',
            'role',    
        ));
    }

    public function showCasts(Request $request)
    {
        $religionId = $request->input('religionId'); 

        $casts = Community::select('id', 'name')->where('religion_id', $religionId)->get();

        return response()->json([
            'casts'   => $casts,
            'success' => true,
        ]);
    }

    public function show($profileId): View
    {
        $profile = Profile::with(['partnerPreference','religionData', 'casteData'])->findOrFail($profileId);
        $tounges       = MotherTongue::all();
        $ProfileSource = ProfileSource::all();
        $religion      = Religion::all();
        $gotras        = Gothra::all();
        
        // $religion = Profile::join('religions', 'profiles.religion', '=', 'religions.id')
        //           ->select('profiles.*', 'religions.name as religion_name')
        //           ->where('religions.id', $religion)
        //           ->get();


        return view('profiles.view', compact('profile', 'ProfileSource', 'tounges', 'religion', 'gotras'));
    }

    public function showAll(Request $request)
    {
        $dbColumns = (new Profile)->getFillable();
        // dd($dbColumns);
        $order     = $request->post('order');
        $start     = $request->post('start') ?? 0;
        $length    = $request->post('length') ?? 10;
        $search    = $request->post('search')['value'] ?? null;

        $query = Profile::selectRaw('*')
            ->with(['creator']);

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($dbColumns, $search) {
                foreach ($dbColumns as $key => $column) {
                    if ($key === 0) {
                        $q->where($column, 'like', "%$search%");
                    } else {
                        $q->orWhere($column, 'like', "%$search%");
                    }
                }
            });
        }

        // Order
        if (isset($order[0]['dir'])) {
    $dir      = $order[0]['dir'];
    $colIndex = $order[0]['column'] ?? false;
    $col      = $dbColumns[$colIndex] ?? false;
    if ($col) {
            $query->orderBy($col, $dir);
        }
    } else {
        $query->orderBy('profiles.id', 'desc'); // Default fallback
    }


        // Count recordsFiltered before applying limit & offset
        $recordsFiltered = $query->count(DB::raw($start ? "$start" : "1"));

        // Pagination
        $data = $query->offset($start)->limit($length)->get()->toArray();
        // Add serial number manually based on pagination offset
        foreach ($data as $index => &$item) {
            $item['s_no'] = $start + $index + 1;

            $item['created_at'] = \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y h:i A');
            $item['updated_at'] = \Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y h:i A');
        }
        // Total records
        $recordsTotal = Profile::count();

        // Prepare response
        $draw = $request->post('draw');

        $response = [
            'draw'            => intval($draw),
            'recordsTotal'    => intval($recordsTotal),
            'recordsFiltered' => intval($recordsFiltered),
            'data'            => $data,
        ];

        return response()->json($response);
    }

    public function generateProfileId(string $fullName, string $mobile): string
    {
        return DB::transaction(function () use ($fullName, $mobile) {
            $prefix = 'EB';

            // Extract first two letters from name (uppercase, skip spaces)
            $initials = strtoupper(substr(preg_replace('/\s+/', '', $fullName), 0, 2));

            // Get last 4 digits of mobile
            $last4 = substr(preg_replace('/\D/', '', $mobile), -4);

            // // Lock for concurrency-safe serial increment
            // $index = DB::table('profile_indexes')->lockForUpdate()->first();

            // if (!$index) {
            //     DB::table('profile_indexes')->insert([
            //         'last_number' => 1,
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            //     $number = 1;
            // } else {
            //     $number = $index->last_number + 1;
            //     DB::table('profile_indexes')->update([
            //         'last_number' => $number,
            //         'updated_at' => now(),
            //     ]);
            // }

            // $serial = str_pad($number, 4, '0', STR_PAD_LEFT);

            return "{$prefix}{$initials}{$last4}";
        });
    }

    /**
     * Store a newly created profile in storage.
     */
    public function store(Request $request)
    {
        /** -----------------------------------
         * 1. Normalize phone numbers
         * ----------------------------------- */
        $request->merge([
            'phone_number' => $request->phone_code . preg_replace('/\s+/', '', $request->phone_number),
            'alternative_phone_number' => $request->filled('alternative_phone_number')
                ? $request->alternative_phone_code . preg_replace('/\s+/', '', $request->alternative_phone_number)
                : null,
        ]);

        /** -----------------------------------
         * 2. Handle partner preferences (array fields)
         * ----------------------------------- */
        $partner = $request->input('partner', []);
        $partnerArrayFields = [
            'manglik_status', 'highest_qualification', 'citizenship', 'education_field', 'employer_name',
            'profession', 'diet', 'drinking_status', 'smoking_status', 'marital_status',
            'mother_tongue', 'religion', 'caste', 'annual_income', 'grow_up_in',
            'country', 'state', 'city',
        ];
    
        foreach ($partnerArrayFields as $field) {
            $value = $partner[$field] ?? null;
    
            if (blank($value)) {
                unset($partner[$field]);
                continue;
            }
    
            $partner[$field] = json_encode(
                is_array($value)
                    ? array_values(array_filter($value, fn($v) => filled($v)))
                    : [$value]
            );
        }
        $request->merge(['partner' => $partner]);
    
        /** -----------------------------------
         * 3. Handle top-level array fields (other arrays)
         * ----------------------------------- */
        $topArrayFields = ['grow_up_in', 'highest_qualification', 'education_field', 'profession'];
        foreach ($topArrayFields as $field) {
            $value = $request->input($field);
            if (blank($value)) {
                $request->request->remove($field);
                continue;
            }
            $cleaned = is_array($value)
                ? array_values(array_filter($value, fn($v) => filled($v)))
                : [$value];
            $request->merge([$field => $cleaned]);
        }
    
        /** -----------------------------------
         * 4. Validation
         * ----------------------------------- */
        $validator = Validator::make($request->all(), [
            'profile_source_id' => 'exists:profile_sources,id',
            'profile_source_comment' => 'nullable|string',
            'name' => 'required|string|max:255',
            'gender' => 'in:Male,Female',
            'email' => ['nullable', 'email', Rule::unique('profiles', 'email')],
            'alternative_email' => ['nullable', 'email', Rule::unique('profiles', 'alternative_email')],
            'phone_number' => ['required', 'string', 'regex:/^\+\d{10,15}$/', Rule::unique('profiles', 'phone_number')],
            'alternative_phone_number' => [
                'nullable', 
                'string', 
                'regex:/^\+\d{10,15}$/', 
                Rule::unique('profiles', 'alternative_phone_number')
            ],
            // 'govt_id_status' => 'nullable|string|in:verified,non_verified',
            'govt_id_status' => 'nullable|in:1,0',
            'government_id' => 'nullable|array|max:5',
            'government_id.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'nullable|array|max:5',
            'photo.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'contact_person_name' => 'nullable|string|max:255',
            'profile_for' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string',
            'height' => 'nullable|string',
            'mother_tongue' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'body_type' => 'nullable|string',
            'complexion' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'health_status' => 'nullable|string',
            'native_place' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'bio' => 'nullable|string|min:100',
            'religion' => 'nullable|string',
            'caste' => 'nullable|string',
            'sub_caste' => 'nullable|string',
            'gotra' => 'nullable|string',
            'birth_time' => 'nullable|date_format:H:i',
            'birth_place' => 'nullable|string',
            'manglik_status' => 'nullable|string',
            'institute_name' => 'nullable|string',
            'work_location' => 'nullable|string',
            'employer_name' => 'nullable|string',
            'business_name' => 'nullable|string',
            'designation' => 'nullable|string',
            'annual_income' => 'nullable|string',
            'diet' => 'nullable|string',
            'drinking_status' => 'nullable|string',
            'smoking_status' => 'nullable|string',
            'father_occupation' => 'nullable|string',
            'mother_occupation' => 'nullable|string',
            'brother_count' => 'nullable|integer|min:0|max:5',
            'married_brother_count' => 'nullable|integer|min:0|max:5',
            'sister_count' => 'nullable|integer|min:0|max:5',
            'married_sister_count' => 'nullable|integer|min:0|max:5',
            'family_type' => 'nullable|string',
            'family_affluence' => 'nullable|string',
            'family_values' => 'nullable|string',
            'family_bio' => 'nullable|string|min:100',
            'password' => 'nullable|string|min:8|confirmed',
    
            // Partner validations
            'partner.min_age' => 'nullable|integer|min:18|max:100',
            'partner.max_age' => 'nullable|integer|min:18|max:100',
            'partner.min_height' => 'nullable|string',
            'partner.max_height' => 'nullable|string',
            'partner.country' => 'nullable|string',
            'partner.state' => 'nullable|string',
            'partner.city' => 'nullable|string',
            'partner.citizenship' => 'nullable|string',
            'partner.designation' => 'nullable|string',
            'partner.annual_income' => 'nullable|string',
            'partner.annual_income.*' => 'nullable|string',
            'partner.about' => 'nullable|string',
        ]);
    
        // Custom validation logic
        $validator->after(function ($validator) use ($request) {
            if ($request->filled('married_brother_count') && $request->filled('brother_count') && $request->married_brother_count > $request->brother_count) {
                $validator->errors()->add('married_brother_count', 'Married brothers cannot exceed total brothers.');
            }
            if ($request->filled('married_sister_count') && $request->filled('sister_count') && $request->married_sister_count > $request->sister_count) {
                $validator->errors()->add('married_sister_count', 'Married sisters cannot exceed total sisters.');
            }
        });
    
        if ($validator->fails()) {
            return response()->json(['validationError' => $validator->errors()], 200);
        }
        
        /** -----------------------------------
         * 4.5 Replace "Other" fields with custom input
         * ----------------------------------- */
        $otherFields = [
            'mother_tongue',
            'health_status',
            'religion',
            'diet',
            'body_type',
            'profile_for',
            'caste',
            'highest_qualification',
            'education_field',
            'employer_name',
            'profession',
            'father_occupation',
            'mother_occupation',
        ];
        
        foreach ($otherFields as $field) {
            $selected = $request->input($field);
            $custom = $request->input("{$field}_other");
        
            if ($selected === 'Other' && filled($custom)) {
                $request->merge([$field => $custom]);
            }
        }
        
        // Same for partner fields
        $partnerOtherFields = [
            'religion',
            'cast',
            'diet',
            'highest_qualification',
            'education_field',
            'working_with',
            'profession',
        ];
        
        foreach ($partnerOtherFields as $field) {
            $selected = $request->input("partner.{$field}");
            $custom = $request->input("partner_{$field}_other");
        
            if ($selected === 'Other' && filled($custom)) {
                $request->merge(["partner.{$field}" => $custom]);
            }
        }
    
        /** -----------------------------------
         * 5. Build profile data for saving
         * ----------------------------------- */
        $profileData = $request->only([
            'profile_source_id', 'govt_id_status', 'profile_source_comment', 'email', 'alternative_email',
            'phone_number', 'alternative_phone_number', 'contact_person_name', 'profile_for',
            'name', 'gender', 'date_of_birth', 'marital_status', 'height', 'mother_tongue',
            'weight', 'body_type', 'complexion', 'blood_group', 'health_status', 'native_place',
            'country', 'state', 'city', 'bio', 'religion', 'caste', 'sub_caste',
            'gotra', 'birth_time', 'birth_place', 'manglik_status', 'institute_name',
            'work_location', 'employer_name', 'business_name', 'designation', 'annual_income',
            'diet', 'drinking_status', 'smoking_status', 'father_occupation', 'mother_occupation',
            'brother_count', 'married_brother_count', 'sister_count', 'married_sister_count',
            'family_type', 'family_affluence', 'family_values', 'family_bio',
        ]);
    
        // Convert top-level arrays to JSON
        foreach ($topArrayFields as $field) {
            if ($request->has($field)) {
                $profileData[$field] = json_encode($request->input($field));
            }
        }
    
        // Convert citizenship array to JSON
        if ($request->has('citizenship')) {
            $profileData['citizenship'] = json_encode($request->input('citizenship'));
        }
    
        /** -----------------------------------
         * 6. Handle file uploads
         * ----------------------------------- */
        $namePrefix = Str::slug($request->input('name'), '-') ?: 'profile';
        $dateTime = now('Asia/Kolkata')->format('Ymd-His');
        $random = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    
        if ($request->hasFile('government_id')) {
            $govtFilePaths = array_map(function ($file, $index) use ($namePrefix, $dateTime, $random) {
                $filename = "{$namePrefix}-{$dateTime}-" . str_pad((int)$random + $index, 6, '0', STR_PAD_LEFT) . '.' . $file->getClientOriginalExtension();
                return $file->storeAs('government_ids', $filename, 'public');
            }, $request->file('government_id'), array_keys($request->file('government_id')));
            $profileData['government_id'] = json_encode($govtFilePaths);
        }
    
        if ($request->hasFile('photo')) {
            $photoFilePaths = array_map(function ($file, $index) use ($namePrefix, $dateTime, $random) {
                $filename = "{$namePrefix}-{$dateTime}-" . str_pad((int)$random + $index, 6, '0', STR_PAD_LEFT) . '.' . $file->getClientOriginalExtension();
                return $file->storeAs('photos', $filename, 'public');
            }, $request->file('photo'), array_keys($request->file('photo')));
            $profileData['photo'] = json_encode($photoFilePaths);
        }
    
        if ($request->filled('password')) {
            $profileData['password'] = Hash::make($request->input('password'));
        }
    
        $profileData['created_at'] = now('Asia/Kolkata');
        $profileData['updated_at'] = now('Asia/Kolkata');
        $profileData['date'] = now('Asia/Kolkata')->toDateString(); // proper date format
        $profileData['profile_id'] = $this->generateProfileId($profileData['name'], $profileData['phone_number']);
    
        /** -----------------------------------
         * 7. Save profile & partner preferences
         * ----------------------------------- */
        $profile = Profile::create($profileData);
    
        // Save partner preferences
        $partner['profile_id'] = $profile->id;
        $profile->partnerPreference()->create($partner);
    
        return response()->json([
            'success' => 'Profile created successfully.',
            'tableReload' => true,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        /** -----------------------------------
         * 1. Normalize phone numbers
         * ----------------------------------- */
        $request->merge([
            'phone_number' => $request->phone_code . preg_replace('/\s+/', '', $request->phone_number),
            'alternative_phone_number' => $request->filled('alternative_phone_number')
                ? $request->alternative_phone_code . preg_replace('/\s+/', '', $request->alternative_phone_number)
                : null,
        ]);
    
        /** -----------------------------------
         * 2. Handle partner preferences (array fields)
         * ----------------------------------- */
        $partner = $request->input('partner', []);
        $partnerArrayFields = [
            'manglik_status', 'highest_qualification', 'citizenship', 'education_field', 'employer_name',
            'profession', 'diet', 'drinking_status', 'smoking_status', 'marital_status',
            'mother_tongue', 'religion', 'caste', 'annual_income', 'grow_up_in',
            'country', 'state', 'city',
        ];
    
        foreach ($partnerArrayFields as $field) {
            $value = $partner[$field] ?? null;
    
            if (blank($value)) {
                unset($partner[$field]);
                continue;
            }
    
            $partner[$field] = json_encode(
                is_array($value)
                    ? array_values(array_filter($value, fn($v) => filled($v)))
                    : [$value]
            );
        }
        $request->merge(['partner' => $partner]);
    
        /** -----------------------------------
         * 3. Handle top-level array fields (other arrays)
         * ----------------------------------- */
        $topArrayFields = ['grow_up_in', 'highest_qualification', 'education_field', 'profession'];
        foreach ($topArrayFields as $field) {
            $value = $request->input($field);
            if (blank($value)) {
                $request->request->remove($field);
                continue;
            }
            $cleaned = is_array($value)
                ? array_values(array_filter($value, fn($v) => filled($v)))
                : [$value];
            $request->merge([$field => $cleaned]);
        }
    
        /** -----------------------------------
         * 4. Validation
         * ----------------------------------- */
        $validator = Validator::make($request->all(), [
            'profile_source_id' => 'exists:profile_sources,id',
            'profile_source_comment' => 'nullable|string',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'email' => ['nullable', 'email'],
            'alternative_email' => ['nullable', 'email'],
            'phone_number' => ['required', 'string', 'regex:/^\+\d{10,15}$/'],
            'alternative_phone_number' => ['nullable', 'string', 'regex:/^\+\d{10,15}$/'],
            // 'govt_id_status' => 'nullable|string|in:verified,non_verified',
            'govt_id_status' => 'nullable|in:1,0',
            'government_id' => 'nullable|array|max:5',
            'government_id.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'nullable|array|max:5',
            'photo.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'contact_person_name' => 'nullable|string|max:255',
            'profile_for' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string',
            'height' => 'nullable|string',
            'mother_tongue' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'body_type' => 'nullable|string',
            'complexion' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'health_status' => 'nullable|string',
            'native_place' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'bio' => 'nullable|string|min:200',
            'religion' => 'nullable|string',
            'caste' => 'nullable|string',
            'sub_caste' => 'nullable|string',
            'gotra' => 'nullable|string',
            'birth_time' => 'nullable|date_format:H:i',
            'birth_place' => 'nullable|string',
            'manglik_status' => 'nullable|string',
            'institute_name' => 'nullable|string',
            'work_location' => 'nullable|string',
            'employer_name' => 'nullable|string',
            'business_name' => 'nullable|string',
            'designation' => 'nullable|string',
            'annual_income' => 'nullable|string',
            'diet' => 'nullable|string',
            'drinking_status' => 'nullable|string',
            'smoking_status' => 'nullable|string',
            'father_occupation' => 'nullable|string',
            'mother_occupation' => 'nullable|string',
            'brother_count' => 'nullable|integer|min:0|max:5',
            'married_brother_count' => 'nullable|integer|min:0|max:5',
            'sister_count' => 'nullable|integer|min:0|max:5',
            'married_sister_count' => 'nullable|integer|min:0|max:5',
            'family_type' => 'nullable|string',
            'family_affluence' => 'nullable|string',
            'family_values' => 'nullable|string',
            'family_bio' => 'nullable|string|min:200',
            'password' => 'nullable|string|min:8|confirmed',
    
            // Partner validations
            'partner.min_age' => 'nullable|integer|min:18|max:100',
            'partner.max_age' => 'nullable|integer|min:18|max:100',
            'partner.min_height' => 'nullable|string',
            'partner.max_height' => 'nullable|string',
            'partner.country' => 'nullable|string',
            'partner.state' => 'nullable|string',
            'partner.city' => 'nullable|string',
            'partner.citizenship' => 'nullable|string',
            'partner.designation' => 'nullable|string',
            'partner.annual_income' => 'nullable|string',
            'partner.annual_income.*' => 'nullable|string',
            'partner.about' => 'nullable|string',
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->filled('married_brother_count') && $request->filled('brother_count') && $request->married_brother_count > $request->brother_count) {
                $validator->errors()->add('married_brother_count', 'Married brothers cannot exceed total brothers.');
            }
            if ($request->filled('married_sister_count') && $request->filled('sister_count') && $request->married_sister_count > $request->sister_count) {
                $validator->errors()->add('married_sister_count', 'Married sisters cannot exceed total sisters.');
            }
        });

        if ($validator->fails()) {
            return response()->json(['validationError' => $validator->errors()], 200);
        }
        
        /** -----------------------------------
         * 4.5 Replace "Other" fields with custom input
         * ----------------------------------- */
        $otherFields = [
            'mother_tongue',
            'health_status',
            'religion',
            'diet',
            'body_type',
            'profile_for',
            'caste',
            'highest_qualification',
            'education_field',
            'employer_name',
            'profession',
            'father_occupation',
            'mother_occupation',
        ];
        
        foreach ($otherFields as $field) {
            $selected = $request->input($field);
            $custom = $request->input("{$field}_other");
        
            if ($selected === 'Other' && filled($custom)) {
                $request->merge([$field => $custom]);
            }
        }
        
        // Same for partner fields
        $partnerOtherFields = [
            'religion',
            'cast',
            'diet',
            'highest_qualification',
            'education_field',
            'working_with',
            'profession',
        ];
        
        foreach ($partnerOtherFields as $field) {
            $selected = $request->input("partner.{$field}");
            $custom = $request->input("partner_{$field}_other");
        
            if ($selected === 'Other' && filled($custom)) {
                $request->merge(["partner.{$field}" => $custom]);
            }
        }

        // Build profile data
        $profileData = $request->only([
            'profile_source_id', 'profile_source_comment', 'email', 'alternative_email',
            'phone_number', 'alternative_phone_number', 'contact_person_name', 'profile_for',
            'name', 'gender', 'date_of_birth', 'marital_status', 'height', 'mother_tongue',
            'weight', 'body_type', 'complexion', 'blood_group', 'health_status', 'native_place',
            'country', 'state', 'city', 'citizenship', 'bio', 'religion', 'caste', 'sub_caste',
            'gotra', 'birth_time', 'birth_place', 'manglik_status', 'institute_name',
            'work_location', 'employer_name', 'business_name', 'designation', 'annual_income',
            'diet', 'drinking_status', 'smoking_status', 'father_occupation', 'mother_occupation',
            'brother_count', 'married_brother_count', 'sister_count', 'married_sister_count',
            'family_type', 'family_affluence', 'family_values', 'family_bio',
        ]);

        // Encode array fields
        $topArrayFields = ['grow_up_in', 'highest_qualification', 'education_field', 'profession'];
        foreach ($topArrayFields as $field) {
            if ($request->has($field)) {
                $profileData[$field] = json_encode($request->input($field));
            } else {
                $profileData[$field] = $profile->$field; // Preserve existing value
            }
        }

        // Generate custom filename prefix
        $namePrefix = Str::slug($request->input('name'), '-') ?: 'profile';
        $dateTime = now('Asia/Kolkata')->format('Ymd-His');
        $random = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Handle file uploads
        if ($request->hasFile('government_id')) {
            // Delete existing files
            $existingGovtFiles = json_decode($profile->government_id, true) ?? [];
            // Store new files
            $govtFiles = $request->file('government_id');
            if (count($govtFiles) > 5) {
                return response()->json(['validationError' => ['government_id' => 'Maximum 5 government ID files allowed.']], 200);
            }
            $govtFilePaths = array_map(function ($file, $index) use ($namePrefix, $dateTime, $random) {
                $extension = $file->getClientOriginalExtension();
                $filename = "{$namePrefix}-{$dateTime}-" . str_pad((int)$random + $index, 6, '0', STR_PAD_LEFT) . ".{$extension}";
                return $file->storeAs('government_ids', $filename, 'public');
            }, $govtFiles, array_keys($govtFiles));
            // Delete when new inserted
            foreach ($existingGovtFiles as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                    Log::info('Deleted Government ID File:', [$filePath]);
                }
            }
            $profileData['government_id'] = json_encode($govtFilePaths);
        }

        if ($request->hasFile('photo')) {
            // Delete existing files
            $existingPhotoFiles = json_decode($profile->photo, true) ?? [];
            // Store new files
            $photoFiles = $request->file('photo');
            if (count($photoFiles) > 5) {
                return response()->json(['validationError' => ['photo' => 'Maximum 5 photo files allowed.']], 200);
            }
            $photoFilePaths = array_map(function ($file, $index) use ($namePrefix, $dateTime, $random) {
                $extension = $file->getClientOriginalExtension();
                $filename = "{$namePrefix}-{$dateTime}-" . str_pad((int)$random + $index, 6, '0', STR_PAD_LEFT) . ".{$extension}";
                return $file->storeAs('photos', $filename, 'public');
            }, $photoFiles, array_keys($photoFiles));
            // Delete when new inserted
            foreach ($existingPhotoFiles as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                    Log::info('Deleted Photo File:', [$filePath]);
                }
            }
            $profileData['photo'] = json_encode($photoFilePaths);
        }

        // Handle password
        if ($request->filled('password')) {
            $profileData['password'] = Hash::make($request->input('password'));
        }

        $profileData['updated_at'] = now('Asia/Kolkata');
        $profile->update($profileData);

        // Save or update partner preferences
        $partnerData = $request->input('partner', []);
        
        foreach ($partnerArrayFields as $field) {
            if (isset($partnerData[$field])) {
                if (is_array($partnerData[$field])) {
                    $partnerData[$field] = json_encode($partnerData[$field]); 
                }
            }
        }

        $partnerData = array_merge($partnerData, [
            'profile_id' => $profile->id,
            'min_age' => $partnerData['min_age'] ?? null,
            'max_age' => $partnerData['max_age'] ?? null,
            'min_height' => $partnerData['min_height'] ?? null,
            'max_height' => $partnerData['max_height'] ?? null,
            'citizenship' => $partnerData['citizenship'] ?? null,
            'designation' => $partnerData['designation'] ?? null,
            'about' => $partnerData['about'] ?? null,
        ]);

        $profile->partnerPreference()->updateOrCreate(['profile_id' => $profile->id], $partnerData);

        // Log for debugging
        Log::info('Updated Profile Data:', $profileData);
        Log::info('Government ID Files:', [$request->file('government_id')]);
        Log::info('Photo Files:', [$request->file('photo')]);

        return response()->json([
            'success' => 'Profile updated successfully.',
            'tableReload' => true,
        ], 200);
    }

    public function deleteFile(Request $request, Profile $profile)
    {
        $request->validate([
            'type' => 'required|in:government_id,photo',
            'path' => 'required|string',
            'index' => 'required|integer',
        ]);

        $type = $request->type;
        $index = $request->index;
        $path = $request->path;

        // Decode current files
        $files = json_decode($profile->$type, true) ?? [];

        if (isset($files[$index]) && $files[$index] === $path) {
            unset($files[$index]);
            $files = array_values($files); // Reindex array
            $profile->$type = $files ? json_encode($files) : null;
            $profile->save();

            // Delete physical file
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                Log::info('Deleted File via Endpoint:', [$path]);
            }

            return response()->json(['success' => 'File deleted successfully']);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
    
     

    /**
     * Remove the specified profile from storage.
     */
    // public function destroy(Profile $profile)
    // {
    //     // $this->authorize('delete', $profile);

    //     // Delete associated photos
    //     // if ($profile->photos) {
    //     //     foreach ($profile->photos as $photo) {
    //     //         Storage::disk('public')->delete($photo);
    //     //     }
    //     // }

    //     $profile->delete();
        
        

    //     return Redirect::route('admin.profiles.index')->with('status', 'Profile deleted successfully!');
    // }
    
    public function destroy(Profile $profile)
    {
        $profile->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Profile deleted successfully.'
        ]);
    }

}
