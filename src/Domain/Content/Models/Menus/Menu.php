<?php

namespace Domain\Content\Models\Menus;

use Domain\Content\Models\Pages\Page;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Menu
 *
 * @property int $id
 * @property string $name
 * @property string $url_name
 * @property bool $status
 *
 * @property Collection|array<MenusCatalogCategories> $menus_catalogcategories
 * @property Collection|array<MenusPageCategories> $menus_categories
 * @property Collection|array<MenusLinks> $menus_links
 * @property Collection|array<MenusSubMenus> $menus_menus
 * @property Collection|array<Page> $pages
 * @property Collection|array<Site> $sites
 *
 * @package Domain\Menus\Models
 */
class Menu extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'menus';

    protected $casts = [
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'url_name',
        'status',
    ];

    public function catalogCategories()
    {
        return $this->hasMany(MenusCatalogCategories::class);
    }

    public function categories()
    {
        return $this->hasMany(MenusPageCategories::class);
    }

    public function links()
    {
        return $this->hasMany(MenusLinks::class);
    }

    public function childMenus()
    {
        return $this->hasMany(MenusSubMenus::class);
    }

    public function pages()
    {
        //todo
        return $this->hasManyThrough(
            Page::class,
            MenusPages::class,
        )
            ->withPivot('id', 'rank', 'target', 'sub_pagemenu_id', 'sub_categorymenu_id');
    }

    public function sites()
    {
        //todo
        return $this->hasManyThrough(
            Site::class,
            MenusSites::class,
        )
            ->withPivot('rank');
    }
}
