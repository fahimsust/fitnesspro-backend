<?php

namespace Support\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonalAccessToken
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property string|null $abilities
 * @property Carbon|null $last_used_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package Domain\Others\Models
 */
class PersonalAccessToken extends Model
{
    protected $table = 'personal_access_tokens';

    protected $casts = [
        'tokenable_id' => 'int',
        'last_used_at' => 'datetime',
    ];

    protected $hidden = [
        'token',
    ];

    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
    ];
}