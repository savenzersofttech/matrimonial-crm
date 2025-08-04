<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WelcomeCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'payment_link_id',
        'user_id',
        'call_time',
        'status',
        'outcome',
        'notes',
    ];

    protected static function booted()
    {
        static::created(function ($call) {
            $call->saveHistory();
        });

        static::updated(function ($call) {
            if ($call->isDirty()) {
                $call->saveHistory();
            }
        });
    }

    public function saveHistory()
    {
        \App\Models\WelcomeCallHistory::create([
            'welcome_call_id' => $this->id,
            'profile_id'      => $this->profile_id,
            'user_id'         => $this->user_id,
            'call_time'       => $this->call_time,
            'status'          => $this->status,
            'outcome'         => $this->outcome,
            'notes'           => $this->notes,
        ]);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profileAssignment()
    {
        return $this->hasOne(ProfileEmployeeAssignment::class, 'profile_id', 'profile_id');
    }

    public function history()
    {
        return $this->hasMany(WelcomeCallHistory::class, 'welcome_call_id');
    }
    public function paymentLink()
{
    return $this->belongsTo(PaymentLink::class);
}
}
