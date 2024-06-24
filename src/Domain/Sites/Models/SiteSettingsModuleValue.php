<?php

namespace Domain\Sites\Models;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SitesSettingsModulevalue
 *
 * @property int $id
 * @property string $section
 * @property int $site_id
 * @property int $section_id
 * @property int $module_id
 * @property int $field_id
 * @property string|null $custom_value
 *
 * @property ModuleField $modules_field
 * @property Module $module
 * @property LayoutSection $display_section
 * @property Site $site
 *
 * @package Domain\Sites\Models
 */
class SiteSettingsModuleValue extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'sites_settings_modulevalues';

    protected $casts = [
        'site_id' => 'int',
        'section_id' => 'int',
        'module_id' => 'int',
        'field_id' => 'int',
    ];

    protected $fillable = [
        'section',
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

    public function layoutSection()
    {
        return $this->belongsTo(LayoutSection::class, 'section_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
