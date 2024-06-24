<?php

namespace Domain\AdminUsers\Models;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Support\Traits\HasModelUtilities;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasModelUtilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    public function usesTimestamps()
    {
        return true;
    }

    public function sendPasswordResetNotification($token)
    {
        ResetPasswordNotification::createUrlUsing(
            fn () => (config('app.frontend.admin.reset_password_url')
                    ?? route('admin.reset-password')).'?token='.$token
        );

        app(Dispatcher::class)->send($this, new ResetPasswordNotification($token));
    }
}
