<?php

namespace Domain\Modules\Models;

use Domain\Content\Models\Pages\SettingsTemplateModuleValue;
use Domain\Content\Models\Pages\SitePageSettingsModuleValue;
use Domain\Products\Models\Category\CategorySettingsSiteModuleValue;
use Domain\Products\Models\Category\CategorySettingsTemplateModuleValue;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplateModuleValue;
use Domain\Products\Models\Product\Settings\ProductSiteSettingsModuleValue;
use Domain\Sites\Models\SiteSettingsModuleValue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ModulesField
 *
 * @property int $id
 * @property int $module_id
 * @property string $field_name
 *
 * @property Module $module
 * @property Collection|array<CategorySettingsSiteModuleValue> $categories_settings_sites_modulevalues
 * @property Collection|array<CategorySettingsTemplateModuleValue> $categories_settings_templates_modulevalues
 * @property Collection|array<SitePageSettingsModuleValue> $pages_settings_sites_modulevalues
 * @property Collection|array<SettingsTemplateModuleValue> $pages_settings_templates_modulevalues
 * @property Collection|array<ProductSiteSettingsModuleValue> $products_settings_sites_modulevalues
 * @property Collection|array<ProductSettingsTemplateModuleValue> $products_settings_templates_modulevalues
 * @property Collection|array<SiteSettingsModuleValue> $sites_settings_modulevalues
 *
 * @package Domain\Modules\Models
 */
class ModuleField extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'modules_fields';

    protected $casts = [
        'module_id' => 'int',
    ];

    protected $fillable = [
        'module_id',
        'field_name',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

//  public function categories_settings_sites_modulevalues()
//  {
//      return $this->hasMany(CategoriesSettingsSitesModulevalue::class, 'field_id');
//  }
//
//  public function categories_settings_templates_modulevalues()
//  {
//      return $this->hasMany(CategoriesSettingsTemplatesModulevalue::class, 'field_id');
//  }
//
//  public function pages_settings_sites_modulevalues()
//  {
//      return $this->hasMany(PagesSettingsSitesModulevalue::class, 'field_id');
//  }
//
//  public function pages_settings_templates_modulevalues()
//  {
//      return $this->hasMany(PagesSettingsTemplatesModulevalue::class, 'field_id');
//  }
//
//  public function products_settings_sites_modulevalues()
//  {
//      return $this->hasMany(ProductsSettingsSitesModulevalue::class, 'field_id');
//  }
//
//  public function products_settings_templates_modulevalues()
//  {
//      return $this->hasMany(ProductsSettingsTemplatesModulevalue::class, 'field_id');
//  }
//
//  public function sites_settings_modulevalues()
//  {
//      return $this->hasMany(SitesSettingsModulevalue::class, 'field_id');
//  }
}
