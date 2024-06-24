<?php

namespace Domain\Content\Models\Menus;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MenusLink
 *
 * @property int $id
 * @property int $menu_id
 * @property int $links_id
 * @property int $rank
 *
 * @property MenuLink $menu_link
 * @property Menu $menu
 *
 * @package Domain\Menus\Models
 */
class MenusLinks extends Model
{
    public $timestamps = false;
    protected $table = 'menus_links';

    protected $casts = [
        'menu_id' => 'int',
        'links_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'menu_id',
        'links_id',
        'rank',
    ];

    public function menu()
    {
        return $this->belongsTo(
            Menu::class,
            'menu_id'
        );
    }

    public function link()
    {
        return $this->belongsTo(
            MenuLink::class,
            'links_id'
        );
    }
}
