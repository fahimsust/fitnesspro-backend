<?php

namespace Domain\Modules\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModulesSiteController
 *
 * @property int $id
 * @property int $module_id
 * @property string $controller_section
 * @property bool $showinmenu
 * @property string $menu_label
 * @property string $menu_link
 * @property string $url_name
 *
 * @property Module $module
 *
 * @package Domain\Modules\Models
 */
class ModuleSiteController extends Model
{
    public $timestamps = false;
    protected $table = 'modules_site_controllers';

    protected $casts = [
        'module_id' => 'int',
        'showinmenu' => 'bool',
    ];

    protected $fillable = [
        'module_id',
        'controller_section',
        'showinmenu',
        'menu_label',
        'menu_link',
        'url_name',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
