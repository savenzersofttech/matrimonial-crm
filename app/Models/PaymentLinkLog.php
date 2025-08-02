<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLinkLog extends Model
{
    protected $fillable = [
        'payment_link_id',
        'action',
        'changes',
        'user_id',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function paymentLink()
    {
        return $this->belongsTo(PaymentLink::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
