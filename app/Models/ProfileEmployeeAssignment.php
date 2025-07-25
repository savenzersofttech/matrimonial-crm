<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileEmployeeAssignment extends Model
{
    protected $fillable = [
        'profile_id',
        'employee_id',
        'assigned_by',
        'assigned_at',
        'note',
    ];

    /**
     * Get the profile that was assigned.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }




    

    /**
     * Get the staff member the profile was assigned to.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the admin who assigned the profile.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
