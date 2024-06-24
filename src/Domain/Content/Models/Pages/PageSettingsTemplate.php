<?php

namespace Domain\Content\Models\Pages;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class PagesSettingsTemplate
 *
 * @property int $id
 * @property string $name
 * @property int|null $layout_id
 * @property int|null $module_template_id
 * @property int|null $settings_template_id
 * @property string $module_custom_values
 *
 * @property Layout|null $display_layout
 * @property ModuleTemplate|null $modules_template
 * @property PageSettingsTemplate|null $pages_settings_template
 * @property Collection|array<PageSetting> $pages_settings
 * @property Collection|array<SitePageSettings> $pages_settings_sites
 * @property Collection|array<PageSettingsTemplate> $pages_settings_templates
 * @property Collection|array<Module> $modules
 *
 * @package Domain\Pages\Models
 */
class PageSettingsTemplate extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'pages_settings_templates';

    protected $casts = [
        'layout_id' => 'int',
        'module_template_id' => 'int',
        'settings_template_id' => 'int',
    ];

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'module_template_id');
    }

    public function parent()
    {
        return $this->belongsTo(PageSettingsTemplate::class, 'settings_template_id');
    }

    public function children()
    {
        return $this->hasMany(PageSettingsTemplate::class, 'settings_template_id');
    }

    public function settings()
    {
        return $this->hasMany(PageSetting::class, 'settings_template_id');
    }

    public function siteSettings()
    {
        return $this->hasMany(SitePageSettings::class, 'settings_template_id');
    }

    public function modules()
    {
        //todo
        return $this->belongsToMany(
            Module::class,
            SettingsTemplateModuleValue::class,
            'settings_template_id'
        )
            ->withPivot('id', 'section_id', 'field_id', 'custom_value');
    }
}
