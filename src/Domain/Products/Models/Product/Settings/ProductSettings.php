<?php

namespace Domain\Products\Models\Product\Settings;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsSetting
 *
 * @property int $product_id
 * @property int $settings_template_id
 * @property int $product_detail_template
 * @property int $product_thumbnail_template
 * @property int $product_zoom_template
 * @property int $product_related_count
 * @property int $product_brands_count
 * @property int $product_related_template
 * @property int $product_brands_template
 * @property bool $show_brands_products
 * @property bool $show_related_products
 * @property bool $show_specs
 * @property bool $show_reviews
 * @property int $layout_id
 * @property int $module_template_id
 * @property string $module_custom_values
 * @property string $module_override_values
 * @property bool $use_default_related
 * @property bool $use_default_brand
 * @property bool $use_default_specs
 * @property bool $use_default_reviews
 *
 * @property Layout $display_layout
 * @property ModuleTemplate $modules_template
 * @property Product $product
 * @property ProductSettingsTemplate $products_settings_template
 *
 * @package Domain\Products\Models\Product
 */
class ProductSettings extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $incrementing = false;

    protected $table = 'products_settings';

    protected $primaryKey = 'product_id';

    protected $casts = [
        'product_id' => 'int',
        'settings_template_id' => 'int',
        'product_detail_template' => 'int',
        'product_thumbnail_template' => 'int',
        'product_zoom_template' => 'int',
        'product_related_count' => 'int',
        'product_brands_count' => 'int',
        'product_related_template' => 'int',
        'product_brands_template' => 'int',
        'show_brands_products' => 'bool',
        'show_related_products' => 'bool',
        'show_specs' => 'bool',
        'show_reviews' => 'bool',
        'layout_id' => 'int',
        'module_template_id' => 'int',
        'use_default_related' => 'bool',
        'use_default_brand' => 'bool',
        'use_default_specs' => 'bool',
        'use_default_reviews' => 'bool',
    ];

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'module_template_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function settingsTemplate()
    {
        return $this->belongsTo(ProductSettingsTemplate::class, 'settings_template_id');
    }
}
