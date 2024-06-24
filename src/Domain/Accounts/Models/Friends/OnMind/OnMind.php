<?php

namespace Domain\Accounts\Models\Friends\OnMind;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountsOnmind
 *
 * @property int $id
 * @property int $account_id
 * @property string $text
 * @property Carbon $posted
 * @property int $like_count
 * @property int $dislike_count
 * @property int $comment_count
 *
 * @property Account $account
 * @property Collection|array<Comment> $accounts_onmind_comments
 * @property Like $accounts_onmind_like
 *
 * @package Domain\Accounts\Models\Onmind
 */
class OnMind extends Model
{
    public $timestamps = false;
    protected $table = 'accounts_onmind';

    protected $casts = [
        'account_id' => 'int',
        'like_count' => 'int',
        'dislike_count' => 'int',
        'comment_count' => 'int',
        'posted' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'text',
        'posted',
        'like_count',
        'dislike_count',
        'comment_count',
    ];

    public function author()
    {
        return $this->belongsTo(Account::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'onmind_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'onmind_id');
    }
}
