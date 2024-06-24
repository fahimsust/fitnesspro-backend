<?php

namespace Domain\Products\Models\Category;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Sites\Models\Layout\LayoutSection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CategoriesSettingsTemplatesModulevalue
 *
 * @property int $id
 * @property int $settings_template_id
 * @property int $section_id
 * @property int $module_id
 * @property int $field_id
 * @property string|null $custom_value
 *
 * @property ModuleField $modules_field
 * @property Module $module
 * @property LayoutSection $display_section
 * @property CategorySettingsTemplate $categories_settings_template
 *
 * @package Domain\Products\Models\Category
 */
class CategorySettingsTemplateModuleValue extends Model
{
    use HasModelUtilities,HasFactory;
    public $timestamps = false;
    protected $table = 'categories_settings_templates_modulevalues';

    protected $casts = [
        'settings_template_id' => 'int',
        'section_id' => 'int',
        'module_id' => 'int',
        'field_id' => 'int',
    ];

    protected $fillable = [
        'settings_template_id',
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

    public function settingsTemplate()
    {
        return $this->belongsTo(CategorySettingsTemplate::class, 'settings_template_id');
    }
}
