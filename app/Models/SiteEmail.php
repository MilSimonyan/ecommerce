<?php

namespace App\Models;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class SiteEmail extends User implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'user_id',
        'email',
        'email_verified_at'
    ];

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return $this->email_verified_at != null;
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        $this->update([
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }
}
