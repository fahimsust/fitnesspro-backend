<?php

namespace Domain\Products\Models\Product\Settings;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Sites\Models\Layout\Layout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsSettingsTemplate
 *
 * @property int $id
 * @property string $name
 * @property int|null $settings_template_id
 * @property int|null $product_detail_template
 * @property int|null $product_thumbnail_template
 * @property int|null $product_zoom_template
 * @property int|null $layout_id
 * @property int|null $module_template_id
 *
 * @property Layout|null $display_layout
 * @property ModuleTemplate|null $modules_template
 * @property ProductSettingsTemplate|null $products_settings_template
 * @property Collection|array<ProductSettings> $products_settings
 * @property Collection|array<ProductSiteSettings> $products_settings_sites
 * @property Collection|array<ProductSettingsTemplate> $products_settings_templates
 *
 * @package Domain\Products\Models\Product
 */
class ProductSettingsTemplate extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'products_settings_templates';

    protected $casts = [
        'settings_template_id' => 'int',
        'product_detail_template' => 'int',
        'product_thumbnail_template' => 'int',
        'product_zoom_template' => 'int',
        'layout_id' => 'int',
        'module_template_id' => 'int',
    ];

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
        return $this->belongsTo(ProductSettingsTemplate::class, 'settings_template_id');
    }

    public function productSettings()
    {
        return $this->hasOne(ProductSettings::class, 'settings_template_id');
    }

    public function siteSettings()
    {
        return $this->hasMany(
            ProductSiteSettings::class,
            'settings_template_id'
        );
    }
}
