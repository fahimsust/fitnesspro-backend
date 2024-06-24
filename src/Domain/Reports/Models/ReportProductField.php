<?php

namespace Domain\Reports\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReportsProductsField
 *
 * @property int $id
 * @property string $name
 * @property string $reference
 *
 * @package Domain\Reports\Models
 */
class ReportProductField extends Model
{
    public $timestamps = false;
    protected $table = 'reports_products_fields';

    protected $fillable = [
        'name',
        'reference',
    ];
}
