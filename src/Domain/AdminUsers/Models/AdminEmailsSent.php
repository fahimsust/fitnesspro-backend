<?php

namespace Domain\AdminUsers\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\AdminUsers\Enums\AdminEmailSentStatuses;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\HasModelUtilities;

/**
 * Class AdminEmailsSent
 *
 * @property int $id
 * @property int $account_id
 * @property int $template_id
 * @property string $sent_to
 * @property string $subject
 * @property string $content
 * @property Carbon $sent_date
 * @property int $sent_by
 * @property int $order_id
 *
 * @property Account $account
 * @property Order $order
 * @property MessageTemplate $message_template
 *
 * @package Domain\AdminUsers\Models
 */
class AdminEmailsSent extends Model
{
    public $timestamps = false;
    use HasModelUtilities, HasFactory;
    protected $table = 'admin_emails_sent';

    protected $casts = [
        'account_id' => 'int',
        'template_id' => 'int',
        'sent_by' => 'int',
        'order_id' => 'int',
        'sent_date' => 'datetime',
        'status' => AdminEmailSentStatuses::class,
    ];

    protected $fillable = [
        'account_id',
        'template_id',
        'sent_to',
        'subject',
        'content',
        'sent_date',
        'sent_by',
        'order_id',
        'status'
    ];

    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'sent_by'
        );
    }

    public function sentToAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function messageTemplate(): BelongsTo
    {
        return $this->belongsTo(
            MessageTemplate::class,
            'template_id'
        );
    }
}
