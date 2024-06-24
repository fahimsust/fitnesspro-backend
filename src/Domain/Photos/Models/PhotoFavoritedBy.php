<?php

namespace Domain\Photos\Models;

use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PhotosFavorite
 *
 * @property int $account_id
 * @property int $photo_id
 *
 * @property Account $account
 * @property Photo $photo
 *
 * @package Domain\Photos\Models
 */
class PhotoFavoritedBy extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'photos_favorites';

    protected $casts = [
        'account_id' => 'int',
        'photo_id' => 'int',
    ];

    protected $fillable = [
        'account_id',
        'photo_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function subject()
    {
        return $this->belongsTo(Photo::class);
    }
}
