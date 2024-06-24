<?php

namespace Domain\Reports\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReportsBreakdown
 *
 * @property int $id
 * @property string $name
 *
 * @package Domain\Reports\Models
 */
class ReportBreakdown extends Model
{
    public $timestamps = false;
    protected $table = 'reports_breakdowns';

    protected $fillable = [
        'name',
    ];
}
