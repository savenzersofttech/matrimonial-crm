<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bank extends Model
{
    protected $fillable = [
        'user_id', 'bank_name', 'account_type', 'account_name',
        'account_number', 'ifsc', 'branch_name', 'bank_file'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
