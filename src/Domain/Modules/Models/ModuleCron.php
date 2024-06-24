<?php

namespace Domain\Modules\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModulesCron
 *
 * @property int $id
 * @property int $module_id
 * @property bool $type
 * @property string $function
 * @property Carbon $last_run
 * @property bool $status
 *
 * @property Module $module
 *
 * @package Domain\Modules\Models
 */
class ModuleCron extends Model
{
    public $timestamps = false;
    protected $table = 'modules_crons';

    protected $casts = [
        'module_id' => 'int',
        'type' => 'bool',
        'status' => 'bool',
        'last_run' => 'datetime',
    ];

    protected $fillable = [
        'module_id',
        'type',
        'function',
        'last_run',
        'status',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
