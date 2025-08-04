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
    return $this->hasMany(PaymentLink::class, 'plan_id');
}

public function users()
{
    return $this->hasManyThrough(
        User::class,
        PaymentLink::class,
        'plan_id', // Foreign key on payment_links
        'id',      // Foreign key on users table
        'id',      // Local key on packages table
        'user_id'  // Local key on payment_links table
    );
}

}
