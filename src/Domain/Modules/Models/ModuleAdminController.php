<?php

namespace Domain\Modules\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModulesAdminController
 *
 * @property int $id
 * @property int $module_id
 * @property string $controller_section
 *
 * @property Module $module
 *
 * @package Domain\Modules\Models
 */
class ModuleAdminController extends Model
{
    public $timestamps = false;
    protected $table = 'modules_admin_controllers';

    protected $casts = [
        'module_id' => 'int',
    ];

    protected $fillable = [
        'module_id',
        'controller_section',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
