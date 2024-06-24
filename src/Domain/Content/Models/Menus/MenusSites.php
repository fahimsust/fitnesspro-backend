<?php

namespace Domain\Content\Models\Menus;

use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MenusSite
 *
 * @property int $menu_id
 * @property int $site_id
 * @property int $rank
 *
 * @property Menu $menu
 * @property Site $site
 *
 * @package Domain\Menus\Models
 */
class MenusSites extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'menus_sites';

    protected $casts = [
        'menu_id' => 'int',
        'site_id' => 'int',
        'rank' => 'int',
    ];

    protected $fillable = [
        'menu_id',
        'site_id',
        'rank',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
