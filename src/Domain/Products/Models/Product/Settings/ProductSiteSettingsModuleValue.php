<?php

namespace Domain\Products\Models\Product\Settings;

use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ProductsSettingsSitesModulevalue
 *
 * @property int $id
 * @property int $product_id
 * @property int $site_id
 * @property int $section_id
 * @property int $module_id
 * @property int $field_id
 * @property string|null $custom_value
 *
 * @property ModuleField $modules_field
 * @property Module $module
 * @property Product $product
 * @property LayoutSection $display_section
 * @property Site $site
 *
 * @package Domain\Products\Models\Product
 */
class ProductSiteSettingsModuleValue extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'products_settings_sites_modulevalues';

    protected $casts = [
        'product_id' => 'int',
        'site_id' => 'int',
        'section_id' => 'int',
        'module_id' => 'int',
        'field_id' => 'int',
    ];

    protected $fillable = [
        'product_id',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
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
