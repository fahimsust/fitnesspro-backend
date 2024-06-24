<?php

namespace Domain\Modules\Models;

use Domain\Content\Models\Pages\PageSetting;
use Domain\Content\Models\Pages\PageSettingsTemplate;
use Domain\Content\Models\Pages\SitePageSettings;
use Domain\Modules\QueryBuilders\ModuleTemplateQuery;
use Domain\Products\Models\Category\CategorySettings;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\Layout\LayoutSection;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class ModulesTemplate
 *
 * @property int $id
 * @property string $name
 * @property int $parent_template_id
 *
 * @property ModuleTemplate $modules_template
 * @property Collection|array<CategorySettings> $categories_settings
 * @property Collection|array<CategorySiteSettings> $categories_settings_sites
 * @property Collection|array<CategorySettingsTemplate> $categories_settings_templates
 * @property Collection|array<ModuleTemplate> $modules_templates
 * @property Collection|array<Module> $modules
 * @property ModuleTemplateSection $modules_templates_section
 * @property Collection|array<PageSetting> $pages_settings
 * @property Collection|array<SitePageSettings> $pages_settings_sites
 * @property Collection|array<PageSettingsTemplate> $pages_settings_templates
 * @property Collection|array<ProductSettings> $products_settings
 * @property Collection|array<ProductSiteSettings> $products_settings_sites
 * @property Collection|array<ProductSettingsTemplate> $products_settings_templates
 * @property Collection|array<SiteSettings> $sites_settings
 *
 * @package Domain\Modules\Models
 */
class ModuleTemplate extends Model
{
    use HasFactory,
        HasModelUtilities;

    protected $table = 'modules_templates';

    protected $casts = [
        'parent_template_id' => 'int',
    ];

    public function parentTemplate()
    {
        return $this->belongsTo(ModuleTemplate::class, 'parent_template_id');
    }
    public function newEloquentBuilder($query)
    {
        return new ModuleTemplateQuery($query);
    }
    public function getAllParentIdWithSelfId()
    {
        $parents = [$this->id];

        $parent = $this->parentTemplate;

        while (!is_null($parent)) {
            $parents[] = $parent->id;
            $parent = $parent->parentTemplate;
        }

        return $parents;
    }

    public function childTemplates()
    {
        return $this->hasMany(ModuleTemplate::class, 'parent_template_id');
    }

    public function modules()
    {
        //todo
        return $this->hasManyThrough(
            Module::class,
            ModuleTemplateModule::class,
            'template_id'
        )
            ->withPivot('section_id', 'rank', 'temp_id');
    }

    public function sections()
    {
        return $this->belongsToMany(
            LayoutSection::class,
            ModuleTemplateSection::class,
            'template_id',
            'section_id'
        );
    }
    public function moduleTemplateSections()
    {
        return $this->hasMany(
            ModuleTemplateSection::class,
            'template_id'
        );
    }

    //    public function pages_settings()
    //    {
    //        return $this->hasMany(PagesSetting::class, 'module_template_id');
    //    }
    //
    //    public function pages_settings_sites()
    //    {
    //        return $this->hasMany(PagesSettingsSite::class, 'module_template_id');
    //    }
    //
    //    public function pages_settings_templates()
    //    {
    //        return $this->hasMany(PagesSettingsTemplate::class, 'module_template_id');
    //    }
    //
    //    public function products_settings()
    //    {
    //        return $this->hasMany(ProductsSetting::class, 'module_template_id');
    //    }
    //
    //    public function products_settings_sites()
    //    {
    //        return $this->hasMany(ProductsSettingsSite::class, 'module_template_id');
    //    }
    //
    //    public function products_settings_templates()
    //    {
    //        return $this->hasMany(ProductsSettingsTemplate::class, 'module_template_id');
    //    }
    //
    //    public function sites_settings()
    //    {
    //        return $this->hasMany(SitesSetting::class, 'wishlist_module_template_id');
    //    }
    //
    //    public function categories_settings()
    //    {
    //        return $this->hasMany(CategoriesSetting::class, 'module_template_id');
    //    }
    //
    //    public function categories_settings_sites()
    //    {
    //        return $this->hasMany(CategoriesSettingsSite::class, 'module_template_id');
    //    }
    //
    //    public function categories_settings_templates()
    //    {
    //        return $this->hasMany(CategoriesSettingsTemplate::class, 'module_template_id');
    //    }
}
