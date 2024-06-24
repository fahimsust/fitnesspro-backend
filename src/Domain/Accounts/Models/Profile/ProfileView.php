<?php

namespace Domain\Accounts\Models\Profile;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountsView
 *
 * @property int $account_id
 * @property Carbon $viewed_date
 * @property Carbon $viewed_time
 *
 * @property Account $account
 *
 * @package Domain\Accounts\Models
 */
class ProfileView extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'accounts_views';

    protected $casts = [
        'account_id' => 'int',
        'viewed_date' => 'datetime',
        'viewed_time' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'viewed_date',
        'viewed_time',
    ];

    public function profile()
    {
        return $this->belongsTo(Account::class, 'profile_id');
    }

    public function viewedBy()
    {
        return $this->belongsTo(Account::class);
    }
}
