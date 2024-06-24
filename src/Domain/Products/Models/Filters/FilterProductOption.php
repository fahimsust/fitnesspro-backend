<?php

namespace Domain\Products\Models\Filters;

use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

/**
 * Class FiltersProductoption
 *
 * @property int $id
 * @property string $option_name
 * @property int $filter_id
 * @property string $label
 * @property int $rank
 * @property bool $status
 *
 * @property Filter $filter
 *
 * @package Domain\Filters\Models
 */
class FilterProductOption extends Model
{
    use HasModelUtilities;

    public $timestamps = false;
    protected $table = 'filters_productoptions';

    protected $casts = [
        'filter_id' => 'int',
        'rank' => 'int',
        'status' => 'bool',
    ];

    protected $fillable = [
        'option_name',
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
