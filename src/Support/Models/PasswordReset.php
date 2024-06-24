<?php

namespace Support\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 *
 * @property string $email
 * @property string $token
 * @property Carbon|null $created_at
 *
 * @package Domain\Accounts\Models
 */
class PasswordReset extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'password_resets';

    protected $hidden = [
        'token',
    ];

    protected $fillable = [
        'email',
        'token',
    ];
}
