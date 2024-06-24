<?php

namespace Domain\Photos\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PhotosComment
 *
 * @property int $id
 * @property int $photo_id
 * @property string $body
 * @property int $account_id
 * @property Carbon $created
 * @property bool $beenread
 *
 * @property Account $account
 * @property Photo $photo
 *
 * @package Domain\Photos\Models
 */
class PhotoComment extends Model
{
    public $timestamps = false;
    protected $table = 'photos_comments';

    protected $casts = [
        'photo_id' => 'int',
        'account_id' => 'int',
        'beenread' => 'bool',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'photo_id',
        'body',
        'account_id',
        'created',
        'beenread',
    ];

    public function author()
    {
        return $this->belongsTo(Account::class);
    }

    public function subject()
    {
        return $this->belongsTo(Photo::class);
    }
}
