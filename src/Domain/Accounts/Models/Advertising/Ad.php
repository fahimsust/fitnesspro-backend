<?php

namespace Domain\Accounts\Models\Advertising;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModsAccountAd
 *
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property string $link
 * @property string $img
 * @property int $clicks
 * @property int $shown
 * @property bool $status
 * @property Carbon $created
 *
 * @property Account $account
 * @property AdClick $mods_account_ads_click
 *
 * @package Domain\Accounts\Models\Mods
 */
class Ad extends Model
{
    public $timestamps = false;
    protected $table = 'account_ads';

    protected $casts = [
        'account_id' => 'int',
        'clicks' => 'int',
        'shown' => 'int',
        'status' => 'bool',
        'created' => 'datetime',
    ];

    protected $fillable = [
        'account_id',
        'name',
        'link',
        'img',
        'clicks',
        'shown',
        'status',
        'created',
    ];

    public function advertiser()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function clicks()
    {
        return $this->hasMany(AdClick::class, 'ad_id');
    }
}
