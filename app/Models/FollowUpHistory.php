<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUpHistory extends Model
{
    protected $table = 'welcome_call_follow_up_histories'; 
    protected $fillable = [
        'welcome_call_id',
        'employee_id',
        'follow_up_date',
        'status',
        'comment',
    ];

    public function welcomeCall(): BelongsTo
    {
        return $this->belongsTo(WelcomeCall::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}