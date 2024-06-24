<?php

namespace Domain\AdminUsers\Models;

use Domain\Content\Models\Menus\Menu;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminLevelsMenu
 *
 * @property int $level_id
 * @property int $menu_id
 *
 * @property AdminLevel $admin_level
 * @property Menu $menu
 *
 * @package Domain\AdminUsers\Models
 */
class AdminLevelMenu extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'admin_levels_menus';

    protected $casts = [
        'level_id' => 'int',
        'menu_id' => 'int',
    ];

    protected $fillable = [
        'level_id',
        'menu_id',
    ];

    public function level()
    {
        return $this->belongsTo(AdminLevel::class, 'level_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
