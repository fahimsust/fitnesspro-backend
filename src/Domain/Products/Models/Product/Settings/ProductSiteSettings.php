<?php

namespace Domain\Products\Models\Product\Settings;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsSettingsSite
 *
 * @property int $id
 * @property int $product_id
 * @property int $site_id
 * @property int|null $settings_template_id
 * @property int|null $product_detail_template
 * @property int|null $product_thumbnail_template
 * @property int|null $product_zoom_template
 * @property int|null $layout_id
 * @property int|null $module_template_id
 *
 * @property Layout|null $display_layout
 * @property ModuleTemplate|null $modules_template
 * @property Product $product
 * @property ProductSettingsTemplate|null $products_settings_template
 * @property Site $site
 *
 * @package Domain\Products\Models\Product
 */
class ProductSiteSettings extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'products_settings_sites';

    protected $casts = [
        'product_id' => 'int',
        'site_id' => 'int',
        'settings_template_id' => 'int',
        'product_detail_template' => 'int',
        'product_thumbnail_template' => 'int',
        'product_zoom_template' => 'int',
        'layout_id' => 'int',
        'module_template_id' => 'int',
    ];

    public function layout()
    {
        return $this->belongsTo(
            Layout::class,
            'layout_id'
        );
    }

    public function moduleTemplate()
    {
        return $this->belongsTo(
            ModuleTemplate::class,
            'module_template_id'
        );
    }

    public function thumbnailTemplate()
    {
        return $this->belongsTo(
            DisplayTemplate::class,
            'product_thumbnail_template'
        );
    }

    public function detailTemplate()
    {
        return $this->belongsTo(
            DisplayTemplate::class,
            'product_detail_template'
        );
    }

    public function zoomTemplate()
    {
        return $this->belongsTo(
            DisplayTemplate::class,
            'product_zoom_template'
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function settingsTemplate()
    {
        return $this->belongsTo(
            ProductSettingsTemplate::class,
            'settings_template_id'
        );
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
