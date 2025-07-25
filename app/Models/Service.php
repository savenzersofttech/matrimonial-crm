<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'plan',
        'start_date',
        'end_date',
        'status',
        'price',
        'remarks',
        'added_by',
        'updated_by',
    ];

    /**
     * The client profile associated with the service.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * The staff user who added this service.
     */
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * The staff user who last updated this service.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeStatus($query, $status)
    {
        if ($status) {
            $query->where('status', $status);
        }
    }

    /**
     * Scope for filtering by plan type.
     */
    public function scopePlan($query, $plan)
    {
        if ($plan) {
            $query->where('plan', $plan);
        }
    }

    /**
     * Scope for filtering by expiration date.
     */
    public function scopeExpiringBefore($query, $date)
    {
        if ($date) {
            $query->where('end_date', '<=', $date);
        }
    }

    
}
