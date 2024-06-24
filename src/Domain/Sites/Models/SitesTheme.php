<?php

namespace Domain\Sites\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SitesTheme
 *
 * @property int $site_id
 * @property int $theme_id
 * @property string $theme_values
 *
 * @property Site $site
 * @property Theme $display_theme
 *
 * @package Domain\Sites\Models
 */
class SitesTheme extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'sites_themes';

    protected $casts = [
        'site_id' => 'int',
        'theme_id' => 'int',
    ];

    protected $fillable = [
        'site_id',
        'theme_id',
        'theme_values',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function display_theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}
