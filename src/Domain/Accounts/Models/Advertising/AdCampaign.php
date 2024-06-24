<?php

namespace Domain\Accounts\Models\Advertising;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModsAccountAdsCampaign
 *
 * @property int $id
 * @property int $lastshown_ad
 *
 * @package Domain\Accounts\Models\Mods
 */
class AdCampaign extends Model
{
    public $timestamps = false;
    //rename account_ad_campaigns
    protected $table = 'account_ads_campaigns';

    protected $casts = [
        'lastshown_ad' => 'int',
    ];

    protected $fillable = [
        'lastshown_ad',
    ];

    public function lastShownAd()
    {
        return $this->belongsTo(Ad::class, 'lastshown_id');
    }
}
