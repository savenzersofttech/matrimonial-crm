<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'user_id',
        'plan_id',
        'currency',
        'price',
        'discount',
        'final_amount',
        'payment_link',
        'token',
        'gateway',
        'transaction_id',
        'gateway_response',
        'sent_at',
        'status',
        'start_date',
        'end_date',
    ];

    // Relationship to profile (prospect)
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

public function package()
{
    return $this->belongsTo(Package::class, 'plan_id');
}


}
