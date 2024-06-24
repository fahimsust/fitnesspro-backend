<?php

namespace Domain\Products\Models\Category;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplateModuleValue;
use Domain\Products\Models\SearchForm\SearchForm;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CategoriesSettingsTemplate
 *
 * @property int $id
 * @property string $name
 * @property int|null $settings_template_id
 * @property bool|null $use_default_category
 * @property bool|null $use_default_feature
 * @property bool|null $use_default_product
 * @property int|null $category_thumbnail_template
 * @property int|null $product_thumbnail_template
 * @property int|null $product_thumbnail_count
 * @property int|null $feature_thumbnail_template
 * @property int|null $feature_thumbnail_count
 * @property bool|null $feature_showsort
 * @property int|null $feature_defaultsort
 * @property bool|null $product_thumbnail_showsort
 * @property int|null $product_thumbnail_defaultsort
 * @property bool|null $product_thumbnail_customsort
 * @property bool|null $product_thumbnail_showmessage
 * @property bool|null $feature_showmessage
 * @property bool|null $show_categories_in_body
 * @property bool|null $show_products
 * @property bool|null $show_featured
 * @property int|null $layout_id
 * @property int|null $module_template_id
 * @property string $module_custom_values
 * @property int|null $search_form_id
 *
 * @property Layout|null $display_layout
 * @property ModuleTemplate|null $modules_template
 * @property SearchForm|null $search_form
 * @property CategorySettingsTemplate|null $categories_settings_template
 * @property Collection|array<CategorySettings> $categories_settings
 * @property Collection|array<CategorySiteSettings> $categories_settings_sites
 * @property Collection|array<CategorySettingsTemplate> $categories_settings_templates
 * @property Collection|array<Module> $modules
 * @property Collection|array<ProductSettingsTemplateModuleValue> $products_settings_templates_modulevalues
 *
 * @package Domain\Products\Models\Category
 */
class CategorySettingsTemplate extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'categories_settings_templates';

    protected $casts = [
        'settings_template_id' => 'int',
        'use_default_category' => 'bool',
        'use_default_feature' => 'bool',
        'use_default_product' => 'bool',
        'category_thumbnail_template' => 'int',
        'product_thumbnail_template' => 'int',
        'product_thumbnail_count' => 'int',
        'feature_thumbnail_template' => 'int',
        'feature_thumbnail_count' => 'int',
        'feature_showsort' => 'bool',
        'feature_defaultsort' => 'int',
        'product_thumbnail_showsort' => 'bool',
        'product_thumbnail_defaultsort' => 'int',
        'product_thumbnail_customsort' => 'bool',
        'product_thumbnail_showmessage' => 'int',
        'feature_showmessage' => 'int',
        'show_categories_in_body' => 'int',
        'show_products' => 'int',
        'show_featured' => 'int',
        'layout_id' => 'int',
        'module_template_id' => 'int',
        'search_form_id' => 'int',
    ];

    protected $fillable = [
        'name',
        'settings_template_id',
        'use_default_category',
        'use_default_feature',
        'use_default_product',
        'category_thumbnail_template',
        'product_thumbnail_template',
        'product_thumbnail_count',
        'feature_thumbnail_template',
        'feature_thumbnail_count',
        'feature_showsort',
        'feature_defaultsort',
        'product_thumbnail_showsort',
        'product_thumbnail_defaultsort',
        'product_thumbnail_customsort',
        'product_thumbnail_showmessage',
        'feature_showmessage',
        'show_categories_in_body',
        'show_products',
        'show_featured',
        'layout_id',
        'module_template_id',
        'module_custom_values',
        'search_form_id',
    ];

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'module_template_id');
    }

    public function searchForm()
    {
        return $this->belongsTo(SearchForm::class);
    }

    public function parentTemplate()
    {
        return $this->belongsTo(CategorySettingsTemplate::class, 'settings_template_id');
    }

    public function categories()
    {
        //todo
        return $this->hasManyThrough(
            Category::class,
            CategorySettings::class,
            'settings_template_id'
        );
    }

    public function siteSettings()
    {
        return $this->hasMany(
            CategorySiteSettings::class,
            'settings_template_id'
        );
    }

    public function childrenTemplates()
    {
        return $this->hasMany(CategorySettingsTemplate::class, 'settings_template_id');
    }

    public function modules()
    {
        return $this->belongsToMany(
            Module::class,
            CategorySettingsTemplateModuleValue::class,
            'settings_template_id'
        )
            ->withPivot('id', 'section_id', 'field_id', 'custom_value');
    }
}
