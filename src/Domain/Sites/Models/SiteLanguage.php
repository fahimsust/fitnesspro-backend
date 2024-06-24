<?php

namespace Domain\Sites\Models;

use Domain\Locales\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class SitesLanguage
 *
 * @property int $site_id
 * @property int $language_id
 * @property int $rank
 *
 * @property Language $language
 * @property Site $site
 *
 * @package Domain\Sites\Models
 */
class SiteLanguage extends Model
{
    use HasFactory,HasModelUtilities;
    protected $table = 'sites_languages';

    protected $casts = [
        'site_id' => 'int',
        'language_id' => 'int',
        'rank' => 'int',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
