<?php

namespace Domain\Events\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventsView
 *
 * @property int $event_id
 * @property int $account_id
 * @property Carbon $viewed_date
 * @property Carbon $viewed_time
 *
 * @property Account $account
 * @property Event $event
 *
 * @package Domain\Events\Models
 */
class EventView extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'events_views';

    protected $casts = [
        'event_id' => 'int',
        'account_id' => 'int',
        'viewed_date' => 'datetime',
        'viewed_time' => 'datetime',
    ];

    protected $fillable = [
        'event_id',
        'account_id',
        'viewed_date',
        'viewed_time',
    ];

    public function viewer()
    {
        return $this->belongsTo(Account::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
