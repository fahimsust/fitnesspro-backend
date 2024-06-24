<?php

namespace Domain\Accounts\Models\Friends;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class FriendRequest
 *
 * @property int $id
 * @property int $account_id
 * @property int $friend_id
 * @property string $note
 * @property Carbon $created
 * @property bool $status
 *
 * @property Account $account
 *
 * @package Domain\Accounts\Models\Friends
 */
class FriendRequest extends Model
{
    public $timestamps = false;
    protected $table = 'friend_requests';

    protected $casts = [
        'account_id' => 'int',
        'friend_id' => 'int',
        'status' => 'bool',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'friend_id',
        'note',
        'created',
        'status',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function requestor(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'friend_id');
    }
}
