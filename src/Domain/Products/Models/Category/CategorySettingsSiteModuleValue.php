<?php

namespace Domain\Products\Models\Category;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CategoriesSettingsSitesModulevalue
 *
 * @property int $id
 * @property int $category_id
 * @property int $site_id
 * @property int $section_id
 * @property int $module_id
 * @property int $field_id
 * @property string|null $custom_value
 *
 * @property Category $category
 * @property ModuleField $modules_field
 * @property Module $module
 * @property LayoutSection $display_section
 * @property Site $site
 *
 * @package Domain\Products\Models\Category
 */
class CategorySettingsSiteModuleValue extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'categories_settings_sites_modulevalues';

    protected $casts = [
        'category_id' => 'int',
        'site_id' => 'int',
        'section_id' => 'int',
        'module_id' => 'int',
        'field_id' => 'int',
    ];

    protected $fillable = [
        'category_id',
        'site_id',
        'section_id',
        'module_id',
        'field_id',
        'custom_value',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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
