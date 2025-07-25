<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerPreference extends Model
{
    protected $table = 'partner_preferences';

    protected $fillable = [
        'profile_id',
        'min_age',
        'max_age',
        'min_height',
        'max_height',
        'marital_status',
        'mother_tongue',
        'religion',
        'caste',
        'manglik_status',
        'country',
        'state',
        'city',
        'citizenship',
        'grow_up_in',
        'highest_qualification',
        'education_field',
        'employer_name',
        'profession',
        'designation',
        'annual_income',
        'diet',
        'drinking_status',
        'smoking_status',
        'about',
    ];

    protected $casts = [
        'marital_status' => 'array',
        'mother_tongue'  => 'array',
        'grow_up_in'     => 'array',
    ];

    /**
     * Get the profile that owns the partner preference.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
