<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    protected $fillable = [
        'user_id', 'period', 'start_date', 'end_date','contacted_lead','converted_lead', 'achieved', 'start_date', 'end_date','revenue'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
