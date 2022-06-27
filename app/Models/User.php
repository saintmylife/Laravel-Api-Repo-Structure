<?php

namespace App\Models;

use App\Modules\V1\Auth\Domain\Jobs\ResetPasswordNotification;
use App\Modules\V1\Auth\Domain\Jobs\SendOtpNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\{HasRoles, HasPermissions};

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'password_confirmation',
        'verified_at',
        'otp',
        'otp_expired_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verified_at' => 'datetime',
        'otp_expired_at' => 'datetime',
    ];
    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->orWhere('email', $username)->firstOrFail();
    }
    /*
    |--------------------------------------------------------------------------
    | Override MustVerifyEmail Change Column Name To verified_at
    |--------------------------------------------------------------------------
    */
    public function hasVerifiedEmail()
    {
        return !is_null($this->verified_at);
    }
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'verified_at' => $this->freshTimestamp(),
        ])->save();
    }
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify((new SendOtpNotification($this->otp))->onQueue('high'));
    }
    /*
    |--------------------------------------------------------------------------
    | Override CanResetPassword Change Email Notification
    |--------------------------------------------------------------------------
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify((new ResetPasswordNotification($token))->onQueue('high'));
    }
}
