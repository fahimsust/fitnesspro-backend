<?php

namespace Domain\Accounts\Models\Friends;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FriendsUpdate
 *
 * @property int $id
 * @property int $friend_id
 * @property int $type
 * @property int $type_id
 * @property int $num
 * @property Carbon $updated
 *
 * @property Account $account
 * @property UpdateType $friends_updates_type
 *
 * @package Domain\Accounts\Models\Friends
 */
class FriendUpdate extends Model
{
    public $timestamps = false;
    protected $table = 'friends_updates';

    protected $casts = [
        'friend_id' => 'int',
        'type' => 'int',
        'type_id' => 'int',
        'num' => 'int',
        'updated' => 'datetime',
    ];

    protected $fillable = [
        'friend_id',
        'type',
        'type_id',
        'num',
        'updated',
    ];

    public function owner()
    {
        return $this->belongsTo(Account::class, 'friend_id');
    }

    public function type()
    {
        return $this->belongsTo(UpdateType::class, 'type_id');
    }
}
