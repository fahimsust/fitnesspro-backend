<?php

namespace Domain\Messaging\Models\AutomatedEmails;

use Domain\Accounts\Models\AccountType;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AutomatedEmail
 *
 * @property int $id
 * @property string $name
 * @property int $message_template_id
 * @property bool $status
 * @property int $send_on
 * @property int $send_on_status
 * @property int $send_on_daysafter
 *
 * @property MessageTemplate $message_template
 * @property Collection|array<AutoEmailAccountType> $automated_emails_accounttypes
 * @property Collection|array<Site> $sites
 *
 * @package Domain\Messaging\Models
 */
class AutoEmail extends Model
{
    public $timestamps = false;
    protected $table = 'automated_emails';

    protected $casts = [
        'message_template_id' => 'int',
        'status' => 'bool',
        'send_on' => 'int',
        'send_on_status' => 'int',
        'send_on_daysafter' => 'int',
    ];

    protected $fillable = [
        'name',
        'message_template_id',
        'status',
        'send_on',
        'send_on_status',
        'send_on_daysafter',
    ];

    public function messageTemplate()
    {
        return $this->belongsTo(MessageTemplate::class);
    }

    public function accountTypes()
    {
        //todo
        return $this->hasManyThrough(
            AccountType::class,
            AutoEmailAccountType::class
        );
    }

    public function sites()
    {
        //todo
        return $this->hasManyThrough(
            Site::class,
            AutoEmailSite::class
        );
    }
}
