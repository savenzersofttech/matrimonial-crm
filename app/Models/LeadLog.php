<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadLog extends Model
{
    use HasFactory;

    protected $table = 'lead_logs';

    protected $fillable = [
        'lead_id',
        'profile_id',
        'action',
        'user_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array', // automatically casts JSON to array
    ];

    // Relationships
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Unknown User'
        ]);
    }
}
