<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

     public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function education(): HasOne
    {
        return $this->hasOne(Education::class);
    }

    public function pastEmployment(): HasOne
    {
        return $this->hasOne(PastEmployment::class);
    }

    public function bank(): HasOne
    {
        return $this->hasOne(Bank::class);
    }

    public function payroll(): HasOne
    {
        return $this->hasOne(Payroll::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function assignedProfiles()
    {
        return $this->hasMany(ProfileEmployeeAssignment::class, 'employee_id');
    }
    public function profileAssignmentsMade()
    {
        return $this->hasMany(ProfileEmployeeAssignment::class, 'assigned_by');
    }

    public function scopeOnlyNameEmail($query)
    {
        return $query->select('id', 'name', 'email');
    }


}
