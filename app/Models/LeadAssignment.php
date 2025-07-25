<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadAssignment extends Model
{
    protected $fillable = [
        'lead_id',
        'assigned_to',
        'assigned_by',
        'note',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'lead_id'); // Assuming 'lead_id' refers to a profile
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
    public function lead()
{
    return $this->belongsTo(Lead::class, 'lead_id');
}
}
