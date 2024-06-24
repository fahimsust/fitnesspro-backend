<?php

namespace Domain\Accounts\Models;

use Carbon\Carbon;
use Domain\Messaging\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountsTemplatesSent
 *
 * @property int $account_id
 * @property int $template_id
 * @property Carbon $sent
 *
 * @property Account $account
 * @property MessageTemplate $message_template
 *
 * @package Domain\Accounts\Models
 */
class MessageTemplateSentToAccount extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'accounts_templates_sent';

    protected $casts = [
        'account_id' => 'int',
        'template_id' => 'int',
        'sent' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'template_id',
        'sent',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function messageTemplate()
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }
}
