<?php

namespace Support\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FailedJob
 *
 * @property int $id
 * @property string $uuid
 * @property string $connection
 * @property string $queue
 * @property string $payload
 * @property string $exception
 * @property Carbon $failed_at
 *
 * @package Domain\Others\Models
 */
class FailedJob extends Model
{
    public $timestamps = false;
    protected $table = 'failed_jobs';

    protected $casts = [
        'failed_at' => 'datetime',
    ];

    protected $fillable = [
        'uuid',
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at',
    ];
}
