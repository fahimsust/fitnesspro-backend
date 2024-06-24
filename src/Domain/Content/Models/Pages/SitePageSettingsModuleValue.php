<?php

namespace Domain\Content\Models\Pages;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class PagesSettingsSitesModulevalue
 *
 * @property int $id
 * @property int $page_id
 * @property int $site_id
 * @property int $section_id
 * @property int $module_id
 * @property int $field_id
 * @property string|null $custom_value
 *
 * @property ModuleField $modules_field
 * @property Module $module
 * @property Page $page
 * @property LayoutSection $display_section
 * @property Site $site
 *
 * @package Domain\Pages\Models
 */
class SitePageSettingsModuleValue extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'pages_settings_sites_modulevalues';

    protected $casts = [
        'page_id' => 'int',
        'site_id' => 'int',
        'section_id' => 'int',
        'module_id' => 'int',
        'field_id' => 'int',
    ];

    protected $fillable = [
        'page_id',
        'site_id',
        'section_id',
        'module_id',
        'field_id',
        'custom_value',
    ];

    public function moduleField()
    {
        return $this->belongsTo(ModuleField::class, 'field_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function layoutSection()
    {
        return $this->belongsTo(LayoutSection::class, 'section_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
