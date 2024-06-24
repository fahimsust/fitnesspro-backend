<?php

namespace Domain\Accounts\Models\Friends;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Friend
 *
 * @property int $account_id
 * @property int $friend_id
 * @property int $rank
 * @property Carbon $added
 *
 * @property Account $account
 *
 * @package Domain\Accounts\Models\Friends
 */
class Friend extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'friends';

    protected $casts = [
        'account_id' => 'int',
        'friend_id' => 'int',
        'rank' => 'int',
        'added' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'friend_id',
        'rank',
        'added',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'friend_id');
    }
}
