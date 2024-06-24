<?php

namespace Domain\Reports\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReportsType
 *
 * @property int $id
 * @property string $name
 *
 * @package Domain\Reports\Models
 */
class ReportType extends Model
{
    public $timestamps = false;
    protected $table = 'reports_types';

    protected $fillable = [
        'name',
    ];
}
