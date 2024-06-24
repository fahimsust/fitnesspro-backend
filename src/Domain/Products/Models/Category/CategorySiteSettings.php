<?php

namespace Domain\Products\Models\Category;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Enums\ShowOptions;
use Domain\Products\Enums\ShowProductsOptions;
use Domain\Products\Models\SearchForm\SearchForm;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Traits\BelongsTo\BelongsToSite;
use Support\Traits\HasModelUtilities;

/**
 * Class CategoriesSettingsSite
 *
 * @property int $id
 * @property int $category_id
 * @property int $site_id
 * @property int|null $settings_template_id
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
 * @property int|null $search_form_id
 *
 * @property Category $category
 * @property Layout|null $display_layout
 * @property ModuleTemplate|null $modules_template
 * @property SearchForm|null $search_form
 * @property CategorySettingsTemplate|null $categories_settings_template
 * @property Site $site
 *
 * @package Domain\Products\Models\Category
 */
class CategorySiteSettings extends Model
{
    use HasModelUtilities,
        HasFactory,
        BelongsToSite;

    protected $table = 'categories_settings_sites';

    protected $casts = [
        'category_id' => 'int',
        'site_id' => 'int',
        'settings_template_id' => 'int',
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
        'product_thumbnail_showmessage' => 'bool',
        'feature_showmessage' => 'bool',
        'show_categories_in_body' => 'bool',
        'show_products' => ShowProductsOptions::class,
        'show_featured' => 'bool',
        'layout_id' => 'int',
        'module_template_id' => 'int',
        'search_form_id' => 'int',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function layout(): BelongsTo
    {
        return $this->belongsTo(
            Layout::class,
            'layout_id'
        );
    }

    public function moduleTemplate(): BelongsTo
    {
        return $this->belongsTo(
            ModuleTemplate::class,
            'module_template_id'
        );
    }

    public function searchForm(): BelongsTo
    {
        return $this->belongsTo(SearchForm::class);
    }

    public function settingsTemplate(): BelongsTo
    {
        return $this->belongsTo(
            CategorySettingsTemplate::class,
            'settings_template_id'
        );
    }
}
