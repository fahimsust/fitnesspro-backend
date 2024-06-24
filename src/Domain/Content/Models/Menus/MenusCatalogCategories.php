<?php

namespace Domain\Content\Models\Menus;

use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MenusCatalogcategory
 *
 * @property int $id
 * @property int $menu_id
 * @property int $category_id
 * @property int $rank
 * @property int $submenu_levels
 *
 * @property Category $category
 * @property Menu $menu
 *
 * @package Domain\Menus\Models
 */
class MenusCatalogCategories extends Model
{
    public $timestamps = false;
    protected $table = 'menus_catalogcategories';

    protected $casts = [
        'menu_id' => 'int',
        'category_id' => 'int',
        'rank' => 'int',
        'submenu_levels' => 'int',
    ];

    protected $fillable = [
        'menu_id',
        'category_id',
        'rank',
        'submenu_levels',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
