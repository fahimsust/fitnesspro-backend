<?php

namespace Domain\Accounts\Models\Friends;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FriendsUpdatesType
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|array<FriendUpdate> $friends_updates
 *
 * @package Domain\Accounts\Models\Friends
 */
class UpdateType extends Model
{
    public $timestamps = false;
    protected $table = 'friends_updates_types';

    protected $fillable = [
        'name',
    ];

    public function updates()
    {
        return $this->hasMany(FriendUpdate::class, 'type_id');
    }
}
