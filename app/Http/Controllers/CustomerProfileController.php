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
        $profile       = Profile::with(['partnerPreference'])->findOrFail($profileId);
        $tounges       = MotherTongue::all();
        $ProfileSource = ProfileSource::all();
        $religion      = Religion::all();
        $gotras        = Gothra::all();

        return view('profiles.view', compact('profile', 'ProfileSource', 'tounges', 'religion', 'gotras'));
    }

    public function showAll(Request $request)
    {
        
       
    

        $dbColumns = (new Profile)->getFillable();
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
            $query->orderBy('profiles.id', 'desc');
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
        // Normalize phone numbers
        $request->merge([
            'phone_number'             => $request->phone_code . preg_replace('/\s+/', '', $request->phone_number),
            'alternative_phone_number' => $request->filled('alternative_phone_number')
            ? $request->alternative_phone_code . preg_replace('/\s+/', '', $request->alternative_phone_number)
            : null,
        ]);

        $partner = $request->input('partner', []);

        $partnerArrayFields = [
            'manglik_status',
            'highest_qualification',
            'education_field',
            'employer_name',
            'profession',
            'diet',
            'drinking_status',
            'smoking_status',
            'marital_status',
            'mother_tongue',
            'religion',
            'caste',
            'grow_up_in',
        ];

        foreach ($partnerArrayFields as $field) {
            $value = $partner[$field] ?? null;

            // nothing selected → drop the key entirely
            if (blank($value)) {
                unset($partner[$field]);
                continue;
            }

            // if it’s already an array, clean it; otherwise wrap it
            $partner[$field] = is_array($value)
            ? array_values(array_filter($value, fn($v) => filled($v)))
            : [$value];
        }

        $request->merge(['partner' => $partner]);

        /* -----------------------------------------------------------------
        | 2. Top‑level array‑capable fields  (grow_up_in, …)
        * ----------------------------------------------------------------*/

        $topArrayFields = ['grow_up_in', 'highest_qualification', 'education_field', 'profession'];

        foreach ($topArrayFields as $field) {
            $value = $request->input($field);

            if (blank($value)) {
                // remove completely so nothing is stored
                $request->request->remove($field);
                continue;
            }

            $cleaned = is_array($value)
            ? array_values(array_filter($value, fn($v) => filled($v)))
            : [$value];

            $request->merge([$field => $cleaned]);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'profile_source_id'               => 'required|exists:profile_sources,id',
            'profile_source_comment'          => 'nullable|string',
            'name'                            => 'required|string|max:255',
            'gender'                          => 'required|in:Male,Female',
            'email'                           => 'nullable|email|unique:profiles,email',
            'alternative_email'               => 'nullable|email|unique:profiles,alternative_email',
            'phone_number'                    => 'required|string|regex:/^\+\d{10,15}$/|unique:profiles,phone_number',
            'alternative_phone_number'        => 'nullable|string|regex:/^\+\d{10,15}$/|unique:profiles,alternative_phone_number',
            'contact_person_name'             => 'nullable|string|max:255',
            'profile_for'                     => 'nullable|string|max:255',
            'date_of_birth'                   => 'nullable|date',
            'marital_status'                  => 'nullable|string|max:255',
            'height'                          => 'nullable|string|max:255',
            'mother_tongue'                   => 'nullable|string|max:255',
            'weight'                          => 'nullable|integer|min:0|max:500',
            'body_type'                       => 'nullable|string|max:255',
            'complexion'                      => 'nullable|string|max:255',
            'blood_group'                     => 'nullable|string|max:255',
            'health_status'                   => 'nullable|string|max:255',
            'native_place'                    => 'nullable|string|max:255',
            'country'                         => 'nullable|string|max:255',
            'state'                           => 'nullable|string|max:255',
            'city'                            => 'nullable|string|max:255',
            'citizenship'                     => 'nullable|string|max:255',
            'grow_up_in'                      => 'nullable|array',
            'grow_up_in.*'                    => 'nullable|string|max:255',
            'government_id.*'                 => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo.*'                         => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'password'                        => 'nullable|string|min:8|confirmed',
            'bio'                             => 'nullable|string',
            'religion'                        => 'nullable|string|max:255',
            'caste'                           => 'nullable|string|max:255',
            'sub_caste'                       => 'nullable|string|max:255',
            'gotra'                           => 'nullable|string|max:255',
            'birth_time'                      => 'nullable|date_format:H:i',
            'birth_place'                     => 'nullable|string|max:255',
            'manglik_status'                  => 'nullable|string|max:255',
            'highest_qualification'           => 'nullable|array',
            'highest_qualification.*'         => 'nullable|string|max:255',
            'education_field'                 => 'nullable|array',
            'education_field.*'               => 'nullable|string|max:255',
            'institute_name'                  => 'nullable|string|max:255',
            'work_location'                   => 'nullable|string|max:255',
            'employer_name'                   => 'nullable|string|max:255',
            'profession'                      => 'nullable|array',
            'profession.*'                    => 'nullable|string|max:255',
            'business_name'                   => 'nullable|string|max:255',
            'designation'                     => 'nullable|string|max:255',
            'annual_income'                   => 'nullable|string|max:255',
            'diet'                            => 'nullable|string|max:255',
            'drinking_status'                 => 'nullable|string|max:255',
            'smoking_status'                  => 'nullable|string|max:255',
            'father_occupation'               => 'nullable|string|max:255',
            'mother_occupation'               => 'nullable|string|max:255',
            'brother_count'                   => 'nullable|integer|min:0|max:5',
            'married_brother_count'           => 'nullable|integer|min:0|max:5',
            'sister_count'                    => 'nullable|integer|min:0|max:5',
            'married_sister_count'            => 'nullable|integer|min:0|max:5',
            'family_type'                     => 'nullable|string|max:255',
            'family_affluence'                => 'nullable|string|max:255',
            'family_values'                   => 'nullable|string|max:255',
            'family_bio'                      => 'nullable|string',

            // Partner preference
            'partner.min_age'                 => 'nullable|integer|min:18|max:100',
            'partner.max_age'                 => 'nullable|integer|min:18|max:100',
            'partner.min_height'              => 'nullable|string|max:255',
            'partner.max_height'              => 'nullable|string|max:255',
            'partner.marital_status'          => 'nullable|array',
            'partner.marital_status.*'        => 'nullable|string|max:255',
            'partner.mother_tongue'           => 'nullable|array',
            'partner.mother_tongue.*'         => 'nullable|string|max:255',
            'partner.religion'                => 'nullable|array',
            'partner.religion.*'              => 'nullable|string|max:255',
            'partner.caste'                   => 'nullable|array',
            'partner.caste.*'                 => 'nullable|string|max:255',
            'partner.manglik_status'          => 'nullable|array',
            'partner.manglik_status.*'        => 'nullable|string|max:255',
            'partner.country'                 => 'nullable|string|max:255',
            'partner.state'                   => 'nullable|string|max:255',
            'partner.city'                    => 'nullable|string|max:255',
            'partner.citizenship'             => 'nullable|string|max:255',
            'partner.grow_up_in'              => 'nullable|array',
            'partner.grow_up_in.*'            => 'nullable|string|max:255',
            'partner.highest_qualification'   => 'nullable|array',
            'partner.highest_qualification.*' => 'nullable|string|max:255',
            'partner.education_field'         => 'nullable|array',
            'partner.education_field.*'       => 'nullable|string|max:255',
            'partner.employer_name'           => 'nullable|array',
            'partner.employer_name.*'         => 'nullable|string|max:255',
            'partner.profession'              => 'nullable|array',
            'partner.profession.*'            => 'nullable|string|max:255',
            'partner.designation'             => 'nullable|string|max:255',
            'partner.annual_income'           => 'nullable|string|max:255',
            'partner.diet'                    => 'nullable|array',
            'partner.diet.*'                  => 'nullable|string|max:255',
            'partner.drinking_status'         => 'nullable|array',
            'partner.drinking_status.*'       => 'nullable|string|max:255',
            'partner.smoking_status'          => 'nullable|array',
            'partner.smoking_status.*'        => 'nullable|string|max:255',
            'partner.about'                   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationError' => $validator->errors()], 200);
        }

        // Build profile data
        $profileData = $request->only([
            'profile_source_id',
            'profile_source_comment',
            'email',
            'alternative_email',
            'phone_number',
            'alternative_phone_number',
            'contact_person_name',
            'profile_for',
            'name',
            'gender',
            'date_of_birth',
            'marital_status',
            'height',
            'mother_tongue',
            'weight',
            'body_type',
            'complexion',
            'blood_group',
            'health_status',
            'native_place',
            'country',
            'state',
            'city',
            'citizenship',
            'bio',
            'religion',
            'caste',
            'sub_caste',
            'gotra',
            'birth_time',
            'birth_place',
            'manglik_status',
            'institute_name',
            'work_location',
            'employer_name',
            'business_name',
            'designation',
            'annual_income',
            'diet',
            'drinking_status',
            'smoking_status',
            'father_occupation',
            'mother_occupation',
            'brother_count',
            'married_brother_count',
            'sister_count',
            'married_sister_count',
            'family_type',
            'family_affluence',
            'family_values',
            'family_bio',
        ]);

        // Encode arrays
        foreach ($topArrayFields as $field) {
            if ($request->has($field)) {
                $profileData[$field] = json_encode($request->input($field));
            }
        }

        // File uploads
        $profileData['government_id'] = json_encode(array_map(function ($file) {
            return $file->store('government_ids', 'public');
        }, $request->file('government_id', [])));

        $profileData['photo'] = json_encode(array_map(function ($file) {
            return $file->store('photos', 'public');
        }, $request->file('photo', [])));

        // Password
        if ($request->filled('password')) {
            $profileData['password'] = Hash::make($request->input('password'));
        }

        $profileData['created_at'] = now('Asia/Kolkata');
        $profileData['updated_at'] = now('Asia/Kolkata');
        $profileData['profile_id'] = $this->generateProfileId($profileData['name'], $profileData['phone_number']);

        $profile = Profile::create($profileData);

        // Save partner preferences
        $partnerData = $request->input('partner', []);
        foreach ($partnerArrayFields as $field) {
            if (isset($partnerData[$field])) {
                $partnerData[$field] = json_encode($partnerData[$field]);
            }
        }

        $partnerData = array_merge($partnerData, [
            'profile_id'    => $profile->id,
            'min_age'       => $partnerData['min_age'] ?? null,
            'max_age'       => $partnerData['max_age'] ?? null,
            'min_height'    => $partnerData['min_height'] ?? null,
            'max_height'    => $partnerData['max_height'] ?? null,
            'country'       => $partnerData['country'] ?? null,
            'state'         => $partnerData['state'] ?? null,
            'city'          => $partnerData['city'] ?? null,
            'citizenship'   => $partnerData['citizenship'] ?? null,
            'designation'   => $partnerData['designation'] ?? null,
            'annual_income' => $partnerData['annual_income'] ?? null,
            'about'         => $partnerData['about'] ?? null,
        ]);

        PartnerPreference::create($partnerData);

        return response()->json([
            'success'     => 'Profile created successfully.',
            'tableReload' => true,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        // Normalize phone numbers
        $request->merge([
            'phone_number'             => $request->phone_code . preg_replace('/\s+/', '', $request->phone_number),
            'alternative_phone_number' => $request->filled('alternative_phone_number')
            ? $request->alternative_phone_code . preg_replace('/\s+/', '', $request->alternative_phone_number)
            : null,
        ]);

        $partner            = $request->input('partner', []);
        $partnerArrayFields = [
            'manglik_status',
            'highest_qualification',
            'education_field',
            'employer_name',
            'profession',
            'diet',
            'drinking_status',
            'smoking_status',
            'marital_status',
            'mother_tongue',
            'religion',
            'caste',
            'grow_up_in',
        ];

        foreach ($partnerArrayFields as $field) {
            $value = $partner[$field] ?? null;
            if (blank($value)) {
                unset($partner[$field]);
                continue;
            }
            $partner[$field] = is_array($value) ? array_values(array_filter($value)) : [$value];
        }

        $request->merge(['partner' => $partner]);

        $topArrayFields = ['grow_up_in', 'highest_qualification', 'education_field', 'profession'];
        foreach ($topArrayFields as $field) {
            $value = $request->input($field);
            if (blank($value)) {
                $request->request->remove($field);
                continue;
            }
            $request->merge([$field => is_array($value) ? array_values(array_filter($value)) : [$value]]);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'profile_source_id'        => 'required|exists:profile_sources,id',
            'name'                     => 'required|string|max:255',
            'gender'                   => 'required|in:Male,Female',
            'email'                    => 'nullable|email|unique:profiles,email,' . $id,
            'alternative_email'        => 'nullable|email|unique:profiles,alternative_email,' . $id,
            'phone_number'             => 'required|string|regex:/^\+\d{10,15}$/|unique:profiles,phone_number,' . $id,
            'alternative_phone_number' => 'nullable|string|regex:/^\+\d{10,15}$/|unique:profiles,alternative_phone_number,' . $id,
            // ... keep all other validation rules the same as in store()
        ]);

        if ($validator->fails()) {
            return response()->json(['validationError' => $validator->errors()], 200);
        }

        // Build profile update data
        $profileData = $request->only([
            'profile_source_id',
            'profile_source_comment',
            'email',
            'alternative_email',
            'phone_number',
            'alternative_phone_number',
            'contact_person_name',
            'profile_for',
            'name',
            'gender',
            'date_of_birth',
            'marital_status',
            'height',
            'mother_tongue',
            'weight',
            'body_type',
            'complexion',
            'blood_group',
            'health_status',
            'native_place',
            'country',
            'state',
            'city',
            'citizenship',
            'bio',
            'religion',
            'caste',
            'sub_caste',
            'gotra',
            'birth_time',
            'birth_place',
            'manglik_status',
            'institute_name',
            'work_location',
            'employer_name',
            'business_name',
            'designation',
            'annual_income',
            'diet',
            'drinking_status',
            'smoking_status',
            'father_occupation',
            'mother_occupation',
            'brother_count',
            'married_brother_count',
            'sister_count',
            'married_sister_count',
            'family_type',
            'family_affluence',
            'family_values',
            'family_bio',
        ]);

        foreach ($topArrayFields as $field) {
            if ($request->has($field)) {
                $profileData[$field] = json_encode($request->input($field));
            }
        }

        // File uploads
        if ($request->hasFile('government_id')) {
            $profileData['government_id'] = json_encode(array_map(fn($file) => $file->store('government_ids', 'public'), $request->file('government_id')));
        }

        if ($request->hasFile('photo')) {
            $profileData['photo'] = json_encode(array_map(fn($file) => $file->store('photos', 'public'), $request->file('photo')));
        }

        if ($request->filled('password')) {
            $profileData['password'] = Hash::make($request->input('password'));
        }

        $profileData['updated_at'] = now('Asia/Kolkata');
        $profile->update($profileData);

        // Save or update partner preferences
        $partnerData = $request->input('partner', []);
        foreach ($partnerArrayFields as $field) {
            if (isset($partnerData[$field])) {
                $partnerData[$field] = json_encode($partnerData[$field]);
            }
        }

        $partnerData = array_merge($partnerData, [
            'profile_id'    => $profile->id,
            'min_age'       => $partnerData['min_age'] ?? null,
            'max_age'       => $partnerData['max_age'] ?? null,
            'min_height'    => $partnerData['min_height'] ?? null,
            'max_height'    => $partnerData['max_height'] ?? null,
            'country'       => $partnerData['country'] ?? null,
            'state'         => $partnerData['state'] ?? null,
            'city'          => $partnerData['city'] ?? null,
            'citizenship'   => $partnerData['citizenship'] ?? null,
            'designation'   => $partnerData['designation'] ?? null,
            'annual_income' => $partnerData['annual_income'] ?? null,
            'about'         => $partnerData['about'] ?? null,
        ]);

        PartnerPreference::updateOrCreate(
            ['profile_id' => $profile->id],
            $partnerData
        );

        return response()->json([
            'success'     => 'Profile updated successfully.',
            'tableReload' => true,
        ], 200);
    }

    /**
     * Remove the specified profile from storage.
     */
    public function destroy(Profile $profile)
    {
        // $this->authorize('delete', $profile);

        // Delete associated photos
        // if ($profile->photos) {
        //     foreach ($profile->photos as $photo) {
        //         Storage::disk('public')->delete($photo);
        //     }
        // }

        $profile->delete();

        return Redirect::route('admin.profiles.index')->with('status', 'Profile deleted successfully!');
    }
}
