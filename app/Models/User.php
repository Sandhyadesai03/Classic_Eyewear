<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Enquiry;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
'two_factor_enabled',
'google2fa_secret',
        // Admin / User
        'is_admin',

        // Admin Role
        'role',

        // Page Permissions
        'permissions',

        // Two Factor Authentication
        'google2fa_secret',
    ];

    protected $hidden = [
        'password',
        'remember_token',

        // Never expose 2FA secret
        'google2fa_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',

            'password' => 'hashed',

            'is_admin' => 'boolean',

            'permissions' => 'array',
        ];
    }
protected $casts = [
    'two_factor_enabled' => 'boolean',
];
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }
}