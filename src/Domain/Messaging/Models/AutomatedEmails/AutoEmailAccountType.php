<?php

namespace Domain\Messaging\Models\AutomatedEmails;

use Domain\Accounts\Models\AccountType;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AutomatedEmailsAccounttype
 *
 * @property int $automated_email_id
 * @property int $account_type_id
 *
 * @property AccountType $accounts_type
 * @property AutoEmail $automated_email
 *
 * @package Domain\Messaging\Models
 */
class AutoEmailAccountType extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'automated_emails_accounttypes';

    protected $casts = [
        'automated_email_id' => 'int',
        'account_type_id' => 'int',
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function autoEmail()
    {
        return $this->belongsTo(AutoEmail::class);
    }
}
