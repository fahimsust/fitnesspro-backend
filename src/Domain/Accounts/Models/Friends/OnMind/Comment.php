<?php

namespace Domain\Accounts\Models\Friends\OnMind;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountsOnmindComment
 *
 * @property int $id
 * @property int $onmind_id
 * @property int $comment_id
 * @property int $account_id
 * @property string $text
 * @property Carbon $posted
 *
 * @property Account $account
 * @property Comment $accounts_comment
 * @property OnMind $accounts_onmind
 *
 * @package Domain\Accounts\Models\Onmind
 */
class Comment extends Model
{
    public $timestamps = false;
    protected $table = 'accounts_onmind_comments';

    protected $casts = [
        'onmind_id' => 'int',
        'comment_id' => 'int',
        'account_id' => 'int',
        'posted' => 'datetime',
    ];

    protected $fillable = [
        'onmind_id',
        'comment_id',
        'account_id',
        'text',
        'posted',
    ];

    public function author()
    {
        return $this->belongsTo(Account::class);
    }

    public function replyingTo()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function subject()
    {
        return $this->belongsTo(OnMind::class, 'onmind_id');
    }
}
