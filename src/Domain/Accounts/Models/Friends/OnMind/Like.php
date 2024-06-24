<?php

namespace Domain\Accounts\Models\Friends\OnMind;

use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountsOnmindLike
 *
 * @property int $onmind_id
 * @property int $account_id
 * @property bool $type_id
 *
 * @property Account $account
 * @property OnMind $accounts_onmind
 *
 * @package Domain\Accounts\Models\Onmind
 */
class Like extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'accounts_onmind_likes';

    protected $casts = [
        'onmind_id' => 'int',
        'account_id' => 'int',
        'type_id' => 'bool',
    ];

    protected $fillable = [
        'onmind_id',
        'account_id',
        'type_id',
    ];

    public function by()
    {
        return $this->belongsTo(Account::class);
    }

    public function subject()
    {
        return $this->belongsTo(OnMind::class, 'onmind_id');
    }
}
