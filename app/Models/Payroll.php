<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = [
        'user_id', 'supervisor_id', 'payroll_designation', 'payroll_functional_unit',
        'band', 'payroll_joining_date', 'offered_salary', 'last_salary_revision',
        'latest_salary', 'salary_revision_count', 'level_increase_count',
        'resign_date', 'last_working_date', 'payroll_relieving_date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
