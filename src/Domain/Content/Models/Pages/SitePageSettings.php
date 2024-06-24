<?php

namespace Domain\Content\Models\Pages;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class PagesSettingsSite
 *
 * @property int $id
 * @property int $page_id
 * @property int $site_id
 * @property int|null $settings_template_id
 * @property int|null $layout_id
 * @property int|null $module_template_id
 *
 * @property Layout|null $display_layout
 * @property ModuleTemplate|null $modules_template
 * @property Page $page
 * @property PageSettingsTemplate|null $pages_settings_template
 * @property Site $site
 *
 * @package Domain\Pages\Models
 */
class SitePageSettings extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'pages_settings_sites';

    protected $casts = [
        'page_id' => 'int',
        'site_id' => 'int',
        'settings_template_id' => 'int',
        'layout_id' => 'int',
        'module_template_id' => 'int',
    ];

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'module_template_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function settingsTemplate()
    {
        return $this->belongsTo(PageSettingsTemplate::class, 'settings_template_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
