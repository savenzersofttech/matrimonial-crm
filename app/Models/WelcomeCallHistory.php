<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class WelcomeCallHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'welcome_call_id',
        'profile_id',
        'user_id',
        'call_time',
        'status',
        'outcome',
        'notes',
    ];
}
