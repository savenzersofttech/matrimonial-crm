<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'dob', 'pan_number', 'aadhar_number',
        'passport', 'phone', 'country', 'state', 'city', 'landmark', 'address_line',
        'pincode', 'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
