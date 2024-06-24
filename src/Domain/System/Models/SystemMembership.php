<?php

namespace Domain\System\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemMembership
 *
 * @property int $id
 * @property int $signupemail_customer
 * @property int $signupemail_admin
 * @property int $renewemail_customer
 * @property int $renewemail_admin
 * @property int $expirationalert1_days
 * @property int $expirationalert2_days
 * @property int $expirationalert1_email
 * @property int $expirationalert2_email
 * @property int $expiration_email
 * @property int $downgrade_restriction_days
 *
 * @package Domain\System\Models
 */
class SystemMembership extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'system_membership';

    protected $casts = [
        'id' => 'int',
        'signupemail_customer' => 'int',
        'signupemail_admin' => 'int',
        'renewemail_customer' => 'int',
        'renewemail_admin' => 'int',
        'expirationalert1_days' => 'int',
        'expirationalert2_days' => 'int',
        'expirationalert1_email' => 'int',
        'expirationalert2_email' => 'int',
        'expiration_email' => 'int',
        'downgrade_restriction_days' => 'int',
    ];

    protected $fillable = [
        'signupemail_customer',
        'signupemail_admin',
        'renewemail_customer',
        'renewemail_admin',
        'expirationalert1_days',
        'expirationalert2_days',
        'expirationalert1_email',
        'expirationalert2_email',
        'expiration_email',
        'downgrade_restriction_days',
    ];
}
