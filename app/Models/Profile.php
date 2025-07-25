<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_source_id',
        'profile_source_comment',
        'profile_id',
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
        'grow_up_in',
        'government_id',
        'photo',
        'password',
        'bio',
        'religion',
        'caste',
        'sub_caste',
        'gotra',
        'birth_time',
        'birth_place',
        'manglik_status',
        'highest_qualification',
        'education_field',
        'institute_name',
        'work_location',
        'employer_name',
        'profession',
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
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'birth_time' => 'datetime',
        'grow_up_in' => 'array',
        'government_id' => 'array',
        'photo' => 'array',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the services associated with the profile.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the staff assignment for the profile.
     */
    public function staffAssignment()
    {
        return $this->hasOne(ProfileEmployeeAssignment::class, 'profile_id');
    }

    /**
     * Get the package associated with the profile.
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the user who created the profile.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the profile.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to select basic profile information.
     */
    public function scopeBasicInfo($query)
    {
        return $query->select('id', 'full_name', 'email', 'phone_number');
    }

    /**
     * Get the religion associated with the profile.
     */
    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    /**
     * Get the community associated with the profile.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * Get the profile source that owns the profile.
     */
    public function profileSource()
    {
        return $this->belongsTo(ProfileSource::class, 'profile_source_id');
    }

    /**
     * Get the partner preferences for the profile.
     */
    public function partnerPreference()
    {
        return $this->hasOne(PartnerPreference::class, 'profile_id');
    }
    
}