<?php

namespace Domain\Content\Models\Menus;

use Domain\Content\Models\Pages\PageCategory;
use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MenusCategory
 *
 * @property int $id
 * @property int $menu_id
 * @property int $category_id
 * @property int $rank
 *
 * @property Category $category
 * @property Menu $menu
 *
 * @package Domain\Menus\Models
 */
class MenusPageCategories extends Model
{
    public $timestamps = false;
    protected $table = 'menus_categories';

    protected $casts = [
        'menu_id' => 'int',
        'category_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'menu_id',
        'category_id',
        'rank',
    ];

    public function category()
    {
        return $this->belongsTo(
            PageCategory::class,
            'category_id'
        );
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
