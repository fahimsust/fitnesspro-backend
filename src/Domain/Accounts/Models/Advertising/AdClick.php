<?php

namespace Domain\Accounts\Models\Advertising;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModsAccountAdsClick
 *
 * @property int $ad_id
 * @property Carbon $clicked
 *
 * @property Ad $mods_account_ad
 *
 * @package Domain\Accounts\Models\Mods
 */
class AdClick extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'account_ads_clicks';

    protected $casts = [
        'ad_id' => 'int',
        'clicked' => 'datetime',
    ];

    protected $fillable = [
        'ad_id',
        'clicked',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }
}
