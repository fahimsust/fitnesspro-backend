<?php

namespace Domain\Products\Models\Category;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Enums\ShowOptions;
use Domain\Products\Enums\ShowProductsOptions;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class CategoriesSetting
 *
 * @property int $category_id
 * @property int $settings_template_id
 * @property bool $use_default_category
 * @property bool $use_default_feature
 * @property bool $use_default_product
 * @property int $category_thumbnail_template
 * @property int $product_thumbnail_template
 * @property int $product_thumbnail_count
 * @property int $feature_thumbnail_template
 * @property int $feature_thumbnail_count
 * @property bool $feature_showsort
 * @property bool $product_thumbnail_showsort
 * @property bool $product_thumbnail_showmessage
 * @property bool $feature_showmessage
 * @property bool $show_categories_in_body
 * @property bool $show_products
 * @property bool $show_featured
 * @property int $layout_id
 * @property int $module_template_id
 *
 * @property Category $category
 * @property Layout $display_layout
 * @property ModuleTemplate $modules_template
 * @property CategorySettingsTemplate $categories_settings_template
 *
 * @package Domain\Products\Models\Category
 */
class CategorySettings extends Model
{
    use HasFactory,
        HasModelUtilities;

    public $incrementing = false;
    protected $table = 'categories_settings';
    protected $primaryKey = 'category_id';

    protected $casts = [
        'category_id' => 'int',
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
        'product_thumbnail_showsort' => 'bool',
        'product_thumbnail_showmessage' => 'bool',
        'feature_showmessage' => 'bool',
        'show_categories_in_body' => 'bool',
        'show_products' => ShowProductsOptions::class,
        'show_featured' => 'bool',
        'layout_id' => 'int',
        'module_template_id' => 'int',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'module_template_id');
    }

    public function settingsTemplate()
    {
        return $this->belongsTo(CategorySettingsTemplate::class, 'settings_template_id');
    }
}
