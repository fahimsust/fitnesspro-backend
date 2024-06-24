<?php

namespace Domain\Content\Models\Menus;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MenusMenu
 *
 * @property int $id
 * @property int $menu_id
 * @property int $child_menu_id
 * @property int $rank
 *
 * @property Menu $menu
 *
 * @package Domain\Menus\Models
 */
class MenusSubMenus extends Model
{
    public $timestamps = false;
    protected $table = 'menus_menus';

    protected $casts = [
        'menu_id' => 'int',
        'child_menu_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'menu_id',
        'child_menu_id',
        'rank',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class);
    }

    public function child()
    {
        return $this->belongsTo(
            Menu::class,
            'child_menu_id'
        );
    }
}
