<?php

namespace Domain\AdminUsers\Models;

use Domain\Content\Models\Menus\Menu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminLevel
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|array<Menu> $menus
 * @property Collection|array<AdminUser> $admin_users
 *
 * @package Domain\AdminUsers\Models
 */
class AdminLevel extends Model
{
    public $timestamps = false;
    protected $table = 'admin_levels';

    protected $fillable = [
        'name',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'admin_levels_menus', 'level_id');
    }

    public function users()
    {
        return $this->hasMany(AdminUser::class, 'level_id');
    }
}
