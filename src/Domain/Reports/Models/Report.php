<?php

namespace Domain\Reports\Models;

use Carbon\Carbon;
use Domain\Reports\Actions\ConvertCriteria;
use Domain\Reports\Enums\ReportReady;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class Report
 *
 * @property int $id
 * @property string $name
 * @property Carbon $created
 * @property string $criteria
 * @property int $type_id
 * @property Carbon $from_date
 * @property Carbon $to_date
 * @property int $breakdown
 * @property int $restart
 * @property string $variables
 * @property Carbon $modified
 *
 * @package Domain\Reports\Models
 */
class Report extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;
    protected $table = 'reports';
    protected $appends = ['ready_label'];

    protected $casts = [
        'type_id' => 'int',
        'ready' => ReportReady::class,
        'criteria' => 'array',
        'breakdown' => 'int',
        'restart' => 'int',
        'created' => 'datetime',
        'from_date' => 'datetime:Y-m-d H:i:s',
        'to_date' => 'datetime:Y-m-d H:i:s',
        'modified' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'created',
        'criteria',
        'type_id',
        'ready',
        'from_date',
        'to_date',
        'breakdown',
        'restart',
        'variables',
        'modified',
    ];

    public function getReadyLabelAttribute(): string
    {
        return ReportReady::from($this->attributes['ready'])
            ->label();
    }

    public function type()
    {
        return $this->belongsTo(
            ReportType::class,
            'type_id'
        );
    }
}
