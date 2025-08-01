<?php

// app/Models/WelcomeCall.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WelcomeCall extends Model
{
    use HasFactory;

     protected $fillable = [
        'profile_id',
        'user_id',
        'call_time',
        'status',
        'outcome',
        'notes',
    ];

    protected $casts = [
        'call_time' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function profileAssignment()
    {
        return $this->hasOne(ProfileEmployeeAssignment::class, 'profile_id', 'profile_id');
    }

    public function followUpHistories()
    {
        return $this->hasMany(FollowUpHistory::class, 'welcome_call_id');
    }

}
