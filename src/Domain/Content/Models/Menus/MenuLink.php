<?php

namespace Domain\Content\Models\Menus;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MenuLink
 *
 * @property int $id
 * @property bool $link_type
 * @property string $label
 * @property string $target
 * @property string $url_link
 * @property int $system_link
 * @property string $javascript_link
 * @property bool $status
 *
 * @property Collection|array<MenusLinks> $menus_links
 *
 * @package Domain\Menus\Models
 */
class MenuLink extends Model
{
    public $timestamps = false;
    protected $table = 'menu_links';

    protected $casts = [
        'link_type' => 'bool',
        'system_link' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'link_type',
        'label',
        'target',
        'url_link',
        'system_link',
        'javascript_link',
        'status',
    ];

    public function menus()
    {
        //todo
        return $this->hasManyThrough(
            Menu::class,
            MenusLinks::class,
        );
    }
}
