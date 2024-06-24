<?php

namespace Domain\Products\Models\Filters;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FiltersAvailability
 *
 * @property int $id
 * @property string $avail_ids
 * @property int $filter_id
 * @property string $label
 * @property int $rank
 * @property bool $status
 *
 * @property Filter $filter
 *
 * @package Domain\Filters\Models
 */
class FilterAvailability extends Model
{
    public $timestamps = false;
    protected $table = 'filters_availabilities';

    protected $casts = [
        'filter_id' => 'int',
        'rank' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'avail_ids',
        'filter_id',
        'label',
        'rank',
        'status',
    ];

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}
