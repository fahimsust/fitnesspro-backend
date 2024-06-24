<?php

namespace Domain\Content\Models\Pages;

use Domain\Content\Models\Menus\Menu;
use Domain\Content\Models\Menus\MenusPages;
use Domain\Content\QueryBuilders\PageQuery;
use Domain\Modules\Models\Module;
use Domain\Modules\Models\ModuleField;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Page
 *
 * @property int $id
 * @property string $title
 * @property string $url_name
 * @property string $content
 * @property string $notes
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property bool $status
 *
 * @property Collection|array<Menu> $menus
 * @property PagesCategories $pages_categories_page
 * @property PageSetting $pages_setting
 * @property Collection|array<Site> $sites
 * @property Collection|array<Module> $modules
 *
 * @package Domain\Pages\Models
 */
class Page extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'pages';

    protected $casts = [
        'status' => 'bool',
    ];

    public function newEloquentBuilder($query)
    {
        return new PageQuery($query);
    }

    public function menus()
    {
        return $this->belongsToMany(
            Menu::class,
            MenusPages::class,
            'page_id',
            'menu_id'
        )
            ->withPivot('id', 'rank', 'target', 'sub_pagemenu_id', 'sub_categorymenu_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            PageCategory::class,
            PagesCategories::class,
            'page_id',
            'category_id'
        );
    }
    public function pagesCategories()
    {
        return $this->hasMany(
            PagesCategories::class
        );
    }
    public function translations()
    {
        return $this->hasMany(
            PageTranslation::class
        );
    }
    public function sitePageSettings()
    {
        return $this->hasMany(
            SitePageSettings::class
        );
    }

    public function sitePageSettingsModuleValue()
    {
        return $this->hasMany(
            SitePageSettingsModuleValue::class
        );
    }
    public function menusPages()
    {
        return $this->hasMany(
            MenusPages::class
        );
    }

    public function defaultSettings()
    {
        return $this->hasOne(PageSetting::class);
    }

    public function siteSettings()
    {
        return $this->belongsToMany(
            Site::class,
            SitePageSettings::class,
            'page_id',
            'site_id'
        )
            ->withPivot('id', 'settings_template_id', 'layout_id', 'module_template_id');
    }

    public function templateModuleSettings()
    {
        //todo
        return $this->hasManyThrough(
            ModuleField::class,
            SettingsTemplateModuleValue::class,
        )
            ->withPivot('id', 'site_id', 'section_id', 'field_id', 'custom_value');
    }

    public function siteModuleSettings()
    {
        //todo
        return $this->hasManyThrough(
            ModuleField::class,
            SitePageSettingsModuleValue::class,
        )
            ->withPivot('id', 'site_id', 'section_id', 'field_id', 'custom_value');
    }
}
