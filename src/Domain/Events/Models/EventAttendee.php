<?php

namespace Domain\Events\Models;

use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventsToattend
 *
 * @property int $userid
 * @property int $eventid
 *
 * @property Event $event
 * @property Account $account
 *
 * @package Domain\Events\Models
 */
class EventAttendee extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'events_toattend';

    protected $casts = [
        'userid' => 'int',
        'eventid' => 'int',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'eventid');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'userid');
    }
}
