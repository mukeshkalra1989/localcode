<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasVerifiedEmail()
    {
        // Check if the user is a normal user (not admin or super admin)
        if ($this->isNormalUser()) {
            //return $this->attributes['email_verified_at'] !== null;
            return isset($this->attributes['email_verified_at']) && $this->attributes['email_verified_at'] !== null;
        }

        return true; // Always consider admin and super admin as verified
    }

    public function markEmailAsVerified()
    {
        // Check if the user is a normal user (not admin or super admin)
        if ($this->isNormalUser()) {
            $this->forceFill([
                'email_verified_at' => $this->freshTimestamp(),
            ])->save();
        }
    }

    protected function isNormalUser()
    {
        // Adjust the condition based on your role setup
        return !$this->hasRole('Admin') && !$this->hasRole('Super Admin');
    }
}
