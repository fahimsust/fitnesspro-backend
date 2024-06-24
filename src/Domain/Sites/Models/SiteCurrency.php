<?php

namespace Domain\Sites\Models;

use Domain\Locales\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SitesCurrency
 *
 * @property int $site_id
 * @property int $currency_id
 * @property int $rank
 *
 * @property Currency $currency
 * @property Site $site
 *
 * @package Domain\Sites\Models
 */
class SiteCurrency extends Model
{
    public $incrementing = false;
    use HasFactory,
        HasModelUtilities;
    protected $table = 'sites_currencies';

    protected $casts = [
        'site_id' => 'int',
        'currency_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'rank',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
