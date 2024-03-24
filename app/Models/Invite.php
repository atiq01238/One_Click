<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email', 'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Implementing getEmailForVerification method required by MustVerifyEmail interface
    public function getEmailForVerification()
    {
        return $this->email;
    }

    // Implementing the rest of the methods from the MustVerifyEmail interface
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendEmailVerificationNotification()
    {
        // You can implement the logic for sending email verification notification here if needed
    }
}
