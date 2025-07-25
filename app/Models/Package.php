<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'duration_days',
        'type',
    ];

    public $timestamps = false; // If you don’t have created_at/updated_at columns

    public function paymentLinks()
    {
        return $this->hasMany(PaymentLink::class);
    }
}
