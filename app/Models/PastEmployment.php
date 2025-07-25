<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PastEmployment extends Model
{
    protected $fillable = [
        'user_id', 'organization_name', 'employment_functional_unit',
        'employment_designation', 'joining_salary', 'last_salary',
        'joining_date', 'relieving_date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
