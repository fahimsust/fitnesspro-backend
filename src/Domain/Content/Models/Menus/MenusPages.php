<?php

namespace Domain\Content\Models\Menus;

use Domain\Content\Models\Pages\Page;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class MenusPage
 *
 * @property int $id
 * @property int $menu_id
 * @property int $page_id
 * @property int $rank
 * @property string $target
 * @property int $sub_pagemenu_id
 * @property int $sub_categorymenu_id
 *
 * @property Menu $menu
 * @property Page $page
 *
 * @package Domain\Menus\Models
 */
class MenusPages extends Model
{
    use HasFactory,
        HasModelUtilities;
    protected $table = 'menus_pages';

    protected $casts = [
        'menu_id' => 'int',
        'page_id' => 'int',
        'rank' => 'int',
        'sub_pagemenu_id' => 'int',
        'sub_categorymenu_id' => 'int',
    ];

    protected $fillable = [
        'menu_id',
        'page_id',
        'rank',
        'target',
        'sub_pagemenu_id',
        'sub_categorymenu_id',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
