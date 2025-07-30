<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait GeneratesProfileId
{
    public function generateProfileId(string $fullName, string $mobile): string
    {
        $prefix = 'EB';
        $initials = strtoupper(substr(preg_replace('/\s+/', '', $fullName), 0, 2));
        $last4 = substr(preg_replace('/\D/', '', $mobile), -4);
        return "{$prefix}{$initials}{$last4}";
    }
}