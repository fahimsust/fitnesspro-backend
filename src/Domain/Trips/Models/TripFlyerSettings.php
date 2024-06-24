<?php

namespace Domain\Trips\Models;

use Domain\Accounts\Models\Account;
use Domain\Photos\Models\Photo;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModsTripFlyersSetting
 *
 * @property int $id
 * @property int $account_id
 * @property int $photo_id
 * @property string $bio
 *
 * @property Account $account
 * @property Photo $photo
 *
 * @package Domain\Trips\Models
 */
class TripFlyerSettings extends Model
{
    public $timestamps = false;
    protected $table = 'trip_flyers_settings';

    protected $casts = [
        'account_id' => 'int',
        'photo_id' => 'int',
    ];

    protected $fillable = [
        'account_id',
        'photo_id',
        'bio',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
