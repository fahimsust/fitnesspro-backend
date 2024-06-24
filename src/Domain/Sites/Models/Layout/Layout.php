<?php

namespace Domain\Sites\Models\Layout;

use Domain\Content\Models\Pages\PageSetting;
use Domain\Content\Models\Pages\PageSettingsTemplate;
use Domain\Content\Models\Pages\SitePageSettings;
use Domain\Products\Models\Category\CategorySettings;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class DisplayLayout
 *
 * @property int $id
 * @property string $name
 * @property string $file
 *
 * @property Collection|array<CategorySettings> $categories_settings
 * @property Collection|array<CategorySiteSettings> $categories_settings_sites
 * @property Collection|array<CategorySettingsTemplate> $categories_settings_templates
 * @property Collection|array<PageSetting> $pages_settings
 * @property Collection|array<SitePageSettings> $pages_settings_sites
 * @property Collection|array<PageSettingsTemplate> $pages_settings_templates
 * @property Collection|array<ProductSettings> $products_settings
 * @property Collection|array<ProductSiteSettings> $products_settings_sites
 * @property Collection|array<ProductSettingsTemplate> $products_settings_templates
 * @property Collection|array<SiteSettings> $sites_settings
 *
 * @package App\Models
 */
class Layout extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'display_layouts';

    //  public function categories_settings()
    //  {
//      return $this->hasMany(CategoriesSetting::class, 'layout_id');
    //  }
//
    //  public function categories_settings_sites()
    //  {
//      return $this->hasMany(CategoriesSettingsSite::class, 'layout_id');
    //  }
//
    //  public function categories_settings_templates()
    //  {
//      return $this->hasMany(CategoriesSettingsTemplate::class, 'layout_id');
    //  }
//
    //  public function pages_settings()
    //  {
//      return $this->hasMany(PagesSetting::class, 'layout_id');
    //  }
//
    //  public function pages_settings_sites()
    //  {
//      return $this->hasMany(PagesSettingsSite::class, 'layout_id');
    //  }
//
    //  public function pages_settings_templates()
    //  {
//      return $this->hasMany(PagesSettingsTemplate::class, 'layout_id');
    //  }
//
    //  public function products_settings()
    //  {
//      return $this->hasMany(ProductsSetting::class, 'layout_id');
    //  }
//
    //  public function products_settings_sites()
    //  {
//      return $this->hasMany(ProductsSettingsSite::class, 'layout_id');
    //  }
//
    //  public function products_settings_templates()
    //  {
//      return $this->hasMany(ProductsSettingsTemplate::class, 'layout_id');
    //  }
//
    //  public function sites_settings()
    //  {
//      return $this->hasMany(SitesSetting::class, 'wishlist_layout_id');
    //  }
}
