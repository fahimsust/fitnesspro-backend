<?php

namespace Domain\Modules\Models;

use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageSettingsTemplate;
use Domain\Products\Models\Category\CategorySettingsSiteModuleValue;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySettingsTemplateModuleValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplateModuleValue;
use Domain\Products\Models\Product\Settings\ProductSiteSettingsModuleValue;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettingsModuleValue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Module
 *
 * @property int $id
 * @property string $name
 * @property string $file
 * @property string $config_values
 * @property string $description
 * @property bool $showinmenu
 *
 * @property Collection|array<Site> $sites
 * @property Collection|array<CategorySettingsTemplate> $categories_settings_templates
 * @property Collection|array<ModuleAdminController> $modules_admin_controllers
 * @property Collection|array<ModuleCron> $modules_crons
 * @property Collection|array<ModuleField> $modules_fields
 * @property Collection|array<ModuleSiteController> $modules_site_controllers
 * @property ModuleTemplateModule $modules_templates_module
 * @property Collection|array<Page> $pages
 * @property Collection|array<PageSettingsTemplate> $pages_settings_templates
 * @property Collection|array<Product> $products
 * @property Collection|array<ProductSettingsTemplateModuleValue> $products_settings_templates_modulevalues
 *
 * @package Domain\Modules\Models
 */
class Module extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'modules';

    protected $casts = [
        'showinmenu' => 'bool',
    ];

    //  public function sites()
    //  {
//      return $this->belongsToMany(
//            Site::class,
//            'sites_settings_modulevalues')
//                  ->withPivot('id', 'section', 'section_id', 'field_id', 'custom_value');
    //  }
//
    //  public function categories_settings_templates()
    //  {
//      return $this->belongsToMany(CategoriesSettingsTemplate::class, 'categories_settings_templates_modulevalues', 'module_id', 'settings_template_id')
//                  ->withPivot('id', 'section_id', 'field_id', 'custom_value');
    //  }

    public function adminControllers()
    {
        return $this->hasMany(ModuleAdminController::class);
    }

    public function crons()
    {
        return $this->hasMany(ModuleCron::class);
    }

    public function fields()
    {
        return $this->hasMany(ModuleField::class);
    }
    public function productSiteSettingsModuleValue()
    {
        return $this->hasMany(ProductSiteSettingsModuleValue::class);
    }
    public function categorySettingsTemplateModuleValue()
    {
        return $this->hasMany(CategorySettingsTemplateModuleValue::class);
    }
    public function categorySettingsSiteModuleValue()
    {
        return $this->hasMany(CategorySettingsSiteModuleValue::class);
    }
    public function productSettingsTemplateModuleValue()
    {
        return $this->hasMany(ProductSettingsTemplateModuleValue::class);
    }
    public function siteSettingsModuleValue()
    {
        return $this->hasMany(SiteSettingsModuleValue::class);
    }

    public function siteControllers()
    {
        return $this->hasMany(ModuleSiteController::class);
    }

    public function moduleTemplates()
    {
        return $this->hasOne(ModuleTemplateModule::class);
    }

//  public function pages()
//  {
//      return $this->belongsToMany(
//            Page::class,
//            'pages_settings_sites_modulevalues')
//                  ->withPivot('id', 'site_id', 'section_id', 'field_id', 'custom_value');
//  }

//  public function pages_settings_templates()
//  {
//      return $this->belongsToMany(PagesSettingsTemplate::class, 'pages_settings_templates_modulevalues', 'module_id', 'settings_template_id')
//                  ->withPivot('id', 'section_id', 'field_id', 'custom_value');
//  }
//
//  public function products()
//  {
//      return $this->belongsToMany(Product::class, 'products_settings_sites_modulevalues')
//                  ->withPivot('id', 'site_id', 'section_id', 'field_id', 'custom_value');
//  }
//
//  public function products_settings_templates_modulevalues()
//  {
//      return $this->hasMany(ProductsSettingsTemplatesModulevalue::class);
//  }
}
