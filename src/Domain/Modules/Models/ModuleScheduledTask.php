<?php

namespace Domain\Modules\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModulesCronsScheduledtask
 *
 * @property int $id
 * @property int $task_type
 * @property int $task_start
 * @property Carbon $task_startdate
 * @property bool $task_status
 * @property int $task_remaining
 * @property int $task_modified
 *
 * @package Domain\Modules\Models
 */
class ModuleScheduledTask extends Model
{
    public $timestamps = false;
    protected $table = 'modules_crons_scheduledtasks';

    protected $casts = [
        'task_type' => 'int',
        'task_start' => 'int',
        'task_status' => 'bool',
        'task_remaining' => 'int',
        'task_modified' => 'int',
        'task_startdate' => 'datetime',
    ];

    protected $fillable = [
        'task_type',
        'task_start',
        'task_startdate',
        'task_status',
        'task_remaining',
        'task_modified',
    ];
}
